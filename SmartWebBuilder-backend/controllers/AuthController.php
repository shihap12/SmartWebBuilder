<?php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../helpers/response.php';
require_once __DIR__ . '/../helpers/ratelimit.php';

class AuthController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function register()
    {
        if (!rate_limit_check('auth_register', 10, 60)) {
            error_response('Too many requests', 429);
        }
        $data = json_decode(file_get_contents('php://input'), true);
        if (empty($data['name']) || empty($data['email']) || empty($data['password'])) {
            error_response('Invalid payload', 400);
        }
        $existing = $this->userModel->findByEmail($data['email']);
        if ($existing) error_response('Email already registered', 409);
        $user = $this->userModel->create($data['name'], $data['email'], $data['password']);
        json_response(['user' => $user], 201);
    }

    public function login()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        if (empty($data['email']) || empty($data['password'])) error_response('Invalid payload', 400);
        $res = $this->userModel->authenticate($data['email'], $data['password']);
        if (!$res) error_response('Invalid credentials or email not verified', 401);
        json_response($res);
    }

    public function verify()
    {
        $token = $_GET['token'] ?? null;
        if (!$token) error_response('Missing token', 400);
        $ok = $this->userModel->verifyByToken($token);
        if (!$ok) error_response('Invalid token', 400);
        json_response(['ok' => true]);
    }

    public function forgot()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        if (empty($data['email'])) error_response('Invalid payload', 400);
        $this->userModel->requestPasswordReset($data['email']);
        json_response(['ok' => true]);
    }

    public function reset()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        if (empty($data['token']) || empty($data['password'])) error_response('Invalid payload', 400);
        $ok = $this->userModel->resetPassword($data['token'], $data['password']);
        if (!$ok) error_response('Invalid or expired token', 400);
        json_response(['ok' => true]);
    }
}
