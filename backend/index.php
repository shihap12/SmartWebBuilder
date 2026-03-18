<?php
require_once __DIR__ . '/config/cors.php';
require_once __DIR__ . '/routes/api.php';

// Simple front controller: all API requests routed through routes/api.php
$method = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Trim script path prefix if running in subfolder
$scriptName = dirname($_SERVER['SCRIPT_NAME']);
if ($scriptName !== '/') {
    $uri = preg_replace('#^' . preg_quote($scriptName) . '#', '', $uri);
}

handle_request($method, $uri);

// end
