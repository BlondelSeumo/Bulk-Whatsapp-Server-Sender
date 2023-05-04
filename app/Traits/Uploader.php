<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Str;
trait Uploader
{

    //upload file
    private function saveFile(Request $request,$input)
    {
        $file = $request->file($input);
        $ext = $file->extension();
        $filename = now()->timestamp.Str::random(20).'.'.$ext;

        $path = 'uploads'.date('/y') . '/' . date('m') . '/';
        $filePath = $path.$filename;


        Storage::put($filePath, file_get_contents($file));

        return Storage::url($filePath);
    }


    //remove file
    public function removeFile($url=null)
    {
       if (empty($url)) {
           return true;
       }

       $fileName=explode('uploads', $url);
       if (isset($fileName[1])) {
         $exists_file='uploads'.$fileName[1];
         if (Storage::exists($exists_file)) {
            Storage::delete($exists_file);
         }
         return true;
       }

       return false;
    }


}