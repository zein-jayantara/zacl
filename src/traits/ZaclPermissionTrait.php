<?php
namespace Zein\Zacl\Traits;

trait ZaclPermissionTrait{
    
    public function getRoles()
    {
        return $this->roles()->get();
    }
    
    public function roles()
    {
        return $this->belongsToMany('Zein\Zacl\Models\Role', 'permission_role','permission_id', 'role_id');
    }
    
}
