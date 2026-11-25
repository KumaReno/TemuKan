<?php
declare(strict_types=1);

require_once __DIR__ . '/../src/models/Item.php';
require_once __DIR__ . '/../src/models/ItemRepository.php';
require_once __DIR__ . '/../src/controllers/HomeController.php';

$controller = new HomeController(new ItemRepository());
$controller->index();
