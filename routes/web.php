<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SuperAdmin\SuperAdminDashboardController;
use App\Http\Controllers\SuperAdmin\SuperAdminSettingController;
use App\Http\Controllers\SuperAdmin\SuperAdminProfileController;
use App\Http\Controllers\SuperAdmin\SuperAdminChangePasswordController;


use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SuperAdminController;
use App\Http\Controllers\Admin\GuruController;
use App\Http\Controllers\Admin\TenagaKependidikanController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Admin\PegawaiController;
use App\Http\Controllers\Admin\DataSiswaController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ChangePasswordController;
use App\Http\Controllers\Admin\AdminTampilanController;
use App\Http\Controllers\Admin\JurusanController;
use App\Http\Controllers\Admin\KelasController;
use App\Http\Controllers\Admin\DatabaseAbsensiController;
use App\Http\Controllers\Admin\JamGuruPerHariController;
use App\Http\Controllers\Admin\AbsensiExportController;
use App\Http\Controllers\Admin\SiswaPindahanController; 
use App\Http\Controllers\Admin\ExamController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\OptionController;
use App\Http\Controllers\Admin\ExamQuestionController;
use App\Http\Controllers\Admin\DataUjianSiswaController;
use App\Http\Controllers\Admin\ExamResultController;
use App\Http\Controllers\Admin\MapelController;


// guru
use App\Http\Controllers\Guru\GuruDashboardController;
use App\Http\Controllers\Guru\GuruSettingController;
use App\Http\Controllers\Guru\GuruProfileController;
use App\Http\Controllers\Guru\GuruChangePasswordController;
use App\Http\Controllers\Guru\GuruAbsensiController;
use App\Http\Controllers\Guru\AbsensiGuruLaporanController;
use App\Http\Controllers\Guru\GuruExamController;
use App\Http\Controllers\Guru\GuruExamQuestionController;

use App\Http\Controllers\Member\MemberDashboardController;
use App\Http\Controllers\Member\MemberSettingController;
use App\Http\Controllers\Member\MemberProfileController;
use App\Http\Controllers\Member\MemberChangePasswordController;
use App\Http\Controllers\Auth\SocialLoginController;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\Guru\GuruDataUjianSiswaController;







// SISWA
use App\Http\Controllers\Siswa\SiswaDashboardController;
use App\Http\Controllers\Siswa\SiswasController;
use App\Http\Controllers\Siswa\SiswaSettingController;
use App\Http\Controllers\Siswa\SiswaSpmbController;
use App\Http\Controllers\Admin\SiswaAbsensiLaporanController;
use App\Http\Controllers\Siswa\ElearningController;
use App\Http\Controllers\Siswa\UjianController;


Route::get('/', function () {
    return view('welcome');
});

// Login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Route untuk redirect ke Google OAuth
Route::get('/login/google', [SocialLoginController::class, 'redirectToGoogle'])->name('login.google');
// Route callback setelah Google login berhasil
Route::get('/login/google/callback', [SocialLoginController::class, 'handleGoogleCallback'])->name('login.google.callback');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');


// Menampilkan form lupa password (bisa diakses siapa pun)
Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotForm'])
    ->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])
    ->name('password.email');

