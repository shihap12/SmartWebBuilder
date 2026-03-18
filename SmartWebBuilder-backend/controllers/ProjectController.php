<?php
require_once __DIR__ . '/../models/Project.php';
require_once __DIR__ . '/../models/Revision.php';
require_once __DIR__ . '/../helpers/response.php';

class ProjectController
{
    private $projectModel;
    private $revisionModel;

    public function __construct()
    {
        $this->projectModel = new Project();
        $this->revisionModel = new Revision();
    }

    public function create()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        if (empty($data['user_id']) || empty($data['title']) || empty($data['slug'])) error_response('Invalid payload', 400);
        $project = $this->projectModel->create($data['user_id'], $data['template_id'] ?? null, $data['title'], $data['slug']);
        json_response($project, 201);
    }

    public function get($id)
    {
        $p = $this->projectModel->get($id);
        if (!$p) error_response('Not found', 404);
        json_response($p);
    }

    public function listByUser($userId)
    {
        json_response($this->projectModel->listByUser($userId));
    }

    public function update($id)
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $p = $this->projectModel->update($id, $data);
        if (!$p) error_response('Update failed', 500);
        // save revision snapshot if content provided
        if (!empty($data['content_snapshot'])) {
            $this->revisionModel->saveSnapshot($id, $data['content_snapshot']);
        }
        json_response($p);
    }

    public function delete($id)
    {
        $ok = $this->projectModel->delete($id);
        json_response(['ok' => (bool)$ok]);
    }

    public function publish($id)
    {
        $ok = $this->projectModel->publish($id);
        json_response(['ok' => (bool)$ok]);
    }

    public function export($id)
    {
        $html = $this->projectModel->exportHtml($id);
        if (!$html) error_response('Export failed', 500);
        header('Content-Type: text/html; charset=utf-8');
        echo $html;
        exit;
    }
}
