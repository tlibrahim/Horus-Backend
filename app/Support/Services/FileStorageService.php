<?php

declare(strict_types=1);

namespace App\Support\Services;

use App\Support\Contracts\FileStorageServiceInterface;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

final class FileStorageService implements FileStorageServiceInterface
{
    public function store(
        UploadedFile|File $file,
        string $directory,
        ?string $disk = null,
    ): array {
        $disk ??= config('filesystems.default');

        $path = Storage::disk($disk)->put($directory, $file);

        return [
            'disk' => $disk,
            'path' => $path,
            'original_name' => $file instanceof UploadedFile
                ? $file->getClientOriginalName()
                : basename($path),
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
        ];
    }

    public function delete(
        string $path,
        ?string $disk = null,
    ): bool {
        $disk ??= config('filesystems.default');

        if (! Storage::disk($disk)->exists($path)) {
            return false;
        }

        return Storage::disk($disk)->delete($path);
    }

    public function exists(
        string $path,
        ?string $disk = null,
    ): bool {
        $disk ??= config('filesystems.default');

        return Storage::disk($disk)->exists($path);
    }

    public function url(
        string $path,
        ?string $disk = null,
    ): string {
        $disk ??= config('filesystems.default');

        return Storage::disk($disk)->url($path);
    }
}
