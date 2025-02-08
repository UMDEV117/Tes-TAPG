<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penduduk;

class PendudukController extends Controller
{
    public function index()
    {
        $data = Penduduk::all();
        $labels = $data->pluck('provinsi');
        $jumlah = $data->pluck('jumlah');

        return view('grafik', compact('labels', 'jumlah'));
    }
}

