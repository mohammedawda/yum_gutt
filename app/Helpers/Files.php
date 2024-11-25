<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

if (!function_exists('Upload')) {
    function upload($file, $dir)
    {
        $destination = FileDir($dir);
        $extension = $file->getClientOriginalExtension();
        $originalFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $fileName  = $originalFileName . '_' . time(). "." . $extension;
        //call external api to upload file
        $status = File::exists($destination) ? $destination : File::makeDirectory($destination, 0777, true, true);
        if($status) {
            $file->move( $destination . '/' , $fileName);
            return $fileName;
        }
        throw new Exception('there is an error with uploading the '.$dir, 405);
    }
}

if (!function_exists('FileDir')) {
    function FileDir($dir)
    {
        $url = 'uploads/';
        switch($dir) {
            case 'user_images':
                return  $url . 'user_images/';
            case 'profile_photo':
                return $url . 'profile_photo/';
            case 'product_images':
                return $url . 'product_images/';
            default:
                return  $url . 'images';
        }
    }
}


// if (!function_exists('ExistsImage')) {
//     function ExistsImage($dir): string
//     {
//         $path = public_path('uploads/images/'.$dir);
//         if (File::exists($path)){
//             $url = url('/uploads');
//             return $url .'/images'.'/'. $dir;
//         }
//         return '';
//     }
// }


if (!function_exists('fileExists')) {
    function fileExists($path)
    {
        return File::exists($path);
    }
}

if (!function_exists('GetFile')) {
    function GetFile($path)
    {
        $status = fileExists($path);
        if($status) {
            return url($path);
        }
        return null;
    }
}

if (!function_exists('unlinkFile')) {
    function unlinkFile($fullPath)
    {
        return File::delete($fullPath);
    }
}

if (!function_exists('deleteFile')) {
    function deleteFile($table, $id, $column)
    {
        $img = DB::table($table)->where('id', $id)->first();
        File::delete('uploads/'.$img->$column);
        return ;
    }
}

if (!function_exists('deleteFiles')) {
    function deleteFiles($table, $ids, $column)
    {
        $imgs = DB::table($table)->whereIn('id', $ids)->get();
        foreach ($imgs as $img){
            $filePath = 'uploads/'.$img->$column;
            if (File::exists($filePath)) {
                File::delete($filePath);
            }
        }
        return ;
    }
}

if (!function_exists('upload_path')) {
    function upload_path()
    {
        if (env('FILE_ENV') == 'local'){
            return public_path('uploads/');
        }
        return url('public/uploads/');
    }
}
