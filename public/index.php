<?php

use App\Application\Usecases\ExportRegistration\ExportRegistration;
use App\Application\Usecases\ExportRegistration\InputBoundary;
use App\Infrastructure\Adapters\DomPdfAdapter;
use App\Infrastructure\Adapters\LocalStorageAdapter;
use App\Infrastructure\Http\Controllers\ExportRegistrationController;
use App\Infrastructure\Repositories\MySQL\PdoRegistrationRepository;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;

require_once __DIR__ . "/../vendor/autoload.php";

//Dependencies
$appConfig = require_once __DIR__ . '/../config/app.php';
$dsn = sprintf(
    'mysql:host=%s;port=%s;dbname=%s;charset=%s',
    $appConfig['db']['host'],
    $appConfig['db']['port'],
    $appConfig['db']['dbname'],
    $appConfig['db']['charset']
);
$pdo = new PDO($dsn, $appConfig['db']['username'], $appConfig['db']['password'], [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_PERSISTENT => TRUE
]);

// Adapters
$loadRegistrationRepository = new PdoRegistrationRepository($pdo);
//$pdfExporter = new Html2PdfAdapter();
$pdfExporter = new DomPdfAdapter();
$storage = new LocalStorageAdapter();

//Use Cases "better known as" Services
$exportRegistrationUseCase = new ExportRegistration($loadRegistrationRepository, $pdfExporter, $storage);

$request = new Request('GET', 'http://localhost:8080');
$response = new Response();
$controller = new ExportRegistrationController($request, $response, $exportRegistrationUseCase);
$inputBoundary = new InputBoundary('01234567890', 'dom-pdf-exporter.pdf', __DIR__ . '/../storage/registrations');

echo $controller
    ->handle($inputBoundary)
    ->getBody();
