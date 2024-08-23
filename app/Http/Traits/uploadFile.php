<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\Storage;

trait uploadFile
{
    protected function uploadFile($request, $old_image = null, $filename = 'image', $disk = 'public', $path = '/') {
        if ($request->hasFile($filename)) {
            if ($old_image) {
                Storage::disk($disk)->delete($old_image);
            }
            $file = $request->file($filename);

            // $file->getClientOriginalName();
            // $file->getSize();
            // $file->getClientOriginalExtension();
            // $file->getMimeType();

            $path = $file->store($path, $disk);  // public = FILESYSTEM_DISK
        } else {
            $path = $old_image;
        }
        return $path;
    }

    protected function deleteFile($object_image, $disk = 'public')
    {
        if ($object_image) {
            Storage::disk($disk)->delete($object_image);
        }
    }
}
