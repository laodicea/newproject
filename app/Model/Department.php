<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Department; 
use App\Model\Role;
use App\User;
use DB;

class Department extends Model
{
    public function users(){
        return $this->belongsToMany('App\User');
    }

    /**
     * Funkcia ktora vrati vsetkych pouzivatelov v danom oddeleni
     * @return array user
     */
    public function getUsers(){
        $idBoss = $this->getBossSekretarId('riadiaci pracovnik');
       // $idZastupca = $this->getBossSekretarId('zastupca'); 

        return User::where('department_id', $this->id)->where('id', '!=', $idBoss)->where('active', 1)->get();  
    }
    
    /**
     * Funkcia vrati meno nadriadeneho alebo zastupcu
     * @param  string $string v podobe "riadiaci pracovnik" alebo "zastupca".
     * @return string         meno nadriadeneho alebo zastupcu
     */
    public function bossSekretar($string){ 
        if($string != null){
            $role = Role::where('name',$string)->first();
            if($role != null){
                $user_role = DB::table('role_user')->where('department_id', $this->id)->where('role_id', $role->id)->whereNotNull('department_id')->first();
                if($user_role){
                 
                    $boss = User::find($user_role->user_id);

                    if($boss != null){
                        return $boss->fullname();
                    }else{
                        return "-";
                    }
                }
            }
        }
    } 

    /**
     * Funkcia vrati popis pre telefony zoznam s mestnostou a telefonom zamestnanca
     * @return string text telefonu a miestnosti
     */
    public function bossSekretarTelRoom($string){
        $role = Role::where('name',$string)->first();
     
        $user_role = DB::table('role_user')->where('department_id', $this->id)->where('role_id', $role->id)->whereNotNull('department_id')->first();
        if($user_role){
              
            $boss = User::find($user_role->user_id);
             
            return "Miestnosť: " . $boss->room . ", Telefón: " . $boss->phone;
        
        }else{
                return "-";
             }
    }

    /**
     * Funkcia spocita podriadene organizacie
     * @return int sucet podriadenych organizacii
     */
    public function getNumberSubDepartment(){
        $departments = Department::where('parent',$this->id)->get();
        if($departments){
            return count($departments);
        }else{
            return 0;
        }  
    }

    /**
     * Funkcia zobrazi ID nadriadeneho alebo zastupujuceho
     * @param  String String vo forme "riadiaci pracovnik" alebo "zastupca".
     * @return id Id Role
     */
    public function getBossSekretarId($string){
         $role = Role::where('name',$string)->first();
         if($role != null){
            $user_role = DB::table('role_user')->where('department_id', $this->id)->where('role_id', $role->id)->whereNotNull('department_id')->first();
            if($user_role){
               return $user_role->user_id;
            }
        }
        return null;
    }
     /**
     * Funkcia vrati objekt user nadriadeneho alebo zastupujuceho
     * @param  String String vo forme "riadiaci pracovnik" alebo "zastupca".
     * @return id Id Role
     */
    public function getBossSekretarObj($string){
         $role = Role::where('name',$string)->first();
         $user_role = DB::table('role_user')->where('department_id', $this->id)->where('role_id', $role->id)->whereNotNull('department_id')->first();
         if($user_role){
            
            return User::findOrFail($user_role->user_id);
         }
         return null;
    }

    /**
     * Funkcia zobrazi vsetky podriadene organizacie
     * @return array pole vsetkych podriadenych organizacii v tvare name - id pre selectbox
     */
    public function getAllPodriadene(){ 
        $dep = Department::where('parent',$this->id)->pluck('name', 'id'); 
        return $dep;
    }

    /**
     * Funkcia zobrazi nazov nadriadenej organizacie
     * @return string nazov organizacie
     */
    public function getUpOrg(){
        $dep = Department::find($this->parent);
        if($dep){
            return $dep->name;
        }else{
            return "-";
        }
    }

    /**
     * Funkcia ktorá odstráni všetky vzťahy na tabuľku role_user
     * @return [type] [description]
     */
    public function removeRoles(){
      return DB::delete('delete from role_user where department_id = ?', [$this->id]);
    }

    /**
     * Funkcia pre zistenie ID role riadiaceho pracovníka.
     *
     * 
     * @return id Role
     */
  
    public function getIdRoleBoss(){
       
        $role =  Role::where('name','riadiaci pracovnik')->first();
        
        return $role->id;
    }
    /**
     * Funkkcia pre vlozenie vztahov role do role_user
     *
     * @param  int  $user_id, int $department_id 
    */
    public function saveRoleUser($user_id){

        $prava = DB::select('select id from role_user where department_id = ? and role_id = ?', [$this->id, $this->getIdRoleBoss()]);
  
        if(isset($prava[0]->id)){

            DB::update('update role_user set role_id = ?, department_id = ?, user_id = ? where id = ?', [$this->getIdRoleBoss(), $this->id, $user_id, $prava[0]->id]);
        }else{  
            DB::insert('insert into role_user (role_id, user_id, department_id, created_at, updated_at) values (?, ?, ?, ?, ?)', [$this->getIdRoleBoss(), $user_id, $this->id, \Carbon\Carbon::now(), \Carbon\Carbon::now()]);
        }
    }

        /**
     * Funkcia pre zistenie ID role "zastupca"
     *
     * 
     * @return id Role
     */
    public function getIdZastupca(){
       
        $role =  Role::where('name','zastupca')->first();

        if($role){
            return $role->id;
        }else{
            return null;
        }
    }
}
