<?php
$requestPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);

if ($requestPath === '/' || $requestPath === '/index.php') {
    require __DIR__ . '/public/index.php';
    return true;
}

// Let PHP's built-in server serve frontend files such as report.html and assets.
return false;
