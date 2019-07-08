<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\User;
use Auth;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Kontrola používateľa či má danú rolu.
     * 
     * @return \Illuminate\Http\Response
     */

      public function checkAuthorized($role)
     {
        if(!Auth::user()->hasRole($role))
        { 
            return abort(403); 
        } 
     }

     /**
      * Kontrola používateľa či má dané role.
      * @param  array $role pole stringov/rol
      * @return \Illuminate\Http\Response
      */
      public function checkAuthorizedRoles($role)
     {
        $pom = false;
        foreach ($role as $key => $value) {
            if(Auth::user()->hasRole($value))
            { 
                $pom = true;
                return true; 
            } 
        }
        if($pom == false){
            return abort(403);
        } 
     }

     public function checkDepartment($request)
     { 
          $user = User::find(Auth::id()); 
          if($user->department_id == $request->department_id){
            return abort(403); 
          } 
     } 

     public function checkAlloweDepartment($id)
     {
      $user = User::find(Auth::id()); 
          if($user->department_id != $id){
            return abort(403); 
          }   
     } 


       public function checkRole($role)
     {
        if(!Auth::user()->hasRole($role))
        { 
            return abort(403); 
        } 
     }

    /**
     * Funkcia na zistenie rozdielu medzi dvoma polami
     *
     * @param  $array1
     * @param  $array2  
     */
    public function arrayDiff($array1, $array2){
        $newArray = array();
        foreach ($array1 as $key1 => $value1) {
            $pom = false;
            foreach ($array2 as $key2 => $value2) {
               if(($key1 == $key1) && ($value1 == $value2)){ 
                $pom = true;             
                }
            }
            if($pom == false){
                $newArray[$key1] = $value1;
            }
        }
        return $newArray;
    }
}
