<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Jalinmodule\Barang\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Jalinmodule\Barang\Models\Barang;

class BarangController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $barangs = Barang::paginate(10);
        return view('inventaris/barang/index', ['data' => $barangs]);
    }
    
    public function newbarang()
    {
        return view('inventaris/barang/formbarang', []);
    }
    
    public function store(Request $request)
    {       
        if($request->name && $request->kategori_id){
            Barang::insert([
                'name' => $request->name,
                'kategori_id' => $request->kategori_id,
            ]);
        }
        return redirect('barang');
    }

}
