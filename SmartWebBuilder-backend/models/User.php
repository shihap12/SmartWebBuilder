<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../helpers/jwt.php';
require_once __DIR__ . '/../helpers/mailer.php';

class User
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = get_pdo();
    }

    public function findByEmail($email)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE email = ? LIMIT 1');
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    public function create($name, $email, $password)
    {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $token = bin2hex(random_bytes(16));
        $stmt = $this->pdo->prepare('INSERT INTO users (name, email, password, verification_token) VALUES (?, ?, ?, ?)');
        $stmt->execute([$name, $email, $hash, $token]);
        $id = $this->pdo->lastInsertId();
        // send verification email
        $verifyUrl = (getenv('APP_URL') ?: 'http://localhost') . '/api/auth/verify?token=' . $token;
        $body = "Hello $name,<br><br>Please verify your email: <a href=\"$verifyUrl\">Verify</a>";
        send_email($email, 'Verify your email', $body);
        return $this->find($id);
    }

    public function find($id)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE id = ? LIMIT 1');
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function verifyByToken($token)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE verification_token = ? LIMIT 1');
        $stmt->execute([$token]);
        $user = $stmt->fetch();
        if (!$user) return false;
        $u2 = $this->pdo->prepare('UPDATE users SET email_verified = 1, verification_token = NULL WHERE id = ?');
        $u2->execute([$user['id']]);
        return true;
    }

    public function authenticate($email, $password)
    {
        $user = $this->findByEmail($email);
        if (!$user) return null;
        if (!password_verify($password, $user['password'])) return null;
        if (!$user['email_verified']) return null;
        $token = jwt_encode(['sub' => $user['id']]);
        return ['user' => $user, 'token' => $token];
    }

    public function requestPasswordReset($email)
    {
        $user = $this->findByEmail($email);
        if (!$user) return false;
        $token = bin2hex(random_bytes(16));
        $expires = date('Y-m-d H:i:s', time() + 3600);
        $stmt = $this->pdo->prepare('UPDATE users SET reset_token = ?, reset_expires = ? WHERE id = ?');
        $stmt->execute([$token, $expires, $user['id']]);
        $resetUrl = (getenv('APP_URL') ?: 'http://localhost') . '/reset?token=' . $token;
        $body = "Hello {$user['name']},<br><br>Reset your password: <a href=\"$resetUrl\">Reset</a>";
        send_email($email, 'Password reset', $body);
        return true;
    }

    public function resetPassword($token, $newPassword)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE reset_token = ? LIMIT 1');
        $stmt->execute([$token]);
        $user = $stmt->fetch();
        if (!$user) return false;
        if (isset($user['reset_expires']) && strtotime($user['reset_expires']) < time()) return false;
        $hash = password_hash($newPassword, PASSWORD_DEFAULT);
        $u2 = $this->pdo->prepare('UPDATE users SET password = ?, reset_token = NULL, reset_expires = NULL WHERE id = ?');
        $u2->execute([$hash, $user['id']]);
        return true;
    }
}
