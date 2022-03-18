<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function saveImage($image) 
    {
        define('UPLOAD_DIR', public_path('/images/user/profile/'));

        $fileName = "Profile".Auth::user()->id . "." .  $image->getClientOriginalExtension();
        $maxWidth = 2048;
        $maxHeight = 2048;

        $image = Image::make($image);
        if($image->getWidth() > $maxWidth) {
            $image->resize($maxWidth, null, function ($constraint) {
                $constraint->aspectRatio();
            });
        }
        else if($image->getHeight() > $maxHeight) {
            $image->resize(null, $maxHeight, function ($constraint) {
                $constraint->aspectRatio();
            });
        }
        $image->save( UPLOAD_DIR . $fileName );

        if (Auth::user()->profile_photo_path != $fileName) {
            $old_image_path = UPLOAD_DIR . Auth::user()->profile_photo_path;
            if (File::exists($old_image_path)) {
                File::delete($old_image_path);
                // unlink($old_image_path);
            }
        }
        return $fileName;
    }
}
