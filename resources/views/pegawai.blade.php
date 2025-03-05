<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Document</title>
    @vite('resources/css/app.css')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.1.5/js/fileinput.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css"
        rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.1.5/css/fileinput.min.css"
        rel="stylesheet">
</head>

<body class="bg-gray-100 py-6 px-6 overflow-hidden">
    <div class="max-w-7xl mx-auto">
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 p-3 rounded mb-4">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <h2 class="text-3xl font-bold mt-6 mb-4 text-gray-700">Data Pegawai</h2>

        <!-- Filter dan Pencarian -->
        <div class="flex flex-wrap gap-4 mb-4">
            <input type="text" id="searchBox" class="border border-black p-2 rounded w-full md:w-1/3"
                placeholder="Cari data...">
            <select id="columnFilter" class="border border-black p-2 rounded w-full md:w-1/3">
                <option value="0">Nama</option>
                <option value="1">Telepon</option>
                <option value="2">Email</option>
                <option value="3">Jenis Kelamin</option>
                <option value="4">Posisi</option>
                <option value="5">Tanggal Masuk</option>
            </select>
            <select id="sortOrder" class="border border-black p-2 rounded w-full md:w-1/3">
                <option value="asc">Ascending</option>
                <option value="desc">Descending</option>
            </select>
        </div>

        <!-- Tombol Tambah Pegawai -->
        <div class="mt-6 mb-4 text-right">
            <button id="openModal" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">
                Tambah Pegawai
            </button>
        </div>

        <!-- Tabel Data -->
        <div class="bg-white p-4 shadow-md rounded-lg overflow-x-auto">
            <table id="pegawaiTable" class="w-full border rounded-md">
                <thead>
                    <tr class="bg-gray-200 text-gray-700">
                        @foreach (['Nama', 'Telepon', 'Email', 'Jenis Kelamin', 'Posisi', 'Tanggal Masuk', 'Foto', 'Aksi'] as $head)
                            <th class="border p-3 text-left">{{ $head }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pegawais as $pegawai)
                        <tr class="hover:bg-gray-100 transition">
                            @foreach (['nama', 'telepon', 'email', 'jenis_kelamin', 'posisi', 'tanggal_masuk'] as $field)
                                <td class="p-3 border">{{ $pegawai->$field }}</td>
                            @endforeach
                            <td class="p-3 border text-center">
                                @if ($pegawai->foto)
                                    <img src="{{ asset('storage/' . $pegawai->foto) }}" alt="Foto Pegawai"
                                        class="h-12 w-12 rounded-full mx-auto">
                                @else
                                    <span class="text-gray-400">Tidak ada foto</span>
                                @endif
                            </td>
                            <td class="p-3 border text-center">
                                <form action="{{ route('pegawai.destroy', $pegawai->id) }}" method="POST"
                                    class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="deletePegawai bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center p-4 text-gray-500">Tidak ada data pegawai</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Tambah Pegawai -->
    <div id="pegawaiModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96">
            <h3 class="text-xl font-semibold mb-4 text-gray-700">Tambah Pegawai</h3>
            <form id="pegawaiForm" action="{{ route('pegawai.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="text" name="nama" class="border p-2 w-full mb-2 rounded" placeholder="Nama" required>
                <input type="text" name="telepon" class="border p-2 w-full mb-2 rounded" placeholder="Telepon"
                    required>
                <input type="email" name="email" class="border p-2 w-full mb-2 rounded" placeholder="Email"
                    required>
                <select name="jenis_kelamin" class="border p-2 w-full mb-2 rounded">
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
                <input type="text" name="alamat" class="border p-2 w-full mb-2 rounded" placeholder="Alamat"
                    required>
                <select name="posisi" class="border p-2 w-full mb-2 rounded">
                    <option value="Manager">Manager</option>
                    <option value="Staff">Staff</option>
                </select>
                <input type="date" name="tanggal_masuk" class="border p-2 w-full mb-2 rounded" required>

                <!-- Dropzone untuk Foto -->
                <label for="fotoUpload"
                    class="block border border-dashed p-4 text-center mb-2 rounded cursor-pointer">
                    <span class="text-gray-500">Klik atau seret foto ke sini</span>
                </label>
                <input type="file" id="fotoUpload" name="foto" class="hidden" accept="image/*">

                <!-- Nama File & Tombol Hapus -->
                <p id="fileName" class="hidden mt-2 text-sm text-gray-700"></p>
                <button type="button" id="removeFile" class="hidden mt-2 bg-red-500 text-white px-3 py-1 rounded">
                    Hapus File
                </button>

                <div class="mt-4 flex justify-end gap-2">
                    <button type="button" id="closeModal"
                        class="bg-gray-400 text-white px-3 py-1 rounded">Batal</button>
                    <button type="submit"
                        class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</body>

