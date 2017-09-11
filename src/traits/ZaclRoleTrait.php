<?php
namespace Zein\Zacl\Traits;

use Illuminate\Support\Facades\Cache;
use Illuminate\Cache\TaggableStore;
use Zein\Zacl\Lib;

trait ZaclRoleTrait{
    
    public function getPermissions()
    {
        return $this->permissions()->get();
    }
    
    public function permissions()
    {
        return $this->belongsToMany('Zein\Zacl\Models\Permission', 'permission_role', 'role_id', 'permission_id');
    }
    
    public function users()
    {
        return $this->belongsToMany(config('zacl.user_model'), 'role_user', 'role_id', 'user_id');
    }
    
    public function hasPermission($permissionname)
    {
        $key = __CLASS__.$this->{$this->primaryKey}.__FUNCTION__.$permissionname;
        if(Cache::getStore() instanceof TaggableStore) {
            return Cache::tags('ZaclRole')->remember($key, Lib::getExpiredCache(), function () use ($permissionname) {
                if($this->permissions()->where('name',$permissionname)->first()){
                    return true;
                }else{
                    return false;
                }
            });
        }else{
            if($this->permissions()->where('name',$permissionname)->first()){
                return true;
            }else{
                return false;
            }
        }
    }
    
//    public function save(array $options = [])
//    {   //both inserts and updates
//        if(Cache::getStore() instanceof TaggableStore) {
//            Cache::tags('ZaclRole')->flush();
//        }
//        return parent::save($options);
//    }
//    public function delete(array $options = [])
//    {   //soft or hard
//        parent::delete($options);
//        if(Cache::getStore() instanceof TaggableStore) {
//            Cache::tags('ZaclRole')->flush();
//        }
//    }
//    public function restore()
//    {   //soft delete undo's
//        parent::restore();
//        if(Cache::getStore() instanceof TaggableStore) {
//            Cache::tags('ZaclRole')->flush();
//        }
//    }
    
    public function attachPermission($permission)
    {
        if(is_object($permission)) {
            $permission = $permission->getKey();
        }

        if(is_array($permission)) {
            $permission = $permission['id'];
        }

        $this->permissions()->attach($permission);
    }

    public function detachPermission($permission)
    {
        if (is_object($permission)) {
            $permission = $permission->getKey();
        }

        if (is_array($permission)) {
            $permission = $permission['id'];
        }

        $this->permissions()->detach($permission);
    }

    
    public function attachPermissions($permissions)
    {
        foreach ($permissions as $permission) {
            $this->attachPermission($permission);
        }
    }

    public function detachRoles($permissions=null)
    {
        if (!$permissions) $permissions = $this->permission()->get();
        foreach ($permissions as $permission) {
            $this->detachRole($permission);
        }
    }
    
    
}
