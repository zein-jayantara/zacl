<?php

Route::group(['prefix' => 'zacl','middleware' => ['auth:api','isadmin:api']], function () {
    
    Route::get('role', 'Zein\Zacl\Controllers\RolesController@index');
    Route::post('role', 'Zein\Zacl\Controllers\RolesController@store');
    Route::get('role/{id}', 'Zein\Zacl\Controllers\RolesController@show');
    Route::delete('role/{id}', 'Zein\Zacl\Controllers\RolesController@delete');
    
    Route::get('permission', 'Zein\Zacl\Controllers\PermissionsController@index');
    Route::post('permission', 'Zein\Zacl\Controllers\PermissionsController@store');
    Route::get('permission/{id}', 'Zein\Zacl\Controllers\PermissionsController@show');
    Route::delete('permission/{id}', 'Zein\Zacl\Controllers\PermissionsController@delete');
    
    Route::post('attach', 'Zein\Zacl\Controllers\PermissionsrolesController@attach');
    Route::post('unattach', 'Zein\Zacl\Controllers\PermissionsrolesController@unattach');
    
});