Route::middleware(['auth', RoleMiddleware::class . ':super-admin'])
    ->prefix('super-admin')
    ->group(function () {
    Route::get('/dashboard', [SuperAdminDashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/profile', [SuperAdminProfileController::class, 'index'])->name('superadmin.profile.index');
    Route::get('/profile/edit', [SuperAdminProfileController::class, 'edit'])->name('superadmin.profile.edit');
    Route::put('/profile', [SuperAdminProfileController::class, 'update'])->name('superadmin.profile.update');
    Route::get('/settings', [SuperAdminSettingController::class, 'index'])->name('superadmin.settings.index');
    Route::get('ubahsandi', [SuperAdminChangePasswordController::class, 'showChangePasswordForm'])->name('superadmin.ubahsandi');
    Route::post('ubahsandi', [SuperAdminChangePasswordController::class, 'changePassword'])->name('superadmin.password.change');

});

Route::middleware(['auth', RoleMiddleware::class . ':admin'])
    ->prefix('admin')
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('/admin/settings', [SettingController::class, 'index'])->name('admin.settings');
        Route::get('/', [ProfileController::class, 'index'])->name('admin.profile.index');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('admin.profile.edit');
        Route::put('/update', [ProfileController::class, 'update'])->name('admin.profile.update');
        Route::get('ubahsandi', [ChangePasswordController::class, 'showChangePasswordForm'])->name('admin.ubahsandi');
        Route::post('ubahsandi', [ChangePasswordController::class, 'changePassword'])->name('admin.password.change');
        Route::get('/tampilan', [AdminTampilanController::class, 'index'])->name('admin.tampilan.index');
        Route::post('/tampilan', [AdminTampilanController::class, 'store'])->name('admin.tampilan.store');
        
        // Route::get('admin/tampilan/edit', [AdminTampilanController::class, 'edit'])->name('admin.tampilan.edit');
        // Route::post('admin/tampilan/update', [AdminTampilanController::class, 'update'])->name('admin.tampilan.update');
        // Route::get('admin/pelatih', [PelatihController::class, 'index'])->name('admin.pelatih.index');

        // super admin
        Route::get('admin/super-admin', [SuperAdminController::class, 'index'])->name('admin.super-admin.index');
        Route::get('admin/super-admin/create', [SuperAdminController::class, 'create'])->name('admin.super-admin.create');
        Route::post('admin/super-admin', [SuperAdminController::class, 'store'])->name('admin.super-admin.store');
        Route::get('admin/super-admin/{id}/edit', [SuperAdminController::class, 'edit'])->name('admin.super-admin.edit');
        Route::put('admin/super-admin/{id}', [SuperAdminController::class, 'update'])->name('admin.super-admin.update');
        Route::delete('admin/super-admin/{id}', [SuperAdminController::class, 'destroy'])->name('admin.super-admin.destroy');
        // Route Akun Guru (admin/guru)
        Route::get('admin/guru', [GuruController::class, 'index'])->name('admin.guru.index');
        Route::get('admin/guru/create', [GuruController::class, 'create'])->name('admin.guru.create');
        Route::post('admin/guru', [GuruController::class, 'store'])->name('admin.guru.store');
        Route::get('admin/guru/{id}/edit', [GuruController::class, 'edit'])->name('admin.guru.edit');
        Route::put('admin/guru/{id}', [GuruController::class, 'update'])->name('admin.guru.update');
        Route::delete('admin/guru/{id}', [GuruController::class, 'destroy'])->name('admin.guru.destroy');

        // tendik
        Route::get('admin/tendik', [TenagaKependidikanController::class, 'index'])->name('admin.tendik.index');
        Route::get('admin/tendik/create', [TenagaKependidikanController::class, 'create'])->name('admin.tendik.create');
        Route::post('admin/tendik', [TenagaKependidikanController::class, 'store'])->name('admin.tendik.store');
        Route::get('admin/tendik/{id}/edit', [TenagaKependidikanController::class, 'edit'])->name('admin.tendik.edit');
        Route::put('admin/tendik/{id}', [TenagaKependidikanController::class, 'update'])->name('admin.tendik.update');
        Route::delete('admin/tendik/{id}', [TenagaKependidikanController::class, 'destroy'])->name('admin.tendik.destroy');

        // siswa
        Route::get('admin/siswa', [SiswaController::class, 'index'])->name('admin.siswa.index');
        Route::get('admin/siswa/create', [SiswaController::class, 'create'])->name('admin.siswa.create');
        Route::post('admin/siswa', [SiswaController::class, 'store'])->name('admin.siswa.store');
        Route::get('admin/siswa/{id}/edit', [SiswaController::class, 'edit'])->name('admin.siswa.edit');
        Route::put('admin/siswa/{id}', [SiswaController::class, 'update'])->name('admin.siswa.update');
        Route::delete('admin/siswa/{id}', [SiswaController::class, 'destroy'])->name('admin.siswa.destroy');

        // data pegawai
        Route::get('/pegawai', [PegawaiController::class, 'index'])->name('pegawai.index');
        Route::get('/pegawai/create', [PegawaiController::class, 'create'])->name('pegawai.create');
        Route::post('/pegawai/store', [PegawaiController::class, 'store'])->name('admin.pegawai.store'); // <-- INI WAJIB ADA
        Route::get('/pegawai/{id}', [PegawaiController::class, 'show'])->name('pegawai.show'); // ← ini
        Route::get('/pegawai/{id}/edit', [PegawaiController::class, 'edit'])->name('admin.pegawai.edit');
        Route::put('/pegawai/{id}', [PegawaiController::class, 'update'])->name('pegawai.update');
        Route::delete('/pegawai/{id}', [PegawaiController::class, 'destroy'])->name('pegawai.destroy');
        Route::post('/admin/pegawai/jam-per-hari/store', [PegawaiController::class, 'storeJamPerHari'])->name('jamguru.store');
        Route::get('/jamguru/{pegawaiId}', [JamGuruPerHariController::class, 'index'])->name('jamguru.index');


        // data siswa 
        Route::get('/admin/data-siswa', [DataSiswaController::class, 'index'])->name('datasiswa.index');
        Route::get('siswa/create', [DataSiswaController::class, 'create'])->name('datasiswa.create');
        Route::post('siswa', [DataSiswaController::class, 'store'])->name('datasiswa.store');
        Route::get('siswa/{siswa}', [DataSiswaController::class, 'show'])->name('datasiswa.show');
        Route::get('siswa/{siswa}/edit', [DataSiswaController::class, 'edit'])->name('datasiswa.edit');
        Route::put('/datasiswa/{id}', [DataSiswaController::class, 'update'])->name('datasiswa.update');
        // Route::get('/admin/datasiswa/{id}/move', [DataSiswaController::class, 'move'])->name('datasiswa.move');
        Route::get('/admin/datasiswa/move', [DataSiswaController::class, 'move'])->name('datasiswa.move');
        Route::get('/admin/siswapindahan/{id}', [SiswaPindahanController::class, 'show'])->name('siswapindahan.show');
        Route::delete('/admin/siswapindahan/{id}', [SiswaPindahanController::class, 'destroy'])->name('siswapindahan.destroy');
        Route::post('/arsip/siswa/kembalikan', [SiswaPindahanController::class, 'kembalikan'])->name('arsip.siswa.kembalikan');


        Route::post('admin/arsip/siswa-keluar', [DataSiswaController::class, 'storeArsip'])->name('arsip.siswa.keluar');
        Route::delete('siswa/{siswa}', [DataSiswaController::class, 'destroy'])->name('datasiswa.destroy');
        Route::get('/admin/datasiswa/{id}/print', [DataSiswaController::class, 'print'])->name('datasiswa.print');
        Route::get('/admin/datasiswa/template', [DataSiswaController::class, 'downloadTemplate'])->name('datasiswa.download-template');

        // routes/web.php
        Route::get('/admin/data-siswa/template', [DataSiswaController::class, 'downloadTemplate'])->name('admin.data_siswa.download_template');
        Route::post('/admin/datasiswa/import', [DataSiswaController::class, 'import'])->name('datasiswa.import');
    
        
    // jurusan
    Route::get('/jurusan', [JurusanController::class, 'index'])->name('jurusan.index');
    Route::get('/jurusan/create', [JurusanController::class, 'create'])->name('jurusan.create');
    Route::post('/jurusan/store', [JurusanController::class, 'store'])->name('jurusan.store');
    Route::get('/jurusan/{id}', [JurusanController::class, 'show'])->name('jurusan.show');
    Route::get('/jurusan/{id}/edit', [JurusanController::class, 'edit'])->name('jurusan.edit');
    Route::put('/jurusan/{id}', [JurusanController::class, 'update'])->name('jurusan.update');
    Route::delete('/jurusan/{id}', [JurusanController::class, 'destroy'])->name('jurusan.destroy');

    // kelas
    Route::get('/kelas', [KelasController::class, 'index'])->name('kelas.index');
    Route::get('/kelas/create', [KelasController::class, 'create'])->name('kelas.create');
    Route::post('/kelas', [KelasController::class, 'store'])->name('kelas.store');
    Route::get('/kelas/{id}/edit', [KelasController::class, 'edit'])->name('kelas.edit');
    Route::put('/kelas/{id}', [KelasController::class, 'update'])->name('kelas.update');
    Route::delete('/kelas/{id}', [KelasController::class, 'destroy'])->name('kelas.destroy');

    // absensi
     Route::get('/guru', [DatabaseAbsensiController::class, 'guru'])->name('absensi.guru');
    Route::get('/tendik', [DatabaseAbsensiController::class, 'tendik'])->name('absensi.tendik');
    Route::get('/siswa', [DatabaseAbsensiController::class, 'siswa'])->name('absensi.siswa');

    // laporan
    Route::get('/laporan', [DatabaseAbsensiController::class, 'laporan'])->name('admin.absensi.laporan');
    Route::get('/download', [DatabaseAbsensiController::class, 'downloadExcel'])->name('download');
    Route::get('/admin/absensi/export-pdf', [DatabaseAbsensiController::class, 'exportPdf'])->name('admin.absensi.export.pdf');

    // mapel
   Route::get('/mapel', [MapelController::class, 'index'])->name('mapel.index'); // tampil semua
    Route::post('/mapel', [MapelController::class, 'store'])->name('mapel.store'); // tambah mapel
    Route::get('/mapel/{id}/edit', [MapelController::class, 'edit'])->name('mapel.edit'); // form edit
    Route::put('/mapel/{id}', [MapelController::class, 'update'])->name('mapel.update'); // update mapel
    Route::delete('/mapel/{id}', [MapelController::class, 'destroy'])->name('mapel.destroy'); // hapus mapel

    // Exams
        Route::get('/admin/e-learning/exams', [ExamController::class, 'index'])->name('admin.exams.index');
        Route::get('/admin/e-learning/exams/create', [ExamController::class, 'create'])->name('admin.exams.create');
        Route::post('/admin/e-learning/exams', [ExamController::class, 'store'])->name('admin.exams.store');
        Route::get('/admin/e-learning/exams/{exam}/edit', [ExamController::class, 'edit'])->name('admin.exams.edit');
        Route::put('/admin/e-learning/exams/{exam}', [ExamController::class, 'update'])->name('admin.exams.update');
        Route::delete('/admin/e-learning/exams/{exam}', [ExamController::class, 'destroy'])->name('admin.exams.destroy');


        // Route::get('exams/{exam}/questions', [ExamQuestionController::class, 'index'])->name('questions.index');
        // Route::get('exams/{exam}/questions/create', [ExamQuestionController::class, 'create'])->name('questions.create');
        // Route::post('exams/{exam}/questions', [ExamQuestionController::class, 'store'])->name('questions.store');
        Route::get('admin/exams/{exam}/exam-questions', [ExamQuestionController::class, 'index'])
        ->name('exam-questions.index');

        Route::post('admin/exams/{exam}/exam-questions', [ExamQuestionController::class, 'store'])
        ->name('exam-questions.store');
        
        // Edit soal
        Route::get('admin/exams/{exam}/questions/{question}/edit', [ExamQuestionController::class, 'edit'])
            ->name('questions.edit');
            
        Route::get('/admin/exams/{exam}/questions/edit-all', [ExamQuestionController::class, 'editAll'])->name('questions.editAll');
        Route::put('/admin/exams/{exam}/questions/update-all', [ExamQuestionController::class, 'updateAll'])->name('questions.updateAll');
        Route::put('admin/exams/{exam}/exam-questions', 
            [ExamQuestionController::class, 'updateAll']
        )->name('exam-questions.updateAll');


    // Update soal
    Route::put('admin/exams/{exam}/questions/{question}', [ExamQuestionController::class, 'update'])
        ->name('questions.update');

    // Hapus soal
    Route::delete('admin/exams/{exam}/questions/{question}', [ExamQuestionController::class, 'destroy'])
        ->name('questions.destroy');

    Route::get('/questions', [QuestionController::class, 'index'])->name('questions.index');
    Route::get('/questions/create', [QuestionController::class, 'create'])->name('questions.create');
    Route::post('/questions', [QuestionController::class, 'store'])->name('questions.store');
    Route::get('/questions/{question}/edit', [QuestionController::class, 'edit'])->name('questions.edit');
    Route::put('/questions/{question}', [QuestionController::class, 'update'])->name('questions.update');
    Route::delete('/questions/{question}', [QuestionController::class, 'destroy'])->name('questions.destroy');

    // Import & Template
    Route::post('e-learning/exams/{exam}/questions/import', [ExamQuestionController::class, 'import'])->name('questions.import');
    Route::get('e-learning/exams/{exam}/questions/template/download', [ExamQuestionController::class, 'downloadTemplate'])->name('questions.template');
    
     Route::get('/exam-results/{examId}', [ExamResultController::class, 'showResults'])
        ->name('exam-results.show');

    Route::get('/exam-results/{examId}/export', [ExamResultController::class, 'exportExcel'])
        ->name('exam-results.export');

    // Options
    Route::get('e-learning/questions/{question}/options', [OptionController::class, 'index'])->name('options.index');
    Route::get('e-learning/questions/{question}/options/create', [OptionController::class, 'create'])->name('options.create');
    Route::post('e-learning/questions/{question}/options', [OptionController::class, 'store'])->name('options.store');
    Route::get('e-learning/questions/{question}/options/{option}/edit', [OptionController::class, 'edit'])->name('options.edit');
    Route::put('e-learning/questions/{question}/options/{option}', [OptionController::class, 'update'])->name('options.update');
    Route::delete('e-learning/questions/{question}/options/{option}', [OptionController::class, 'destroy'])->name('options.destroy');



    // export
    Route::get('/admin/absensi/export', [AbsensiExportController::class, 'export'])->name('admin.absensi.export');

    // data ujian siswa 
    Route::get('data-ujian-siswa', [DataUjianSiswaController::class, 'index'])->name('data-ujian-siswa.index');
    Route::get('data-ujian-siswa/{exam}', [DataUjianSiswaController::class, 'show'])->name('data-ujian-siswa.show');
    Route::get('data-ujian-siswa/{exam}/export', [DataUjianSiswaController::class, 'export'])->name('data-ujian-siswa.export');




});




    Route::middleware(['auth', RoleMiddleware::class . ':guru'])
    ->prefix('guru')
    ->group(function () {
        Route::get('/dashboard', [GuruDashboardController::class, 'index'])->name('guru.dashboard');
        Route::get('/settings', [GuruSettingController::class, 'index'])->name('guru.settings');
        Route::get('/guru/settings', [GuruSettingController::class, 'index'])->name('guru.settings');
        Route::get('/', [GuruProfileController::class, 'index'])->name('guru.profile.index');
        Route::get('/profile/create', [GuruProfileController::class, 'create'])
        ->name('guru.profile.createprofile');

        
        // Menyimpan data profile baru
        Route::post('/profile', [GuruProfileController::class, 'store'])
            ->name('guru.profile.store');
        Route::get('/edit', [GuruProfileController::class, 'edit'])->name('guru.profile.edit');
        Route::put('/update', [GuruProfileController::class, 'update'])->name('guru.profile.update');
        Route::get('/ubah-sandi', [GuruChangePasswordController::class, 'showChangePasswordForm'])->name('guru.ubahsandi');
         Route::put('/ubah-sandi', [GuruChangePasswordController::class, 'changePassword'])->name('guru.ubahsandi.update');
         Route::get('absensi', [GuruAbsensiController::class, 'index'])->name('absensi.index');
         Route::post('absensi/masuk', [GuruAbsensiController::class, 'absenMasuk'])->name('guru.absensi.masuk');
         Route::post('absensi/pulang', [GuruAbsensiController::class, 'absenPulang'])->name('guru.absensi.pulang');
        Route::get('/guru/absensi/laporan', [AbsensiGuruLaporanController::class, 'laporan'])
        ->name('guru.absensi.laporan');

    // Exam
    Route::get('/exams', [\App\Http\Controllers\Guru\GuruExamController::class, 'index'])->name('guru.exams.index');
    Route::get('/exams/create', [\App\Http\Controllers\Guru\GuruExamController::class, 'create'])->name('guru.exams.create');
    Route::post('/exams', [\App\Http\Controllers\Guru\GuruExamController::class, 'store'])->name('guru.exams.store');
    Route::get('/exams/{exam}/edit', [\App\Http\Controllers\Guru\GuruExamController::class, 'edit'])->name('guru.exams.edit');
    Route::put('/exams/{exam}', [\App\Http\Controllers\Guru\GuruExamController::class, 'update'])->name('guru.exams.update');
    Route::delete('/exams/{exam}', [\App\Http\Controllers\Guru\GuruExamController::class, 'destroy'])->name('guru.exams.destroy');

    // Exam Questions
    Route::get('/exams/{exam}/exam-questions', [\App\Http\Controllers\Guru\GuruExamQuestionController::class, 'index'])
        ->name('guru.exam-questions.index');
    
    Route::post('/exams/{exam}/exam-questions', [\App\Http\Controllers\Guru\GuruExamQuestionController::class, 'store'])
        ->name('guru.exam-questions.store');

    // Edit semua soal
    Route::get('/exams/{exam}/questions/edit-all', [\App\Http\Controllers\Guru\GuruExamQuestionController::class, 'editAll'])
        ->name('guru.questions.editAll');
    Route::put('/exams/{exam}/questions/update-all', [\App\Http\Controllers\Guru\GuruExamQuestionController::class, 'updateAll'])
        ->name('guru.questions.updateAll');

    // Template & Import
    Route::get('/exams/{exam}/questions/template/download', [\App\Http\Controllers\Guru\GuruExamQuestionController::class, 'downloadTemplate'])
        ->name('guru.questions.template');
    Route::post('/exams/{exam}/questions/import', [\App\Http\Controllers\Guru\GuruExamQuestionController::class, 'import'])
        ->name('guru.questions.import');

    // Hasil Ujian
    Route::get('/exam-results/{examId}', [\App\Http\Controllers\Guru\GuruExamResultController::class, 'showResults'])
        ->name('guru.exam-results.show');
    Route::get('/exam-results/{examId}/export', [\App\Http\Controllers\Guru\GuruExamResultController::class, 'exportExcel'])
        ->name('guru.exam-results.export');

    // Options
    Route::get('/questions/{question}/options', [\App\Http\Controllers\Guru\GuruOptionController::class, 'index'])->name('guru.options.index');
    Route::get('/questions/{question}/options/create', [\App\Http\Controllers\Guru\GuruOptionController::class, 'create'])->name('guru.options.create');
    Route::post('/questions/{question}/options', [\App\Http\Controllers\Guru\GuruOptionController::class, 'store'])->name('guru.options.store');
    Route::get('/questions/{question}/options/{option}/edit', [\App\Http\Controllers\Guru\GuruOptionController::class, 'edit'])->name('guru.options.edit');
    Route::put('/questions/{question}/options/{option}', [\App\Http\Controllers\Guru\GuruOptionController::class, 'update'])->name('guru.options.update');
    Route::delete('/questions/{question}/options/{option}', [\App\Http\Controllers\Guru\GuruOptionController::class, 'destroy'])->name('guru.options.destroy');

    // Data ujian siswa
   // Daftar semua ujian siswa
    Route::get('data-ujian-siswa', [GuruDataUjianSiswaController::class, 'index'])
        ->name('guru.data-ujian-siswa.index');
    Route::get('data-ujian-siswa/{exam}', [GuruDataUjianSiswaController::class, 'show'])
        ->name('guru.data-ujian-siswa.show');
    Route::get('data-ujian-siswa/{exam}/export', [GuruDataUjianSiswaController::class, 'export'])
        ->name('guru.data-ujian-siswa.export');

    
    //     Route::get('ubahsandi', [ChangePasswordController::class, 'showChangePasswordForm'])->name('admin.ubahsandi');
    //     Route::post('ubahsandi', [ChangePasswordController::class, 'changePassword'])->name('admin.password.change');
    //     Route::get('/tampilan', [AdminTampilanController::class, 'index'])->name('admin.tampilan.index');
    //     Route::post('/tampilan', [AdminTampilanController::class, 'store'])->name('admin.tampilan.store');
    //     // Route::get('admin/tampilan/edit', [AdminTampilanController::class, 'edit'])->name('admin.tampilan.edit');
    //     // Route::post('admin/tampilan/update', [AdminTampilanController::class, 'update'])->name('admin.tampilan.update');
    //     // Route::get('admin/pelatih', [PelatihController::class, 'index'])->name('admin.pelatih.index');

    //     // super admin
    //     Route::get('admin/super-admin', [SuperAdminController::class, 'index'])->name('admin.super-admin.index');
    //     Route::get('admin/super-admin/create', [SuperAdminController::class, 'create'])->name('admin.super-admin.create');
    //     Route::post('admin/super-admin', [SuperAdminController::class, 'store'])->name('admin.super-admin.store');
    //     Route::get('admin/super-admin/{id}/edit', [SuperAdminController::class, 'edit'])->name('admin.super-admin.edit');
    //     Route::put('admin/super-admin/{id}', [SuperAdminController::class, 'update'])->name('admin.super-admin.update');
    //     Route::delete('admin/super-admin/{id}', [SuperAdminController::class, 'destroy'])->name('admin.super-admin.destroy');
    //     // Route Akun Guru (admin/guru)
    //     Route::get('admin/guru', [GuruController::class, 'index'])->name('admin.guru.index');
    //     Route::get('admin/guru/create', [GuruController::class, 'create'])->name('admin.guru.create');
    //     Route::post('admin/guru', [GuruController::class, 'store'])->name('admin.guru.store');
    //     Route::get('admin/guru/{id}/edit', [GuruController::class, 'edit'])->name('admin.guru.edit');
    //     Route::put('admin/guru/{id}', [GuruController::class, 'update'])->name('admin.guru.update');
    //     Route::delete('admin/guru/{id}', [GuruController::class, 'destroy'])->name('admin.guru.destroy');

    //     // tendik
    //     Route::get('admin/tendik', [TenagaKependidikanController::class, 'index'])->name('admin.tendik.index');
    //     Route::get('admin/tendik/create', [TenagaKependidikanController::class, 'create'])->name('admin.tendik.create');
    //     Route::post('admin/tendik', [TenagaKependidikanController::class, 'store'])->name('admin.tendik.store');
    //     Route::get('admin/tendik/{id}/edit', [TenagaKependidikanController::class, 'edit'])->name('admin.tendik.edit');
    //     Route::put('admin/tendik/{id}', [TenagaKependidikanController::class, 'update'])->name('admin.tendik.update');
    //     Route::delete('admin/tendik/{id}', [TenagaKependidikanController::class, 'destroy'])->name('admin.tendik.destroy');

    //     // siswa
    //     Route::get('admin/siswa', [SiswaController::class, 'index'])->name('admin.siswa.index');
    //     Route::get('admin/siswa/create', [SiswaController::class, 'create'])->name('admin.siswa.create');
    //     Route::post('admin/siswa', [SiswaController::class, 'store'])->name('admin.siswa.store');
    //     Route::get('admin/siswa/{id}/edit', [SiswaController::class, 'edit'])->name('admin.siswa.edit');
    //     Route::put('admin/siswa/{id}', [SiswaController::class, 'update'])->name('admin.siswa.update');
    //     Route::delete('admin/siswa/{id}', [SiswaController::class, 'destroy'])->name('admin.siswa.destroy');

    //     // data pegawai
    //     Route::get('/pegawai', [PegawaiController::class, 'index'])->name('pegawai.index');
    //     Route::get('/pegawai/create', [PegawaiController::class, 'create'])->name('pegawai.create');
    //     Route::post('/pegawai/store', [PegawaiController::class, 'store'])->name('admin.pegawai.store'); // <-- INI WAJIB ADA
    //     Route::get('/pegawai/{id}', [PegawaiController::class, 'show'])->name('pegawai.show'); // ← ini
    //     Route::get('/pegawai/{id}/edit', [PegawaiController::class, 'edit'])->name('admin.pegawai.edit');
    //     Route::put('/pegawai/{id}', [PegawaiController::class, 'update'])->name('pegawai.update');
    //     Route::delete('/pegawai/{id}', [PegawaiController::class, 'destroy'])->name('pegawai.destroy');

    //     // data siswa 
    //     Route::get('siswa', [DataSiswaController::class, 'index'])->name('datasiswa.index');
    // Route::get('siswa/create', [DataSiswaController::class, 'create'])->name('datasiswa.create');
    // Route::post('siswa', [DataSiswaController::class, 'store'])->name('datasiswa.store');
    // Route::get('siswa/{siswa}', [DataSiswaController::class, 'show'])->name('datasiswa.show');
    // Route::get('siswa/{siswa}/edit', [DataSiswaController::class, 'edit'])->name('datasiswa.edit');
    // Route::put('/datasiswa/{id}', [DataSiswaController::class, 'update'])->name('datasiswa.update');
    // Route::delete('siswa/{siswa}', [DataSiswaController::class, 'destroy'])->name('datasiswa.destroy');

    // // jurusan
    // Route::get('/jurusan', [JurusanController::class, 'index'])->name('jurusan.index');
    // Route::get('/jurusan/create', [JurusanController::class, 'create'])->name('jurusan.create');
    // Route::post('/jurusan/store', [JurusanController::class, 'store'])->name('jurusan.store');
    // Route::get('/jurusan/{id}', [JurusanController::class, 'show'])->name('jurusan.show');
    // Route::get('/jurusan/{id}/edit', [JurusanController::class, 'edit'])->name('jurusan.edit');
    // Route::put('/jurusan/{id}', [JurusanController::class, 'update'])->name('jurusan.update');
    // Route::delete('/jurusan/{id}', [JurusanController::class, 'destroy'])->name('jurusan.destroy');

    // // kelas
    // Route::get('/kelas', [KelasController::class, 'index'])->name('kelas.index');
    // Route::get('/kelas/create', [KelasController::class, 'create'])->name('kelas.create');
    // Route::post('/kelas', [KelasController::class, 'store'])->name('kelas.store');
    // Route::get('/kelas/{id}/edit', [KelasController::class, 'edit'])->name('kelas.edit');
    // Route::put('/kelas/{id}', [KelasController::class, 'update'])->name('kelas.update');
    // Route::delete('/kelas/{id}', [KelasController::class, 'destroy'])->name('kelas.destroy');
    });

    // Route siswa
        Route::middleware(['auth', RoleMiddleware::class . ':siswa'])
            ->prefix('siswa')
            ->group(function () {
                Route::get('/dashboard', [SiswaDashboardController::class, 'index'])->name('siswa.dashboard');
                 Route::get('/profile', [SiswasController::class, 'index'])->name('profile.siswa');
                 Route::get('/profile/edit', [SiswasController::class, 'edit'])->name('profile.siswa.edit');
                // Route::post('/profile/update', [SiswasController::class, 'update'])->name('profile.siswa.update');
                // Route::put('/siswa/profile/update', [SiswasController::class, 'update'])->name('profile.siswa.update');
                Route::put('/profile/update', [SiswasController::class, 'update'])->name('profile.siswa.update');
                Route::get('/settings', [SiswaSettingController::class, 'index'])->name('siswa.settings');
                Route::get('/ubah-sandi', [SiswaSettingController::class, 'ubahSandi'])->name('siswa.ubahsandi');
                Route::get('/spmb/daftar', [SiswaSpmbController::class, 'create'])->name('spmb.form');
                Route::post('/spmb/daftar', [SiswaSpmbController::class, 'store'])->name('spmb.store');
                Route::get('/absensi', [\App\Http\Controllers\Siswa\SiswaAbsensiController::class, 'index'])->name('siswa.absensi.index');
                Route::post('/absen-masuk', [\App\Http\Controllers\Siswa\SiswaAbsensiController::class, 'absenMasuk'])->name('siswa.absensi.masuk');
                Route::post('/absen-pulang', [\App\Http\Controllers\Siswa\SiswaAbsensiController::class, 'absenPulang'])->name('siswa.absensi.pulang');

                // elearning
                Route::get('/elearning', [ElearningController::class, 'index'])
                 ->name('siswa.e-learning.index');

                // Route untuk Ujian
                Route::get('ujian', [UjianController::class, 'index'])->name('siswa.ujian.index');
                Route::get('ujian/{id}', [UjianController::class, 'show'])->name('siswa.ujian.show');
                Route::post('ujian/{id}/submit', [UjianController::class, 'submit'])->name('siswa.ujian.submit');  
                Route::get('/siswa/ujian/{id}/hasil', [\App\Http\Controllers\Siswa\UjianController::class, 'hasil'])
                ->name('siswa.ujian.hasil');

            });

         
            

