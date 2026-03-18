<?php
require_once __DIR__ . '/../models/Template.php';
require_once __DIR__ . '/../helpers/response.php';

class TemplateController
{
    private $templateModel;

    public function __construct()
    {
        $this->templateModel = new Template();
    }

    public function marketplace()
    {
        json_response($this->templateModel->listPublic());
    }

    public function get($id)
    {
        $t = $this->templateModel->get($id);
        if (!$t) error_response('Not found', 404);
        json_response($t);
    }

    public function save()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        if (empty($data['name']) || empty($data['base_json']) || empty($data['created_by'])) error_response('Invalid payload', 400);
        $t = $this->templateModel->save($data['name'], $data['thumbnail'] ?? null, json_encode($data['base_json']), $data['is_public'] ?? 0, $data['created_by']);
        json_response($t, 201);
    }
}
