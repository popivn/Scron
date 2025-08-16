<?php
// web.php
require_once __DIR__ . '/controller/CronController.php';

$request = $_GET['page'] ?? 'list';

$controller = new CronController($pdo);

switch ($request) {
    case 'create':
        $controller->create();
        break;
    case 'list':
    default:
        $controller->list();
        break;
}