<script>
    $(document).ready(function() {
        // Inisialisasi DataTable dengan reset jika sudah ada
        let table = $('#pegawaiTable').DataTable({
            destroy: true,
            lengthChange: false,
            searching: false,
            pageLength: 6,
            language: {
                paginate: {
                    previous: '<i class="fas fa-angle-left text-gray-700 px-3 py-2"></i>',
                    next: '<i class="fas fa-angle-right text-gray-700 px-3 py-2"></i>'
                }
            },
            drawCallback: function() {
                // Menambahkan styling pada pagination
                $('.dataTables_paginate').addClass('flex items-center justify-center gap-2 mt-4');
                $('.dataTables_paginate .paginate_button').addClass(
                    'px-3 py-2 border border-gray-300 rounded-lg bg-white hover:bg-gray-200 transition'
                );
                $('.dataTables_paginate .paginate_button.current').addClass(
                    'bg-gray-300 font-bold');
            }
        });

        // Filter pencarian berdasarkan kolom tertentu
        $('#searchBox').on('keyup', function() {
            let column = $('#columnFilter').val();
            table.column(column).search(this.value).draw();
        });

        // Sorting tabel berdasarkan pilihan dropdown
        $('#sortOrder').on('change', function() {
            let column = $('#columnFilter').val();
            let order = $(this).val();
            table.order([column, order]).draw();
        });

        // Tampilkan modal tambah pegawai
        $('#openModal').on('click', function() {
            $('#pegawaiModal').removeClass('hidden').fadeIn();
        });

        // Tutup modal
        $('#closeModal').on('click', function() {
            $('#pegawaiModal').fadeOut();
        });

        // Inisialisasi Dropzone
        $("#dropzoneFoto").on("dragover", function(event) {
            event.preventDefault();
            $(this).addClass("border-blue-500");
        });

        $("#dropzoneFoto").on("dragleave", function(event) {
            event.preventDefault();
            $(this).removeClass("border-blue-500");
        });

        $("#dropzoneFoto").on("drop", function(event) {
            event.preventDefault();
            $(this).removeClass("border-blue-500");

            let files = event.originalEvent.dataTransfer.files;
            if (files.length > 0) {
                let file = files[0];

                // Simpan file ke input hidden
                $("#fotoUpload")[0].files = event.originalEvent.dataTransfer.files;

                // Tampilkan nama file
                $("#fileName").text(file.name).removeClass("hidden");
                $("#removeFile").removeClass("hidden");
            }
        });

        // Jika pengguna mengklik dropzone, aktifkan input file
        $("#dropzoneFoto").on("click", function() {
            $("#fotoUpload").click();
        });

        // Jika pengguna memilih file dari input, tampilkan nama file
        $("#fotoUpload").on("change", function(event) {
            let file = event.target.files[0];
            if (file) {
                $("#fileName").text(file.name).removeClass("hidden");
                $("#removeFile").removeClass("hidden");
            }
        });

        // Hapus file yang diunggah
        $("#removeFile").on("click", function() {
            $("#fotoUpload").val(""); // Kosongkan input file
            $("#fileName").addClass("hidden").text(""); // Sembunyikan nama file
            $("#removeFile").addClass("hidden"); // Sembunyikan tombol hapus
        });

        // Konfirmasi sebelum hapus data
        $('.deletePegawai').on('click', function(e) {
            if (!confirm("Yakin ingin menghapus data ini?")) {
                e.preventDefault();
            }
        });
    });
</script>
</body>

</html>
