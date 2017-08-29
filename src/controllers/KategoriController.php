<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Jalinmodule\Barang\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class KategoriController extends Controller
{
    public function __construct()
    {
        
    }

    public function index()
    {
        $kategoris = DB::select('select * from kategori order by id desc ');
        return view('kategori/index', ['data' => $kategoris]);
    }
    
    public function newkategori()
    {
        return view('kategori/formkategori', []);
    }
    
    public function store(Request $request)
    {       
        if($request->name){
            DB::table('kategori')->insert([
                'name' => $request->name,
            ]);
        }
        return redirect('kategori');
    }

}
