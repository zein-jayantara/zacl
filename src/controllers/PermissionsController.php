<?php

namespace Zein\Zacl\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Validator;
use Zein\Zacl\Lib;
use Zein\Zacl\Models\Permission;
use Zein\Zacl\Models\PermissionRole;
use Route;

class PermissionsController extends Controller{
    
    public function index(){   
        $data = Permission::paginate(config('zacl.paginate'));
        return Lib::sendData($data);
    }
    
    public function store(Request $request){ 
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return Lib::sendError($validator->errors()->first());
        }
        
        $exists = Permission::where('name',$request->name)->first();
        if($exists){
            return Lib::sendError("name $request->name sudah ada");
        }
        
        if(!$request->id){
            $permission = new Permission();
        }else{
            $permission = Permission::find($request->id);
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
        return Lib::sendData(Permission::find($id));
    }
    
    public function delete($id){ 
        $permission = Permission::find($id);
        //cek permission
        if(!$permission){
            return Lib::sendError("Permission not found");
        }
        //route permission tidak boleh di delete
        if(strpos($permission->name,'outegenerate|')){
            return Lib::sendError("You Can't delete this permission");
        }
        //cek foreign key
        if(PermissionRole::where('permission_id',$permission->id)->first()){
            return Lib::sendError("This permission used on role");
        }
        //delete permission
        $permission->delete();
        
        
        return Lib::sendData(null);
    }
    
    public function generate(){ 
        $prefixname = 'routegenerate|';
        $routes  = Route::getRoutes();
        $routepermissions = Permission::where('name','like',"$prefixname%")->get();
        
        $arrayNewRoutes = [];
        $result = new \stdClass();
        $result->added = 0;
        $result->deleted = 0;
        //add new route to permission table
        foreach ($routes as $route) {
            $attributes = $route->getAction();
            $name = isset($attributes['as']) ? $attributes['as'] : null;
            $description = isset($attributes['description']) ? $attributes['description'] : null;
            $uses = isset($attributes['uses']) ? $attributes['uses'] : null;
            if(!$name){
                continue;
            }
            $name = $prefixname.$name;
            if (null == Permission::where('name',$name)->first()){
                Permission::create(['name' => $name,'display_name' => $description ,'description' => $uses]);
                $result->added +=1;
            }
            $arrayNewRoutes[] = $name;
        }
        //delete route old from permission table
        foreach ($routepermissions as $routepermission) {
            if(!in_array($routepermission->name, $arrayNewRoutes)){
                $p = Permission::where('name',$routepermission->name)->first();
                $pr = PermissionRole::where('permission_id',$p->id)->delete();
                $p->delete();
                $result->deleted +=1;
            }
        }
        return Lib::sendData($result);
    }
    
}