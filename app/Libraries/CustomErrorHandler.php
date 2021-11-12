<?php 
namespace App\Libraries;

use Exception;

use App\Models\WSErrorHandler;
use Illuminate\Support\Str;
use Config;
use Request;
use URL;
use Illuminate\Support\Facades\Auth;

class CustomErrorHandler {

    public static function APIServiceLog($errorMsg="",$error_type="API"){   

        $userId = Auth::id();
     
        //Start start log
        $current_domain = ''; //Config::get("CURRENT_DOMAIN");
        //$hostname = Request::getHost();
        $hostname = URL::to('/');
        $remote_addr = Request::server("REMOTE_ADDR");
        $request_uri = Request::server("REQUEST_URI");

        $wserrorObj = new WSErrorHandler();
        $wserrorObj->error_id =Str::uuid();
        $wserrorObj->base_url =$hostname.$request_uri;
        //$wserrorObj->sub_domain = $current_domain;
        $wserrorObj->remote_addr =$remote_addr;
        $wserrorObj->error_msg =$errorMsg;
        $wserrorObj->error_type =$error_type;
        $wserrorObj->created_by = ($userId) ? $userId : '';
        try{            
            $wserrorObj->save();           
        }catch(Exception $e){
            return $errorMsg;
        }
        //End start log
        return $errorMsg;
    }

}
