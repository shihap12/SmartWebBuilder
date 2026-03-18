<?php
function json_response($data, $status = 200)
{
    http_response_code($status);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data);
    exit;
}

function error_response($message = 'Error', $status = 400)
{
    json_response(['error' => $message], $status);
}
