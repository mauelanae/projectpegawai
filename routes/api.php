<?php

use App\Http\Controllers\ApipegawaiController;
use Illuminate\Support\Facades\Route;

Route::get('/pegawai', [ApipegawaiController::class, 'index']);
