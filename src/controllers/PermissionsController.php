<?php

namespace Zein\Zacl\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Validator;
use Zein\Zacl\Traits\ControllerTrait;
use Zein\Zacl\Models\Permission;
use Zein\Zacl\Models\PermissionRole;
use Route;

class PermissionsController extends Controller{
    
    use ControllerTrait;
    public $tagCache = __Class__;
    
    public function index(){   
        $result = $this->paginateFromCache($this->tagCache, new Permission());
        return $this->sendData($result);
    }
    
    public function store(Request $request){ 
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }
        
        $exists = Permission::where('name',$request->name)->first();
        if($exists){
            return $this->sendError("name $request->name sudah ada");
        }
        
        if(!$request->id){
            $permission = new Permission();
        }else{
            $permission = $this->findFromCache($request->id,new Permission());
            if(!$permission){
                return $this->sendError("id $request->id tidak ada");
            }
        }
        
        $permission->name         = $request->name;
        $permission->display_name = $request->display_name; // optional
        $permission->description  = $request->description; // optional
        $permission->save();
        $this->clearCache($this->tagCache);
        
        return $this->sendData($permission);
        
    }
    
    public function show($id){ 
        return $this->sendData($this->findFromCache($id,new Permission()));
    }
    
    public function delete($id){ 
        $permission = Permission::find($id);
        //cek permission
        if(!$permission){
            return $this->sendError("Permission not found");
        }
        //route permission tidak boleh di delete
        if(strpos($permission->name,'outegenerate|')){
            return $this->sendError("You Can't delete this permission");
        }
        //cek foreign key
        if(PermissionRole::where('permission_id',$permission->id)->first()){
            return $this->sendError("This permission used on role");
        }
        //delete permission
        $permission->delete();
        $this->clearCache($this->tagCache);
        
        return $this->sendData(null);
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
        return $this->sendData($result);
    }
    
}