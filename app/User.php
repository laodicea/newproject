<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Facades\App\Repository\Users;
use App\Model\Role; 
use App\Model\Department;
use App\Model\Notification; 
use Carbon\Carbon; 

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    public function roles()
    {
      return $this
      ->belongsToMany('App\Model\Role')
      ->withTimestamps();
    } 
     
  
    public function authorizeRoles($roles)
    {
      if ($this->hasAnyRole($roles)) {
        return true;
        }
    
    abort(401, 'This action is unauthorized.');
    }

    public function hasAnyRole($roles)
    {
        if (is_array($roles)) {
            foreach ($roles as $role) {
                if ($this->hasRole($role)) {
                    return true;
                 }
            }
        } else {
        if ($this->hasRole($roles)) {
        return true;
         }
        }
        return false;
    }

    public function hasRole($role)
    {
      if ($this->roles()->where('name', $role)->first()) {
        return true;
      }
    return false;
    }
     
    public function department(){

      return $this->belongsTo('App\Model\Department');

    }
  /**
  * Funkcia ktorá vráti meno nadriadeného.
  *
  * @return string $nameOfBoss
  */
  public function myBossName(){ 
    $role = Role::where('name','riadiaci pracovnik')->first();
 
    $user_role = DB::table('role_user')->where('department_id', $this->department_id)->where('role_id', $role->id)->first();
      
    if($user_role){ 
      $boss = User::find($user_role->user_id);
     
      return $boss->lastname . " " . $boss->name;
    }else{ 
      return "Nie je nastavený riadiaci pracovník";
    }   
  }
  
  /**
  * Funkcia ktorá vráti id nadriadeného.
  *
  * @return string $nameOfBoss
  */
  public function myBossId(){ 
    $role = Role::where('name','riadiaci pracovnik')->first();
 
    $user_role = DB::table('role_user')->where('department_id', $this->department_id)->where('role_id', $role->id)->first();
    
    if($user_role){ 
     return $user_role->user_id; 
    } 
    //ak nie je nastaveny riadiaci pracovnik
    return 1;   
  }

  public function fullname(){
    return $this->lastname . " " . $this->name;
  }

  public function userUnreadSecurityMessagesNumbers()
  {  
     return Users::getNumNotifications($this->id);   
  }

  public function userUnreadSecurityNotifications()
  {  
    return Users::getMessagesNotifications($this->id);
  }
 
  public function getCreatedAt()
  {
    return date('d.m.Y', strtotime($this->created_at));
  }

  public function getUpdatedAt()
  {
      return date('d.m.Y', strtotime($this->updated_at));
  }
}
