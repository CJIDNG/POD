<?php

namespace App\Http\Controllers\Util;

use Illuminate\Http\UploadedFile;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use App\Model\Util\CurrentTenant;

class MediaController extends \App\Http\Controllers\Controller
{
    /**
     * Stores a given file and returns the path.
     *
     * @return mixed
     */
    public function store()
    {
        $payload = request()->file();

        // We only expect single file uploads at this time
        $file = reset($payload);

        if ($file instanceof UploadedFile) {
            $path = $file->storePublicly($this->baseStoragePath(), [
                'disk' => config('custom.storage_disk'),
            ]);

            return Storage::disk(config('custom.storage_disk'))->url($path);
        }
    }

    /**
     * Deletes a given file from storage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy()
    {
        $file = pathinfo(request()->getContent());
        $storagePath = $this->baseStoragePath();
        $path = "{$storagePath}/{$file['basename']}";

        $fileDeleted = Storage::disk(config('custom.storage_disk'))->delete($path);

        if ($fileDeleted) {
            return response()->json([], 204);
        }
    }

    /**
     * Return the storage path url.
     *
     * @return string
     */
    private function baseStoragePath(): string
    {
      $currentTenant = new CurrentTenant();
      $platformName = $currentTenant->getPlatform()->name;
      return $currentTenant->getWebsite() ? 
        sprintf('%s/%s', config('custom.storage_path')."/${platformName}", 'images') :
        sprintf('%s/%s', config('custom.storage_path'), 'images') ;
    }
}
