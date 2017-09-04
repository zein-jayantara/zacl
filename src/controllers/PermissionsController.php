<?php

namespace Zein\Zacl\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Zizaco\Entrust\EntrustPermission;
use DB;
use Validator;
use Zein\Zacl\Lib;
use Zein\Zacl\Models\Permission;

class PermissionsController extends Controller{
    
    public function index(){   
        $data = DB::table('permissions')->paginate(config('entrust.paginate'));
        return Lib::sendData($data);
    }
    
    public function store(Request $request){ 
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return Lib::sendError($validator->errors()->first());
        }
        
        $exists = EntrustPermission::where('name',$request->name)->first();
        if($exists){
            return Lib::sendError("name $request->name sudah ada");
        }
        
        if(!$request->id){
            $permission = new EntrustPermission();
        }else{
            $permission = EntrustPermission::find($request->id);
            if(!$permission){
                return Lib::sendError("id $request->id tidak ada");
            }
        }
        
        $permission->name         = $request->name;
        $permission->display_name = $request->display_name; // optional
        $permission->description  = $request->description; // optional
        $permission->save();

        return Lib::sendData($permission);
        
    }
    
    public function show($id){ 
        return Lib::sendData(EntrustPermission::find($id));
    }
    
    public function delete($id){ 
        $permission = Permission::find($id);
        if($permission){
            $permission->delete();
        }
        
        return Lib::sendData(null);
    }
    
}