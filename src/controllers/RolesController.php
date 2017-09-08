<?php

namespace Zein\Zacl\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Validator;
use Zein\Zacl\Lib;
use Zein\Zacl\Models\Role;

class RolesController extends Controller{
    
    public function index(){   
        $data = Role::paginate(config('zacl.paginate'));
        return Lib::sendData($data);
    }
    
    public function store(Request $request){ 
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return Lib::sendError($validator->errors()->first());
        }
        
        $exists = Role::where('name',$request->name)->first();
        if($exists){
            return Lib::sendError("name $request->name sudah ada");
        }
        
        if(!$request->id){
            $role = new Role();
        }else{
            $role = Role::find($request->id);
            if(!$role){
                return Lib::sendError("id $request->id tidak ada");
            }
        }
        
        $role->name         = $request->name;
        $role->display_name = $request->display_name; // optional
        $role->description  = $request->description; // optional
        $role->save();
        
        return Lib::sendData($role);
        
    }
    
    public function show($id){ 
        return Lib::sendData(Role::find($id));
    }
    
    public function delete($id){ 
        $role = Role::find($id);
        if($role){
            $role->delete();
        }
        
        return Lib::sendData(null);
    }
    
}