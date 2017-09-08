<?php

namespace Zein\Zacl\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Validator;
use Zein\Zacl\Lib;
use Zein\Zacl\Models\PermissionRole;
use Zein\Zacl\Models\Permission;
use Zein\Zacl\Models\Role;

class PermissionsrolesController extends Controller{
    
    public function attach(Request $request){
        $validator = Validator::make($request->all(), [
            'permissionid' => 'required',
            'roleid' => 'required',
        ]);

        if ($validator->fails()) {
            return Lib::sendError($validator->errors()->first());
        }
        
        $role = Role::find($request->roleid);
        if (!$role) {
            return Lib::sendError("role tidak ditemukan");
        }
        
        $permission = Permission::find($request->permissionid);
        if (!$permission) {
            return Lib::sendError("permission tidak ditemukan");
        }
        $role->attachPermission($permission);
        
        return Lib::sendData(null);
    }
    
    public function unattach(Request $request){
        $validator = Validator::make($request->all(), [
            'permissionid' => 'required',
            'roleid' => 'required',
        ]);

        if ($validator->fails()) {
            return Lib::sendError($validator->errors()->first());
        }
        
        $role = Role::find($request->roleid);
        if (!$role) {
            return Lib::sendError("role tidak ditemukan");
        }
        
        $permission = Permission::find($request->permissionid);
        if (!$permission) {
            return Lib::sendError("permission tidak ditemukan");
        }
        
        $role->detachPermission($permission);
        
        return Lib::sendData(null);
    }
    
    public function permissionofrole($roleid){
        $role = Role::find($roleid);
        if (!$role) {
            return Lib::sendError("role tidak ditemukan");
        }
        $result = $role->permissions()->paginate(config('zacl.paginate'));
        return Lib::sendData($result);
    }
    
    public function roleofpermission($permissionid){
        $permission = Permission::find($permissionid);
        if (!$permission) {
            return Lib::sendError("permission tidak ditemukan");
        }
        $result = $permission->roles()->paginate(config('zacl.paginate'));
        return Lib::sendData($result);
    }
}