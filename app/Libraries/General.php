<?php
/**
 * @uses General Functions
 * @author Ranjitsinh Bhalgariya <ranjitsinh.b.01@gmail.com>
 * @return
 */

namespace App\Libraries;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use File;
use Image;
use URL;

class General {

    /**
    * @author Ranjitsinh Bhalgariya <ranjitsinh.b.01@gmail.com>
     *
     * @uses Generate for generate randon string
     *
     * @return string
     */
    public static function generate_token($length=30) {
        $token = "";
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
        $codeAlphabet.= "0123456789";
        $max = strlen($codeAlphabet) - 1;
        for ($i=0; $i < $length; $i++) {
            $token .= $codeAlphabet[mt_rand(0, $max)];
        }
        return $token;
    }

    /**
    * @author Ranjitsinh Bhalgariya <ranjitsinh.b.01@gmail.com>
     *
     * @uses Generate for generate randon string
     *
     * @return string
     */
    public static function storagefileupload($folder, $file="", $oldfile=''){
        if(!Storage::exists('/public/'.$folder)) {
            Storage::makeDirectory('/public/'.$folder, 0775, true); //creates directory
        }
        if($oldfile!=''){
            $remove_file = storage_path('/app/public/'.$folder.'/'.$oldfile);
            File::delete($remove_file);
        }
        $fileData = "";
        if($file != ""){
            $fileData = Storage::putFile('public/'.$folder, $file);
        }
        return $file = str_replace('public/'.$folder.'/', '', $fileData);
    }
}
