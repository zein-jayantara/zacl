<?php

Route::group(['middleware' => ['web','auth']], function () {
    Route::get('barang', 'Jalinmodule\Barang\Controllers\BarangController@index');
    Route::get('barangnew', 'Jalinmodule\Barang\Controllers\BarangController@newbarang');
    Route::post('barang', 'Jalinmodule\Barang\Controllers\BarangController@store');
});



