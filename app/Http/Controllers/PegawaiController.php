<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PegawaiController extends Controller
{
    public function index()
    {
        $pegawais = Pegawai::all();
        return view('pegawai', compact('pegawais'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'telepon' => 'required',
            'email' => 'required|email|unique:pegawais',
            'jenis_kelamin' => 'required',
            'alamat' => 'required',
            'posisi' => 'required',
            'tanggal_masuk' => 'required|date',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('uploads', 'public');
        }

        Pegawai::create(array_merge($request->all(), ['foto' => $fotoPath]));

        return redirect()->back()->with('success', 'Pegawai berhasil ditambahkan!');
    }

    public function uploadFoto(Request $request)
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $path = $file->store('uploads', 'public');
            return response()->json(['path' => asset('storage/' . $path)]);
        }

        return response()->json(['error' => 'Gagal mengupload foto'], 400);
    }

    public function destroy($id)
    {
        $pegawai = Pegawai::find($id);
        if (!$pegawai) {
            return response()->json(['message' => 'Data tidak ditemukan!'], 404);
        }

        try {
            if ($pegawai->foto) {
                Storage::disk('public')->delete($pegawai->foto);
            }
            $pegawai->delete();
            return response()->json(['message' => 'Data berhasil dihapus!']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal menghapus data: ' . $e->getMessage()], 500);
        }
    }
}