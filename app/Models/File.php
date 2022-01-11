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
    private bool $is_local_fs;
    private $temp_file;

    public function scopeImages($query) {
        return $query->where('type', '=', 'image');
    }

    public function file():?Illuminate_File {
        // checl if instance exists
        if ($this->instance === null) {
            // get file path
            $path = $this->path;
            // get disk config
            $disk_config = config( "filesystems.disks.{$this->disk}" );
            // check if disk isn't local
            if ($this->is_local_fs = $disk_config['driver'] !== 'local') {
                // make a temporal file
                $this->temp_file = tempnam(sys_get_temp_dir(), "{$this->name}_");
                // move extension to end
                preg_match('/((\.\w+)+)\_/', $this->temp_file, $matches);
                $this->temp_file = str_replace($matches[1], '', $this->temp_file).$matches[1];
                // put contents from external disk
                file_put_contents($path = $this->temp_file, Storage::disk( $this->disk )->get( $this->url_raw ));
            }
            // load instance
            $this->instance = new Illuminate_File( $path );
        }
        // return file instance
        return $this->instance;
    }

    public function delete() {
        // remove image from storage
        if (!Storage::disk( $this->disk )->delete($this->attributes['url']))
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
