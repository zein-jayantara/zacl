<?php

namespace Zein\Zacl\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Zizaco\Entrust\EntrustRole;
use DB;
use Validator;
use Zein\Zacl\Lib;
use Zein\Zacl\Models\Role;

class RolesController extends Controller{
    
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
        
        $exists = EntrustRole::where('name',$request->name)->first();
        if($exists){
            return Lib::sendError("name $request->name sudah ada");
        }
        
        if(!$request->id){
            $owner = new EntrustRole();
        }else{
            $owner = EntrustRole::find($request->id);
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
        return Lib::sendData(EntrustRole::find($id));
    }
    
    public function delete($id){ 
        $role = Role::find($id);
        $role->delete();
        return Lib::sendData(null);
    }
    
}