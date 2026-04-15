<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Poli;

class PoliController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mengambil semua data dari tabel poli
        $polis = Poli::all();

        // Memanggil file blade index dan mengirimkan data $polis
        // Catatan: Jika file index.blade.php ada di dalam folder resources/views/admin/, gunakan 'admin.index'.
        // Jika ada di dalam sub-folder (misal resources/views/admin/poli/), ubah menjadi 'admin.poli.index'
        return view('admin.polis.index', compact('polis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Memanggil file resources/views/admin/polis/create.blade.php
        return view('admin.polis.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
    // Cari data poli berdasarkan ID-nya
    $poli = Poli::findOrFail($id);
        
    // Panggil file resources/views/admin/polis/edit.blade.php dan kirim datanya
    return view('admin.polis.edit', compact('poli'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}