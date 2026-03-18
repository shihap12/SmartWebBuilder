<?php
require_once __DIR__ . '/../config/database.php';

class Template
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = get_pdo();
    }

    public function listPublic()
    {
        $stmt = $this->pdo->prepare('SELECT id, name, thumbnail, is_public, created_at FROM templates WHERE is_public = 1 ORDER BY created_at DESC');
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function get($id)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM templates WHERE id = ? LIMIT 1');
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function save($name, $thumbnail, $baseJson, $isPublic, $createdBy)
    {
        $stmt = $this->pdo->prepare('INSERT INTO templates (name, thumbnail, base_json, is_public, created_by) VALUES (?, ?, ?, ?, ?)');
        $stmt->execute([$name, $thumbnail, $baseJson, $isPublic ? 1 : 0, $createdBy]);
        return $this->get($this->pdo->lastInsertId());
    }
}
