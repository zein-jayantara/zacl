# JMI Barang

Testing module barang


## Installation Step
1. Composer  
    * require and repositories
    
    ```
    "require": {
        ...

        "zein-jayantara/zacl": "1.*"
    },
    ```
    * Update composer
    
    ```
    composer update
    ```

2. config/app.php 
    
    * providers
   
    ```
    Zein\Zacl\ZaclServiceProvider::class,
    ```
    
3. artisan
   
    ```
    php artisan vendor:publish
    ```

    ```
    php artisan entrust:migration
    ```
    
    ```
    php artisan migrate
    ```

4. buat field api_token(varchar 255->unique) and isadmin(enum:0,1->default:0) pada table users 
    
5. route

    ```
    Route::get('role', 'Zein\Zacl\Controllers\RolesController@index');
    Route::post('role', 'Zein\Zacl\Controllers\RolesController@store');
    Route::get('role/{id}', 'Zein\Zacl\Controllers\RolesController@show');
    Route::delete('role/{id}', 'Zein\Zacl\Controllers\RolesController@delete');
    
    Route::get('permission', 'Zein\Zacl\Controllers\PermissionsController@index');
    Route::post('permission', 'Zein\Zacl\Controllers\PermissionsController@store');
    Route::get('permission/{id}', 'Zein\Zacl\Controllers\PermissionsController@show');
    Route::delete('permission/{id}', 'Zein\Zacl\Controllers\PermissionsController@delete');
    
    Route::get('permissionofrole/{roleid}', 'Zein\Zacl\Controllers\PermissionsrolesController@permissionofrole');
    Route::get('roleofpermission/{permissionid}', 'Zein\Zacl\Controllers\PermissionsrolesController@roleofpermission');
    Route::post('permissionrole', 'Zein\Zacl\Controllers\PermissionsrolesController@attach');
    Route::delete('permissionrole', 'Zein\Zacl\Controllers\PermissionsrolesController@unattach');
    
    Route::get('roleofuser/{userid}', 'Zein\Zacl\Controllers\RolesusersController@roleofuser');
    Route::get('userofrole/{roleid}', 'Zein\Zacl\Controllers\RolesusersController@userofrole');
    Route::post('roleuser', 'Zein\Zacl\Controllers\RolesusersController@attach');
    Route::delete('roleuser', 'Zein\Zacl\Controllers\RolesusersController@unattach');
    ```


## Usage example
```
http://localhost:8000/zacl/roleofpermission/1?api_token=1234
```
