<?php
// Simple rate limiter using file storage per IP
function rate_limit_check($key = null, $limit = 100, $window = 60)
{
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
    $key = $key ?: $ip;
    $dir = sys_get_temp_dir() . '/swb_rate';
    if (!is_dir($dir)) @mkdir($dir, 0700, true);
    $file = $dir . '/' . md5($key) . '.json';
    $now = time();
    $data = ['count' => 0, 'start' => $now];
    if (file_exists($file)) {
        $json = @file_get_contents($file);
        $d = @json_decode($json, true);
        if ($d) $data = $d;
    }
    if ($now - $data['start'] > $window) {
        $data = ['count' => 0, 'start' => $now];
    }
    $data['count']++;
    file_put_contents($file, json_encode($data));
    if ($data['count'] > $limit) return false;
    return true;
}
