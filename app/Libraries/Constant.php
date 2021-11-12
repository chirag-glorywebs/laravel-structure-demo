<?php
namespace App\Libraries;

use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests;
use Input;

class Constant {

   public static function getUserType(){
      return [
         "SuperAdmin" => "SuperAdmin",
         "Admin" => "Admin",
         "User" => "User"
      ];
   }

   public static function getMenuList(){
      return [
         'dashboard' => array(
            'value' => 'Dashboard', 
            'icon' => 'fa-tachometer-alt',
            'link' => '/admin/',
            'active_link' => array('admin'),
            'current_links' => array('admin','admin/dashboard/*'),
            'sub' => array()
         ),            
         'user' => array(
            'value' => 'User Management', 
            'icon' => 'fa-users',
            'active_link' => array('admin/user', 'admin/user/create', 'admin/user/*/edit'),
            'current_links' => array('admin/user/*'),
            'link' => '/admin/user',
            'sub' => array(
               array(
                  'value' => 'Add User', 
                  'icon' => 'fa fa-user-plus',
                  'link' => '/admin/user/create',
                  'active_link' => array('admin/user/create', 'admin/user/create'),
               ),
               array(
                  'value' => 'User List', 
                  'icon' => 'fa-user',
                  'link' => '/admin/user',
                  'active_link' => array('admin/user', 'admin/user'),
               ),
            ),
         ),
         'ErrorLogs' => array(
            'value' => 'ErrorLogs', 
            'icon' => 'fa-tachometer-alt',
            'link' => '/admin/api/error-logs',
            'active_link' => array('error-logs'),
            'current_links' => array('admin','/admin/api/error-logs/*'),
            'sub' => array()
         )
      ];
   }

}
