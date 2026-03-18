<?php
require_once __DIR__ . '/../helpers/response.php';

class AIController
{
    private $apiKey;

    public function __construct()
    {
        $this->apiKey = getenv('CLAUDE_API_KEY') ?: null;
    }

    public function generate()
    {
        if (!$this->apiKey) error_response('AI API key not configured', 500);
        $data = json_decode(file_get_contents('php://input'), true);
        if (empty($data['prompt'])) error_response('Missing prompt', 400);

        $payload = [
            'prompt' => $data['prompt'],
            'max_tokens' => $data['max_tokens'] ?? 300
        ];

        $ch = curl_init('https://api.anthropic.com/v1/complete');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $this->apiKey
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        $resp = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);
        if ($err) error_response('AI request failed: ' . $err, 500);
        $decoded = json_decode($resp, true);
        json_response($decoded);
    }
}
