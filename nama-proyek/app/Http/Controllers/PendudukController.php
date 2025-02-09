<?php

namespace App\Http\Controllers;

use App\Models\Penduduk;
use Illuminate\Http\Request;

class PendudukController extends Controller
{
    public function index()
    {
        // Ambil semua data penduduk
        $data = Penduduk::all();

        // Ambil nama provinsi dan jumlah penduduk (Total)
        $labels = $data->pluck('provinsi');
        $jumlah = $data->pluck('Total');

        // Hitung total jumlah penduduk
        $totalPenduduk = $data->sum('Total');
        
        // Kirim data ke view
        return view('grafik', compact('labels', 'jumlah', 'totalPenduduk'));
    }
}
