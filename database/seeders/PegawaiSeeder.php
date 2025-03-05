<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pegawai;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PegawaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pegawais')->truncate(); // Menghapus data lama sebelum menambahkan data baru

        Pegawai::create([
            'nama' => 'Ahmad Fauzi',
            'telepon' => '081234567890',
            'email' => 'ahmad@example.com',
            'jenis_kelamin' => 'Laki-laki',
            'alamat' => 'Jl. Merdeka No.10, Jakarta',
            'posisi' => 'Manager',
            'tanggal_masuk' => '2022-05-10',
        ]);

        Pegawai::create([
            'nama' => 'Siti Aisyah',
            'telepon' => '082345678901',
            'email' => 'siti@example.com',
            'jenis_kelamin' => 'Perempuan',
            'alamat' => 'Jl. Soekarno No.15, Bandung',
            'posisi' => 'Staff',
            'tanggal_masuk' => '2023-02-15',
        ]);

        Pegawai::create([
            'nama' => 'Dwi Achmad',
            'telepon' => '0812345673456',
            'email' => 'Dwi@example.com',
            'jenis_kelamin' => 'Laki-laki',
            'alamat' => 'Jl. Raya MADIUN',
            'posisi' => 'Staff',
            'tanggal_masuk' => '2022-05-10',
        ]);

        Pegawai::create([
            'nama' => 'Dwi Septianingrum',
            'telepon' => '082345671234',
            'email' => 'Septi@example.com',
            'jenis_kelamin' => 'Perempuan',
            'alamat' => 'Jl. Soekarno No.15, Magetan',
            'posisi' => 'Staff',
            'tanggal_masuk' => '2023-02-15',
        ]);

        Pegawai::create([
            'nama' => 'David Sahrul',
            'telepon' => '082345674567',
            'email' => 'David@example.com',
            'jenis_kelamin' => 'Laki-laki',
            'alamat' => 'Jl. bacem, Blora',
            'posisi' => 'Staff',
            'tanggal_masuk' => '2023-02-15',
        ]);

        Pegawai::create([
            'nama' => 'Azmi Nur',
            'telepon' => '082345234567',
            'email' => 'azmi@example.com',
            'jenis_kelamin' => 'Laki-laki',
            'alamat' => 'Jl. Soekarno No.15, Bandung',
            'posisi' => 'Staff',
            'tanggal_masuk' => '2023-02-15',
        ]);

        Pegawai::create([
            'nama' => 'Azizul',
            'telepon' => '082345671234',
            'email' => 'azizul@example.com',
            'jenis_kelamin' => 'Laki-laki',
            'alamat' => 'Jl. Soekarno No.34, Bandung',
            'posisi' => 'Staff',
            'tanggal_masuk' => '2023-02-15',
        ]);

        Pegawai::create([
            'nama' => 'Andra',
            'telepon' => '082345672332',
            'email' => 'andra@example.com',
            'jenis_kelamin' => 'Laki-laki',
            'alamat' => 'Jl. hatta No.22, Bandung',
            'posisi' => 'Staff',
            'tanggal_masuk' => '2023-02-15',
        ]);

        Pegawai::create([
            'nama' => 'Fajar',
            'telepon' => '082345678901',
            'email' => 'fajar@example.com',
            'jenis_kelamin' => 'Laki-laki',
            'alamat' => 'Jl. Soekarno No.15, Bandung',
            'posisi' => 'Staff',
            'tanggal_masuk' => '2023-02-15',
        ]);


    }
}
