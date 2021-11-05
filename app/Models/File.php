<?php

namespace HDSSolutions\Laravel\Models;

use Illuminate\Http\File as Illuminate_File;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class File extends X_File {

    private ?Illuminate_File $instance = null;

    public function scopeImages($query) {
        return $query->where('type', '=', 'image');
    }

    public function file():?Illuminate_File {
        // checl if instance exists
        if ($this->instance === null)
            // load instance
            $this->instance = new Illuminate_File( $this->path );
        // return file instance
        return $this->instance;
    }

    public function delete() {
        // remove image from storage
        if (!Storage::disk( config('filesystems.uploads') )->delete($this->attributes['url']))
            // return false
            return false;
        // normal delete process
        parent::delete();
    }

    public static function upload(Request $request, UploadedFile $file, Controller $controller, bool $public = true):?File {
        // default type to pdf
        $type = 'pdf';
        // validate
        if (!$file->isValid()) {
            // append errors
            $controller->validator->errors()->add($file, $file->getErrorMessage());
            // exit with validation exception
            $controller->throwValidationException($request, $controller->validator);
        }
        // save original name
        $originalName = $file->getClientOriginalName();
        // get public / private disk
        $disk_type = config($public ? 'filesystems.uploads' : 'filesystems.default');
        info("Uploading file {$originalName} to disk {$disk_type}");
        $disk = Storage::disk( $disk_type );
        // check if is image
        if (preg_match('/^image\/.*/', $file->getMimeType())) {
            // change type to image
            $type = 'image';
            // get hashname
            $hashName = $file->hashName();
            // keep under 1000x1000 resolution
            $file = Image::make($file);
            // image process type
            switch (config('settings.uploads-crop')) {
                case 'fit':
                    // fit in width x height
                    $file->fit(
                        config('settings.uploads-crop-width'),
                        config('settings.uploads-crop-height'),
                        // prevent upsizing
                        function($constraint) { $constraint->upsize(); });
                    break;

                case 'resize':
                    // resize under width x height
                    $file->widen(config('settings.uploads-crop-width'), function($constraint) { $constraint->upsize(); });
                    $file->heighten(config('settings.uploads-crop-height'), function($constraint) { $constraint->upsize(); });
                    break;
            }
            // get file stream
            $file = $file->stream();
            // create path name
            $path = File::IMAGES_DIRECTORY.'/'.$hashName;
            // save to storage
            $disk->put($path, $file);
        } else {
            // check file type
            $type = preg_match('/excel/', $file->getMimeType()) ? 'spreadsheet' : $type;
            // save file
            $path = $disk->putFile(File::STORAGE_DIRECTORY, $file);
        }
        // create resource
        return new File([
            'name'  => $originalName,
            'type'  => $type,
            'disk'  => $disk_type,
            'url'   => $path,
        ]);
    }
}
