<?php

Route::group(['prefix' => 'zacl','middleware' => ['auth:api','authorizeroute:api']], function () {
    
    Route::get('role', ['as' => 'zacl.role.index', 'description'=>'List of roles', 'uses' => 'Zein\Zacl\Controllers\RolesController@index']);
    Route::post('role', ['as' => 'zacl.role.store', 'description'=>'Create role', 'uses' => 'Zein\Zacl\Controllers\RolesController@store']);
    Route::get('role/{id}', ['as' => 'zacl.role.show',  'description'=>'Display role', 'uses' => 'Zein\Zacl\Controllers\RolesController@show']);
    Route::delete('role/{id}', ['as' => 'zacl.role.delete',  'description'=>'Delete role', 'uses' => 'Zein\Zacl\Controllers\RolesController@delete']);
    
    Route::get('permission', ['as' => 'zacl.permission.index',  'description'=>'List of permission', 'uses' => 'Zein\Zacl\Controllers\PermissionsController@index']);
    Route::post('permission', ['as' => 'zacl.permission.store',  'description'=>'Create permission', 'uses' => 'Zein\Zacl\Controllers\PermissionsController@store']);
    Route::get('permission/{id}', ['as' => 'zacl.permission.show',  'description'=>'Display permission', 'uses' => 'Zein\Zacl\Controllers\PermissionsController@show']);
    Route::delete('permission/{id}', ['as' => 'zacl.permission.delete',  'description'=>'Delete permission', 'uses' => 'Zein\Zacl\Controllers\PermissionsController@delete']);
    Route::post('syncroutepermission', ['as' => 'zacl.syncroutepermission.generate',  'description'=>'Generate route permissions', 'uses' => 'Zein\Zacl\Controllers\PermissionsController@generate']);
    
    Route::get('permissionofrole/{roleid}', ['as' => 'zacl.permissionofrole.permissionofrole',  'description'=>'List permission from role', 'uses' => 'Zein\Zacl\Controllers\PermissionsrolesController@permissionofrole']);
    Route::get('roleofpermission/{permissionid}', ['as' => 'zacl.roleofpermission.roleofpermission',  'description'=>'List role from permission', 'uses' => 'Zein\Zacl\Controllers\PermissionsrolesController@roleofpermission']);
    Route::post('permissionrole', ['as' => 'zacl.permissionrole.attach',  'description'=>'Add permission to role', 'uses' => 'Zein\Zacl\Controllers\PermissionsrolesController@attach']);
    Route::delete('permissionrole', ['as' => 'zacl.permissionrole.unattach',  'description'=>'Remove permission from role', 'uses' => 'Zein\Zacl\Controllers\PermissionsrolesController@unattach']);
    
    Route::get('roleofuser/{userid}', ['as' => 'zacl.roleofuser.roleofuser',  'description'=>'List role from user', 'uses' => 'Zein\Zacl\Controllers\RolesusersController@roleofuser']);
    Route::get('userofrole/{roleid}', ['as' => 'zacl.userofrole.userofrole',  'description'=>'List user from role', 'uses' => 'Zein\Zacl\Controllers\RolesusersController@userofrole']);
    Route::post('roleuser', ['as' => 'zacl.roleuser.attach',  'description'=>'Add role to user', 'uses' => 'Zein\Zacl\Controllers\RolesusersController@attach']);
    Route::delete('roleuser', ['as' => 'zacl.roleuser.unattach',  'description'=>'Remove role from user', 'uses' => 'Zein\Zacl\Controllers\RolesusersController@unattach']);
    
    
});