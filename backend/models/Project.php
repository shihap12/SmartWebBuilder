<?php
require_once __DIR__ . '/../config/database.php';

class Project
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = get_pdo();
    }

    public function create($userId, $templateId, $title, $slug)
    {
        $stmt = $this->pdo->prepare('INSERT INTO projects (user_id, template_id, title, slug) VALUES (?, ?, ?, ?)');
        $stmt->execute([$userId, $templateId, $title, $slug]);
        return $this->get($this->pdo->lastInsertId());
    }

    public function get($id)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM projects WHERE id = ? LIMIT 1');
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function listByUser($userId)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM projects WHERE user_id = ? ORDER BY created_at DESC');
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    public function update($id, $data)
    {
        $fields = [];
        $values = [];
        foreach ($data as $k => $v) {
            $fields[] = "$k = ?";
            $values[] = $v;
        }
        $values[] = $id;
        $sql = 'UPDATE projects SET ' . implode(', ', $fields) . ' WHERE id = ?';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($values);
        return $this->get($id);
    }

    public function delete($id)
    {
        $stmt = $this->pdo->prepare('DELETE FROM projects WHERE id = ?');
        return $stmt->execute([$id]);
    }

    public function publish($id)
    {
        $stmt = $this->pdo->prepare('UPDATE projects SET is_published = 1, published_at = NOW() WHERE id = ?');
        return $stmt->execute([$id]);
    }

    public function exportHtml($id)
    {
        // simple export: fetch content and assemble minimal HTML
        $stmt = $this->pdo->prepare('SELECT p.*, pc.element_key, pc.element_value FROM projects p LEFT JOIN project_content pc ON p.id = pc.project_id WHERE p.id = ?');
        $stmt->execute([$id]);
        $rows = $stmt->fetchAll();
        if (empty($rows)) return null;
        $project = $rows[0];
        $content = [];
        foreach ($rows as $r) {
            if ($r['element_key']) $content[$r['element_key']] = json_decode($r['element_value'], true);
        }
        $title = htmlspecialchars($project['title']);
        $body = '<div id="swb-root">' . htmlspecialchars(json_encode($content)) . '</div>';
        return "<!doctype html><html><head><meta charset=\"utf-8\"><meta name=\"viewport\" content=\"width=device-width,initial-scale=1\"><title>$title</title></head><body>$body</body></html>";
    }
}
