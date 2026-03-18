<?php
require_once __DIR__ . '/../config/database.php';

class Revision
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = get_pdo();
    }

    public function saveSnapshot($projectId, $snapshot)
    {
        $stmt = $this->pdo->prepare('INSERT INTO project_revisions (project_id, content_snapshot) VALUES (?, ?)');
        return $stmt->execute([$projectId, json_encode($snapshot)]);
    }

    public function listByProject($projectId, $limit = 50)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM project_revisions WHERE project_id = ? ORDER BY created_at DESC LIMIT ?');
        $stmt->bindValue(1, $projectId, PDO::PARAM_INT);
        $stmt->bindValue(2, (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
