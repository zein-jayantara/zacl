<?php

namespace Zein\Zacl\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Validator;
use Zein\Zacl\Traits\ControllerTrait;
use Zein\Zacl\Models\Permission;
use Zein\Zacl\Models\Role;

class PermissionsrolesController extends Controller{
    
    use ControllerTrait;
    public $tagCache = __Class__;
    
    public function attach(Request $request){
        $validator = Validator::make($request->all(), [
            'permissionid' => 'required',
            'roleid' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }
        
        $role = $this->findFromCache($request->roleid,new Role());
        if (!$role) {
            return $this->sendError("role tidak ditemukan");
        }
        
        $permission = $this->findFromCache($request->permissionid,new Permission());
        if (!$permission) {
            return $this->sendError("permission tidak ditemukan");
        }
        $role->attachPermission($permission);
        $this->clearCache($this->tagCache);
        
        return $this->sendData(null);
    }
    
    public function unattach(Request $request){
        $validator = Validator::make($request->all(), [
            'permissionid' => 'required',
            'roleid' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }
        
        $role = $this->findFromCache($request->roleid,new Role());
        if (!$role) {
            return $this->sendError("role tidak ditemukan");
        }
        
        $permission = $this->findFromCache($request->permissionid,new Permission());
        if (!$permission) {
            return $this->sendError("permission tidak ditemukan");
        }
        
        $role->detachPermission($permission);
        $this->clearCache($this->tagCache);
        
        return $this->sendData(null);
    }
    
    public function permissionofrole($roleid){
        $role = $this->findFromCache($roleid,new Role());
        if (!$role) {
            return $this->sendError("role tidak ditemukan");
        }
        $result = $this->paginateFromCache($this->tagCache, $role->permissions());
        return $this->sendData($result);
    }
    
    public function roleofpermission($permissionid){
        $permission = $this->findFromCache($permissionid,new Permission());
        if (!$permission) {
            return $this->sendError("permission tidak ditemukan");
        }
        $result = $this->paginateFromCache($this->tagCache, $permission->roles());
        return $this->sendData($result);
    }
}