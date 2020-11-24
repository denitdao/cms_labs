<?php
namespace App\Http\Traits;

use Illuminate\Support\Facades\Storage;

trait ImageProcessTrait
{
    public static function saveImage($name, $base64){
        list($type, $data) = explode(';', $base64);
        list(, $type)      = explode('/', $type);
        list(, $data)      = explode(',', $data);
        $full_name = $name.'.'.strtolower($type);
        debug($type);
        Storage::disk('images')->put($full_name, base64_decode($data));
        return $full_name;
    }

    public static function deleteImage($name){
        Storage::disk('images')->delete($name);
    }
}
