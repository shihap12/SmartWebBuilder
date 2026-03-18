<?php
require_once __DIR__ . '/../models/Analytics.php';
require_once __DIR__ . '/../helpers/response.php';

class AnalyticsController
{
    private $analyticsModel;

    public function __construct()
    {
        $this->analyticsModel = new Analytics();
    }

    public function record()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        if (empty($data['project_id'])) error_response('Invalid payload', 400);
        $ip = $_SERVER['REMOTE_ADDR'] ?? null;
        $this->analyticsModel->recordVisit($data['project_id'], $ip, $data['country'] ?? null, $data['referrer'] ?? null);
        json_response(['ok' => true]);
    }

    public function stats($projectId)
    {
        $since = $_GET['since'] ?? null;
        $stats = $this->analyticsModel->getStats($projectId, $since);
        json_response($stats);
    }
}
