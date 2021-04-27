<?php

namespace HDSSolutions\Finpar\Models;

use HDSSolutions\Finpar\Traits\BelongsToCompany;
use Illuminate\Support\Facades\Storage;

abstract class X_File extends Base\Model {
    use BelongsToCompany;

    const IMAGES_DIRECTORY = 'images';
    const STORAGE_DIRECTORY = 'files';

    protected $fillable = [ 'name', 'type', 'url' ];

    protected static array $rules = [
        'name'  => [ 'required', 'min:3' ],
        'type'  => [ 'required' ],
        'url'   => [ 'required', 'min:3' ],
    ];

    public static array $uploadRules = [
        'file'  => [ 'required', 'image', 'mimes:jpeg,jpg,png,gif', 'max:2048' ],
    ];

    public function getUrlAttribute():?string {
        // return image path
        return $this->attributes['url'] !== null ?
            // return disk path
            Storage::disk( config('filesystems.uploads') )->url($this->attributes['url']) :
            // return null
            null;
    }

    public function getUrlRawAttribute():?string {
        //
        return $this->attributes['url'];
    }

    public function getPathAttribute():?string {
        // return file path
        return Storage::disk( config('filesystems.uploads') )->path($this->url_raw);
    }

}
