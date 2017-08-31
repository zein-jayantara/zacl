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
        $data = DB::table('roles')->get();
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
            $owner = new EntrustPermission();
        }else{
            $owner = EntrustPermission::find($request->id);
            if(!$owner){
                return Lib::sendError("id $request->id tidak ada");
            }
        }
        
        $owner->name         = $request->name;
        $owner->display_name = $request->display_name; // optional
        $owner->description  = $request->description; // optional
        $owner->save();

        return Lib::sendData($owner);
        
    }
    
    public function show($id){ 
        return Lib::sendData(EntrustPermission::find($id));
    }
    
    public function delete($id){ 
        $role = Permission::find($id);
        $role->delete();
        return Lib::sendData(null);
    }
    
}