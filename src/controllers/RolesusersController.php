<?php

namespace Zein\Zacl\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Zein\Zacl\Models\Role;
use App\User;
use Zein\Zacl\Traits\ControllerTrait;

class RolesusersController extends Controller{
    use ControllerTrait;
    
    public $tagCache = __Class__;
    
    public function attach(Request $request){
        $validator = Validator::make($request->all(), [
            'userid' => 'required',
            'roleid' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }
        
        $role = $this->findFromCache($request->roleid,new Role());
        if (!$role) {
            return $this->sendError("role tidak ditemukan");
        }
        
        $user = $this->findFromCache($request->userid,new User());
        if (!$user) {
            return $this->sendError("user tidak ditemukan");
        }
        
        $user->roles()->attachRole($role);
        $this->clearCache($this->tagCache);
        
        return $this->sendData(null);
    }
    
    public function unattach(Request $request){
        $validator = Validator::make($request->all(), [
            'userid' => 'required',
            'roleid' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }
        
        $role = $this->findFromCache($request->roleid,new Role());
        if (!$role) {
            return $this->sendError("role tidak ditemukan");
        }
        
        $user = $this->findFromCache($request->userid,new User());
        if (!$user) {
            return $this->sendError("user tidak ditemukan");
        }
        
        $user->detachRole($role);
        $this->clearCache($this->tagCache);
        
        return $this->sendData(null);
    }
    
    public function roleofuser($userid){
        $user = $this->findFromCache($userid,new User());
        if (!$user) {
            return $this->sendError("user tidak ditemukan");
        }
        $result = $this->paginateFromCache($this->tagCache, $user->roles());
        return $this->sendData($result);
    }
    
    public function userofrole($roleid){
        $role = $this->findFromCache($roleid,new Role());
        if (!$role) {
            return $this->sendError("role tidak ditemukan");
        }
        $result = $this->paginateFromCache($this->tagCache, $role->users());
        return $this->sendData($result);
    }
}