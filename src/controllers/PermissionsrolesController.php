<?php

namespace Zein\Zacl\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Zizaco\Entrust\EntrustRole;
use Zizaco\Entrust\EntrustPermission;
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
        
        $role = EntrustRole::find($request->roleid);
        if (!$role) {
            return Lib::sendError("role tidak ditemukan");
        }
        
        $permission = EntrustPermission::find($request->permissionid);
        if (!$permission) {
            return Lib::sendError("permission tidak ditemukan");
        }
        
        PermissionRole::updateOrCreate([
                    'permission_id' => $request->permissionid,
                    'role_id' => $request->roleid,
                ],[
                    'permission_id' => $request->permissionid,
                    'role_id' => $request->roleid,
                ]);
        
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
        
        $role = EntrustRole::find($request->roleid);
        if (!$role) {
            return Lib::sendError("role tidak ditemukan");
        }
        
        $permission = EntrustPermission::find($request->permissionid);
        if (!$permission) {
            return Lib::sendError("permission tidak ditemukan");
        }
        
        PermissionRole::where('permission_id', $request->permissionid)
                ->where('role_id',$request->roleid)->delete();
        
        return Lib::sendData(null);
    }
    
    public function permissionofrole($roleid){
        $result = Role::join('permission_role','roles.id', '=', 'permission_role.role_id')
                ->join('permissions','permission_role.permission_id','=','permissions.id')
                ->select('permissions.*')
                ->where('role_id',$roleid)
                ->paginate(config('entrust.paginate'));
        return Lib::sendData($result);
    }
    
    public function roleofpermission($permissionid){
        
        $result = Permission::join("permission_role","permissions.id", '=', "permission_role.permission_id")
                ->join('roles','permission_role.role_id','=','roles.id')
                ->select('roles.*')
                ->where('permission_id',$permissionid)
                ->paginate(config('entrust.paginate'));
        return Lib::sendData($result);
    }
}