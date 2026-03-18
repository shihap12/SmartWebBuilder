<?php
require_once __DIR__ . '/../config/database.php';

class Analytics
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = get_pdo();
    }

    public function recordVisit($projectId, $visitorIp = null, $country = null, $referrer = null)
    {
        $stmt = $this->pdo->prepare('INSERT INTO project_analytics (project_id, visitor_ip, country, referrer) VALUES (?, ?, ?, ?)');
        return $stmt->execute([$projectId, $visitorIp, $country, $referrer]);
    }

    public function getStats($projectId, $since = null)
    {
        $sql = 'SELECT COUNT(*) as visits, MIN(visited_at) as first_visit, MAX(visited_at) as last_visit FROM project_analytics WHERE project_id = ?';
        $params = [$projectId];
        if ($since) {
            $sql .= ' AND visited_at >= ?';
            $params[] = $since;
        }
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch();
    }
}
