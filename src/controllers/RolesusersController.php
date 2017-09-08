<?php

namespace Zein\Zacl\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Zein\Zacl\Lib;
use Zein\Zacl\Models\Role;
use App\User;

class RolesusersController extends Controller{
    
    public function attach(Request $request){
        $validator = Validator::make($request->all(), [
            'userid' => 'required',
            'roleid' => 'required',
        ]);

        if ($validator->fails()) {
            return Lib::sendError($validator->errors()->first());
        }
        
        $role = Role::find($request->roleid);
        if (!$role) {
            return Lib::sendError("role tidak ditemukan");
        }
        
        $user = User::find($request->userid);
        if (!$user) {
            return Lib::sendError("user tidak ditemukan");
        }
        
        $user->roles()->attachRole($role);
        
        return Lib::sendData(null);
    }
    
    public function unattach(Request $request){
        $validator = Validator::make($request->all(), [
            'userid' => 'required',
            'roleid' => 'required',
        ]);

        if ($validator->fails()) {
            return Lib::sendError($validator->errors()->first());
        }
        
        $role = Role::find($request->roleid);
        if (!$role) {
            return Lib::sendError("role tidak ditemukan");
        }
        
        $user = User::find($request->userid);
        if (!$user) {
            return Lib::sendError("user tidak ditemukan");
        }
        
        $user->detachRole($role);
        
        return Lib::sendData(null);
    }
    
    public function roleofuser($userid){
        $user = User::find($userid);
        if (!$user) {
            return Lib::sendError("user tidak ditemukan");
        }
        $result = $user->roles()->paginate(config('zacl.paginate'));
        return Lib::sendData($result);
    }
    
    public function userofrole($roleid){
        $role = Role::find($roleid);
        if (!$role) {
            return Lib::sendError("role tidak ditemukan");
        }
        $result = $role->users()->paginate(config('zacl.paginate'));
        return Lib::sendData($result);
    }
}