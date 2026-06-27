<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\DaftarPoli;
use App\Models\DetailPeriksa;
use App\Models\Obat;
use App\Models\Periksa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeriksaPasienController extends Controller
{
    public function index()
    {
        $dokterId = Auth::id();

        $daftarPasien = DaftarPoli::with(['pasien', 'jadwalPeriksa', 'periksas'])
            ->whereHas('jadwalPeriksa', function ($query) use ($dokterId) {
                $query->where('id_dokter', $dokterId);
            })
            ->orderBy('no_antrian')
            ->get();

        return view('dokter.periksa-pasien.index', compact('daftarPasien'));
    }

    public function create($id)
    {
        $obats = Obat::all();
        return view('dokter.periksa-pasien.create', compact('obats', 'id'));
    }

    public function store(Request $request)
    {
        // 1. Validasi Input Dasar
        $request->validate([
            'obat_json' => 'required',
            'catatan' => 'nullable|string',
            'biaya_periksa' => 'required|integer',
        ]);

        $obatIds = json_decode($request->obat_json, true);

        // 2. VALIDASI STOK HABIS (Handling Stok Habis)
        // Kita cek satu per satu obat yang dipilih dokter.
        // Jika ada satu saja yang stoknya <= 0, proses dibatalkan.
        if (!empty($obatIds)) {
            foreach ($obatIds as $idObat) {
                $obat = Obat::find($idObat);
                if ($obat && $obat->stok <= 0) {
                    return redirect()->back()
                        ->with('error', 'Gagal menyimpan! Stok obat "' . $obat->nama_obat . '" sudah habis.')
                        ->withInput(); // Mengembalikan input sebelumnya agar dokter tidak perlu mengetik ulang catatan
                }
            }
        }

        // 3. Simpan Data Periksa
        $periksa = Periksa::create([
            'id_daftar_poli' => $request->id_daftar_poli,
            'tgl_periksa' => now(),
            'catatan' => $request->catatan,
            'biaya_periksa' => $request->biaya_periksa + 150000,
        ]);

        // 4. Simpan Detail Periksa & PENGURANGAN STOK OTOMATIS
        if (!empty($obatIds)) {
            foreach ($obatIds as $idObat) {
                DetailPeriksa::create([
                    'id_periksa' => $periksa->id,
                    'id_obat' => $idObat,
                ]);

                // Logika mengurangi stok obat sebanyak 1
                $obat = Obat::find($idObat);
                if ($obat) {
                    $obat->decrement('stok', 1);
                }
            }
        }

        // 5. Kembalikan ke halaman index dengan notifikasi sukses
        return redirect()->route('periksa-pasien.index')
            ->with('success', 'Data periksa berhasil disimpan dan stok obat otomatis dikurangi.');
    }
}