<?php

use App\Mail\TestEmail;
use Mews\Captcha\Facades\Captcha;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KaryawanController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// ---------- AUTH ----------
Route::get('/register', [AuthController::class, 'registerForm'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::get('/login', [AuthController::class, 'loginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ---------- REDIRECT ROOT ----------
Route::get('/', function () {
    return redirect()->route('karyawan.index');
});

// ---------- PROTECTED ROUTES ----------
Route::middleware('auth')->group(function () {
    Route::resource('karyawan', KaryawanController::class);
    Route::get('karyawan/export/pdf', [KaryawanController::class, 'exportPdf'])->name('karyawan.export.pdf');
    Route::get('karyawan/export/excel', [KaryawanController::class, 'exportExcel'])->name('karyawan.export.excel');
    Route::post('karyawan/import/excel', [KaryawanController::class, 'importExcel'])->name('karyawan.import.excel');
});

// ---------- CAPTCHA ----------
Route::get('/reload-captcha', function () {
    return response()->json([
        'captcha' => Captcha::img()
    ]);
});

// ---------- TEST EMAIL ----------
Route::get('/kirim-email', function () {

    $data = [
        'message' => 'Ini adalah email percobaan.'
    ];

    Mail::to('surisalbi303@gmail.com')->send(new TestEmail($data));

    return "Email berhasil dikirim!";
});