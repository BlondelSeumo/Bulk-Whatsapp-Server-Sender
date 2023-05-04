<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use File;

trait Dotenv
{
   
   public function editEnv($key, $value,$isBool=false)
   {
       $env = file_get_contents(base_path('.env'));

       if ($isBool == true) {

           if (env($key) == true) {
               $boolKey = $key."=true";
           }
           else{
              $boolKey = $key."=false";
           }

          
           
           if ($value == true) {
               $bool = $key."=true";
           }
           else{
               $bool = $key."=false";
           }

    
           $newText = str_replace($boolKey, $bool, $env);

          
       }
       else{
          $newText = str_replace($key.'='.env($key), $key.'='.$this->removeEmptySpace($value), $env);
         
       }
       
       File::put(base_path('.env'),$newText);

       return true;

   }


   public function removeEmptySpace($value='')
   {
      return  preg_replace('/\s+/', '', $value);
   }
}    