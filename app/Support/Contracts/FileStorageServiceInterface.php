<?php

declare(strict_types=1);

namespace App\Support\Contracts;

use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;

interface FileStorageServiceInterface
{
    /**
     * Store a file.
     *
     * @return array{
     *     disk:string,
     *     path:string,
     *     original_name:string,
     *     mime_type:string,
     *     size:int
     * }
     */
    public function store(UploadedFile|File $file, string $directory, ?string $disk = null): array;

    public function delete(string $path, ?string $disk = null): bool;

    public function exists(string $path, ?string $disk = null): bool;

    public function url(string $path, ?string $disk = null): string;
}
