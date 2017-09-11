<?php
namespace Zein\Zacl\Traits;

use Illuminate\Support\Facades\Cache;
use Illuminate\Cache\TaggableStore;
use Zein\Zacl\Lib;

trait ZaclUserTrait{
    
    public function getRoles()
    {
        return $this->roles()->get();
    }
    
    public function roles()
    {
        return $this->belongsToMany('Zein\Zacl\Models\Role', 'role_user', 'user_id', 'role_id');
    }
    
    public function hasRole($role_name){
        $key = __CLASS__.$this->{$this->primaryKey}.__FUNCTION__.$role_name;
        if(Cache::getStore() instanceof TaggableStore) {
            return Cache::tags('ZaclUser')->remember($key, Lib::getExpiredCache(), function () use ($role_name) {
                if($this->roles()->where('name',$role_name)->first()){
                    return true;
                }else{
                    return false;
                }
            });
        }else{
            if($this->roles()->where('name',$role_name)->first()){
                return true;
            }else{
                return false;
            }
        }
        
    }
    
    public function can($permission_name, $requireAll = false){ 
        $key = __CLASS__.$this->{$this->primaryKey}.__FUNCTION__.$permission_name;
        if(Cache::getStore() instanceof TaggableStore) {
            return Cache::tags('ZaclUser')->remember($key, Lib::getExpiredCache(), function () use ($permission_name) {
                foreach ($this->roles as $role) {
                    if($role->hasPermission($permission_name)){
                        return true;
                    }
                }
                return false;
            });
        }else{
            foreach ($this->roles as $role) {
                if($role->hasPermission($permission_name)){
                    return true;
                }
            }
            return false;
        }
        
    }
    
    public function attachRole($role)
    {
        if(is_object($role)) {
            $role = $role->getKey();
        }

        if(is_array($role)) {
            $role = $role['id'];
        }

        $this->roles()->attach($role);
    }

    public function detachRole($role)
    {
        if (is_object($role)) {
            $role = $role->getKey();
        }

        if (is_array($role)) {
            $role = $role['id'];
        }

        $this->roles()->detach($role);
    }

    public function attachRoles($roles)
    {
        foreach ($roles as $role) {
            $this->attachRole($role);
        }
    }

    public function detachRoles($roles=null)
    {
        if (!$roles) $roles = $this->roles()->get();
        foreach ($roles as $role) {
            $this->detachRole($role);
        }
    }
    public function save(array $options = [])
    {   //both inserts and updates
        if(Cache::getStore() instanceof TaggableStore) {
            Cache::tags('ZaclUser')->flush();
        }
        return parent::save($options);
    }
    public function delete(array $options = [])
    {   //soft or hard
        parent::delete($options);
        if(Cache::getStore() instanceof TaggableStore) {
            Cache::tags('ZaclUser')->flush();
        }
    }
    public function restore()
    {   //soft delete undo's
        parent::restore();
        if(Cache::getStore() instanceof TaggableStore) {
            Cache::tags('ZaclUser')->flush();
        }
    }
}
