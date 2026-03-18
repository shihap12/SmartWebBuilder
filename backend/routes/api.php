<?php
require_once __DIR__ . '/../controllers/AuthController.php';
require_once __DIR__ . '/../controllers/ProjectController.php';
require_once __DIR__ . '/../controllers/TemplateController.php';
require_once __DIR__ . '/../controllers/AnalyticsController.php';
require_once __DIR__ . '/../controllers/AIController.php';

function handle_request($method, $uri)
{
    $parts = array_filter(explode('/', $uri));
    $parts = array_values($parts);

    // Basic routing: /api/{resource}/{id?}
    if (count($parts) === 0) {
        http_response_code(200);
        echo json_encode(['ok' => true]);
        exit;
    }

    $resource = $parts[0];
    $id = $parts[1] ?? null;

    switch ($resource) {
        case 'api':
            $sub = $parts[1] ?? null;
            $sub2 = $parts[2] ?? null;
            // auth routes
            if ($sub === 'auth') {
                $auth = new AuthController();
                if ($method === 'POST' && $sub2 === 'register') return $auth->register();
                if ($method === 'POST' && $sub2 === 'login') return $auth->login();
                if ($method === 'GET' && $sub2 === 'verify') return $auth->verify();
                if ($method === 'POST' && $sub2 === 'forgot') return $auth->forgot();
                if ($method === 'POST' && $sub2 === 'reset') return $auth->reset();
            }

            if ($sub === 'projects') {
                $pc = new ProjectController();
                if ($method === 'POST' && !$sub2) return $pc->create();
                if ($method === 'GET' && $sub2 === 'list' && isset($parts[3])) return $pc->listByUser($parts[3]);
                if ($method === 'GET' && is_numeric($sub2)) return $pc->get((int)$sub2);
                if (($method === 'PUT' || $method === 'PATCH') && is_numeric($sub2)) return $pc->update((int)$sub2);
                if ($method === 'DELETE' && is_numeric($sub2)) return $pc->delete((int)$sub2);
                if ($method === 'POST' && is_numeric($sub2) && $parts[3] === 'publish') return $pc->publish((int)$sub2);
                if ($method === 'GET' && is_numeric($sub2) && $parts[3] === 'export') return $pc->export((int)$sub2);
            }

            if ($sub === 'templates') {
                $tc = new TemplateController();
                if ($method === 'GET' && $sub2 === 'marketplace') return $tc->marketplace();
                if ($method === 'GET' && is_numeric($sub2)) return $tc->get((int)$sub2);
                if ($method === 'POST' && $sub2 === 'save') return $tc->save();
            }

            if ($sub === 'analytics') {
                $ac = new AnalyticsController();
                if ($method === 'POST' && $sub2 === 'record') return $ac->record();
                if ($method === 'GET' && $sub2 === 'stats' && isset($parts[3]) && is_numeric($parts[3])) return $ac->stats((int)$parts[3]);
            }

            if ($sub === 'ai') {
                $ai = new AIController();
                if ($method === 'POST' && $sub2 === 'generate') return $ai->generate();
            }

            http_response_code(404);
            echo json_encode(['error' => 'Not found']);
            exit;
    }
}
