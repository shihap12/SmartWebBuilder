<?php
// Minimal JWT helper using HMAC-SHA256
function jwt_encode(array $payload, $exp = 3600): string
{
    $header = ['alg' => 'HS256', 'typ' => 'JWT'];
    $payload['iat'] = time();
    $payload['exp'] = time() + $exp;
    $segments = [];
    $segments[] = rtrim(strtr(base64_encode(json_encode($header)), '+/', '-_'), '=');
    $segments[] = rtrim(strtr(base64_encode(json_encode($payload)), '+/', '-_'), '=');
    $signing_input = implode('.', $segments);
    $sig = hash_hmac('sha256', $signing_input, getenv('JWT_SECRET') ?: 'dev_secret', true);
    $segments[] = rtrim(strtr(base64_encode($sig), '+/', '-_'), '=');
    return implode('.', $segments);
}

function jwt_decode(string $token)
{
    $parts = explode('.', $token);
    if (count($parts) !== 3) return null;
    list($headb64, $bodyb64, $cryptob64) = $parts;
    $header = json_decode(base64_decode(strtr($headb64, '-_', '+/')), true);
    $payload = json_decode(base64_decode(strtr($bodyb64, '-_', '+/')), true);
    $sig = base64_decode(strtr($cryptob64, '-_', '+/'));
    $valid = hash_hmac('sha256', $headb64 . '.' . $bodyb64, getenv('JWT_SECRET') ?: 'dev_secret', true);
    if (!hash_equals($valid, $sig)) return null;
    if (isset($payload['exp']) && time() > $payload['exp']) return null;
    return $payload;
}
