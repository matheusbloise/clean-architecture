<?php

use App\Application\Contracts\ExportRegistrationPdfExporter;
use App\Application\Contracts\Storage;
use App\Application\Usecases\ExportRegistration\ExportRegistration;
use App\Domain\Repositories\LoadRegistrationRepository;
use App\Infrastructure\Adapters\DomPdfAdapter;
use App\Infrastructure\Adapters\LocalStorageAdapter;
use App\Infrastructure\Http\Controllers\ExportRegistrationController;
use App\Infrastructure\Repositories\MySQL\PdoRegistrationRepository;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;

use function DI\create;
use function DI\get;

$db = require_once __DIR__ . "/database.php";

$dsn = sprintf(
    $db['mysql']['dsn'],
    $db['mysql']['host'],
    $db['mysql']['port'],
    $db['mysql']['dbname'],
    $db['mysql']['charset']
);

$containerBuilder = new DI\ContainerBuilder();
$containerBuilder->addDefinitions([
    ExportRegistrationController::class => create(ExportRegistrationController::class)
        ->constructor(
            create(Request::class)->constructor('GET', 'http://localhost:8080'),
            get(Response::class),
            get(ExportRegistration::class),
        ),

    PDO::class => create(PDO::class)
        ->constructor(
            $dsn,
            $db['mysql']['username'],
            $db['mysql']['password'],
            $db['mysql']['options']
        ),

    LoadRegistrationRepository::class => get(PdoRegistrationRepository::class),
    ExportRegistrationPdfExporter::class => get(DomPdfAdapter::class),
    Storage::class => get(LocalStorageAdapter::class),
]);


return $containerBuilder->build();

