<?php

namespace Zein\Zacl\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Zein\Zacl\Traits\ControllerTrait;
use Zein\Zacl\Models\Role;

class RolesController extends Controller{
    use ControllerTrait;
    public $tagCache = __Class__;
    public function index(){ 
        $result = $this->paginateFromCache($this->tagCache, new Role());
        return $this->sendData($result);
    }
    
    public function store(Request $request){ 
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }
        
        $exists = Role::where('name',$request->name)->first();
        if($exists){
            return $this->sendError("name $request->name sudah ada");
        }
        
        if(!$request->id){
            $role = new Role();
        }else{
            $role = $this->findFromCache($request->id,new Role());
            if(!$role){
                return $this->sendError("id $request->id tidak ada");
            }
        }
        
        $role->name         = $request->name;
        $role->display_name = $request->display_name; // optional
        $role->description  = $request->description; // optional
        $role->save();
        $this->clearCache($this->tagCache);
        return $this->sendData($role);
        
    }
    
    public function show($id){ 
        return $this->sendData($this->findFromCache($id,new Role()));
    }
    
    public function delete($id){ 
        $role = Role::find($id);
        if($role){
            $role->delete();
            $this->clearCache($this->tagCache);
        }
        
        return $this->sendData(null);
    }
    
}