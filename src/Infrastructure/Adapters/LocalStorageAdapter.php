<?php declare(strict_types=1);

namespace App\Infrastructure\Adapters;

use App\Application\Contracts\Storage;

class LocalStorageAdapter implements Storage
{

    public function store(string $fileName, string $path, string $content)
    {
        file_put_contents($path . DIRECTORY_SEPARATOR . $fileName, $content);
    }
}
