<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Poli;

class PoliController extends Controller
{
    public function index()
    {
        $polis = Poli::all();
        return view('admin.polis.index', compact('polis'));
    }

    public function create()
    {
        return view('admin.polis.create');
    }

    public function store(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'nama_poli' => 'required|string|max:255',
            'keterangan' => 'nullable|string'
        ]);

        // Simpan ke database
        Poli::create($request->all());

        // Kembali ke halaman index dengan pesan sukses
        return redirect()->route('polis.index')->with('success', 'Data Poli berhasil ditambahkan!');
    }

    public function show(string $id)
    {
        return redirect()->route('polis.index');
    }

    public function edit(string $id)
    {
        $poli = Poli::findOrFail($id);
        return view('admin.polis.edit', compact('poli'));
    }

    public function update(Request $request, string $id)
    {
        // Validasi input dari form edit
        $request->validate([
            'nama_poli' => 'required|string|max:255',
            'keterangan' => 'nullable|string'
        ]);

        // Cari data dan update
        $poli = Poli::findOrFail($id);
        $poli->update($request->all());

        // Kembali ke halaman index dengan pesan sukses
        return redirect()->route('polis.index')->with('success', 'Data Poli berhasil diubah!');
    }

    public function destroy(string $id)
    {
        // Cari data dan hapus
        $poli = Poli::findOrFail($id);
        $poli->delete();

        // Kembali ke halaman index dengan pesan sukses
        return redirect()->route('polis.index')->with('success', 'Data Poli berhasil dihapus!');
    }
}