<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;

class ApipegawaiController extends Controller
{
    public function index()
    {
        $data = Pegawai::all();
        return response()->json([
            'pesan' => 'Data berhasil diambil',
            'data' => $data
        ]);
    }
}
