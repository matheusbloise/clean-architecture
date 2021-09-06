<?php

use App\Application\Usecases\ExportRegistration\InputBoundary;
use App\Infrastructure\Http\Controllers\ExportRegistrationController;

require_once __DIR__ . "/../vendor/autoload.php";
$container = require_once __DIR__ . "/../config/dependencies.php";

$inputBoundary = new InputBoundary('01234567890', 'dom-pdf-exporter.pdf', __DIR__ . '/../storage/registrations');
$controller = $container->get(ExportRegistrationController::class);

echo $controller
    ->handle($inputBoundary)
    ->getBody();
