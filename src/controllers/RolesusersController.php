<?php

namespace Zein\Zacl\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Zizaco\Entrust\EntrustRole;
use Zizaco\Entrust\EntrustPermission;
use DB;
use Validator;
use Zein\Zacl\Lib;
use Zein\Zacl\Models\Roleuser;
use Zein\Zacl\Models\Role;

class RolesusersController extends Controller{
    
    public function attach(Request $request){
        $validator = Validator::make($request->all(), [
            'userid' => 'required',
            'roleid' => 'required',
        ]);

        if ($validator->fails()) {
            return Lib::sendError($validator->errors()->first());
        }
        
        $role = EntrustRole::find($request->roleid);
        if (!$role) {
            return Lib::sendError("role tidak ditemukan");
        }
        
        $user = config('entrust.user')::find($request->userid);
        if (!$user) {
            return Lib::sendError("user tidak ditemukan");
        }
        
        Roleuser::updateOrCreate([
                    'user_id' => $request->userid,
                    'role_id' => $request->roleid,
                ],[
                    'user_id' => $request->userid,
                    'role_id' => $request->roleid,
                ]);
        
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
        
        $role = EntrustRole::find($request->roleid);
        if (!$role) {
            return Lib::sendError("role tidak ditemukan");
        }
        
        $user = config('entrust.user')::find($request->userid);
        if (!$user) {
            return Lib::sendError("user tidak ditemukan");
        }
        
        Roleuser::where('user_id', $request->userid)
                ->where('role_id',$request->roleid)->delete();
        
        return Lib::sendData(null);
    }
    
    public function roleofuser($userid){
        $result = config('entrust.user')::join('role_user','users.id', '=', 'role_user.user_id')
                ->join('roles','role_user.role_id','=','roles.id')
                ->select('roles.*')
                ->where('user_id',$userid)
                ->paginate(config('entrust.paginate'));
        return Lib::sendData($result);
    }
    
    public function userofrole($roleid){
        
        $result = Role::join("role_user","roles.id", '=', "role_user.role_id")
                ->join('users','role_user.user_id','=','users.id')
                ->select('users.id','users.name','users.email')
                ->where('role_id',$roleid)
                ->paginate(config('entrust.paginate'));
        return Lib::sendData($result);
    }
}