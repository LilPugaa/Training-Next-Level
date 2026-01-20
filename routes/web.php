<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BatchController;
use App\Http\Controllers\BatchParticipantController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\BranchPicController;

Route::get('/', function () {
    if(Auth::check()) {
        return redirect()->route(Auth::user()->role->name . '.dashboard');
    }
    return redirect()->route('login');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');


// <!---------------- Admin Routes ---------------->
Route::get('/admin/dashboard', function () {
    return view('admin.master-dashboard');
})->middleware(['auth'])->name('admin.dashboard');
// Route::middleware(['auth'])->group(function () {
//     Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])
//         ->name('admin.dashboard');
// });

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/batch-oversight', function () {
        return view('admin.batch-oversight');
    })->name('batch-oversight');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/role-permission', [AdminController::class, 'index'])
        ->name('admin.role-permission');
});

Route::middleware(['auth'])->group(function () {
    Route::post('/admin/users', [UserController::class, 'store'])->name('users.store');
});

// Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
// Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
Route::resource('users', UserController::class);

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/global-report', function () {
        return view('admin.global-report');
    })->name('global-report');
});

// Route::middleware(['auth'])
//     ->prefix('admin/global-report')
//     ->name('global-report.')
//     ->group(function () {

//         Route::get('/', function () {
//             return view('admin.global-report.bulanan');
//         })->name('bulanan');

//         Route::get('/cabang', function () {
//             return view('admin.global-report.cabang');
//         })->name('cabang');

//         Route::get('/performa', function () {
//             return view('admin.global-report.performa');
//         })->name('performa');
//     });


Route::middleware(['auth'])->group(function () {
    Route::get('/admin/audit-log', function () {
        return view('admin.audit-log');
    })->name('audit-log');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/settings', function () {
        return view('admin.settings');
    })->name('settings');
});


// <!---------------- Coordinator Routes ---------------->
Route::middleware(['auth'])->group(function () {
    Route::get('/coordinator/dashboard', [BatchController::class, 'dashboard'])
        ->name('coordinator.dashboard');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/coordinator/kategori-pelatihan', [CategoryController::class, 'index'])
        ->name('kategori-pelatihan');

    Route::post('/coordinator/kategori-pelatihan', [CategoryController::class, 'store'])
        ->name('kategori-pelatihan.store');

    Route::put('/coordinator/kategori-pelatihan/{category}', [CategoryController::class, 'update'])
        ->name('kategori-pelatihan.update');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/coordinator/batch-management', [BatchController::class, 'index'])
        ->name('batch-management');

    Route::post('/coordinator/batch-management', [BatchController::class, 'store'])
        ->name('batch-management.store');

    Route::put('/coordinator/batch-management/{batch}', [BatchController::class, 'update'])
        ->name('batch-management.update');

    Route::delete('/coordinator/batch-management/{batch}', [BatchController::class, 'destroy'])
        ->name('batch-management.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/coordinator/validasi-peserta', function () {
        return view('coordinator.validasi-peserta');
    })->name('validasi-peserta');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/coordinator/monitoring-absensi', [BatchController::class, 'monitoringAbsensi'])
        ->name('monitoring-absensi');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/coordinator/laporan', [BatchController::class, 'laporan'])
        ->name('laporan');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/coordinator/settings', function () {
        return view('coordinator.settings');
    })->name('settings-coordinator');
});


// <!---------------- Trainer Routes ----------------> 
Route::middleware(['auth'])->group(function () {
    Route::get('/trainer/dashboard', [MaterialController::class, 'trainerDashboard'])
        ->name('trainer.dashboard');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/trainer/batches', [MaterialController::class, 'trainerBatches'])
        ->name('batches');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/trainer/approval-kehadiran', [MaterialController::class, 'trainerApprovalKehadiran'])
        ->name('approval-kehadiran');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/trainer/penilaian-tugas', [MaterialController::class, 'trainerPenilaianTugas'])
        ->name('penilaian-tugas');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/trainer/upload-materi', [MaterialController::class, 'index'])
        ->name('upload-materi');

    Route::post('/trainer/upload-materi', [MaterialController::class, 'store'])
        ->name('upload-materi.store');

    Route::put('/trainer/upload-materi/{material}', [MaterialController::class, 'update'])
        ->name('upload-materi.update');

    Route::delete('/trainer/upload-materi/{material}', [MaterialController::class, 'destroy'])
        ->name('upload-materi.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/trainer/upload-tugas', [TaskController::class, 'index'])
        ->name('upload-tugas');

    Route::post('/trainer/upload-tugas', [TaskController::class, 'store'])
        ->name('upload-tugas.store');

    Route::put('/trainer/upload-tugas/{task}', [TaskController::class, 'update'])
        ->name('upload-tugas.update');

    Route::delete('/trainer/upload-tugas/{task}', [TaskController::class, 'destroy'])
        ->name('upload-tugas.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/trainer/settings', function () {
        return view('trainer.settings');
    })->name('settings-trainer');
});


// <!---------------- Branch PIC Routes ---------------->
Route::middleware(['auth'])->group(function () {
    Route::get('/branch_pic/dashboard', function () {
        return view('branch_pic.dashboard');
    })->name('branch_pic.dashboard');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/branch_pic/peserta-cabang', function () {
        return view('branch_pic.peserta-cabang');
    })->name('peserta-cabang');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/branch_pic/validasi-data', [BranchPicController::class, 'index'])
        ->name('validasi-data');

    Route::patch('/branch_pic/validasi-data/{batchParticipant}/approve', [BranchPicController::class, 'approve'])
        ->name('validasi-data.approve');

    Route::patch('/branch_pic/validasi-data/{batchParticipant}/reject', [BranchPicController::class, 'reject'])
        ->name('validasi-data.reject');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/branch_pic/laporan-cabang', function () {
        return view('branch_pic.laporan-cabang');
    })->name('laporan-cabang');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/branch_pic/settings', function () {
        return view('branch_pic.settings');
    })->name('settings-branch-pic');
});


// <!---------------- Participant Routes ---------------->
Route::middleware(['auth'])->group(function () {
    Route::get('/participant/dashboard', [BatchParticipantController::class, 'dashboard'])
        ->name('participant.dashboard');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/participant/pendaftaran', [BatchParticipantController::class, 'index'])
        ->name('pendaftaran');
    
    Route::post('/participant/pendaftaran/{batch}', [BatchParticipantController::class, 'store'])
        ->name('participant.daftar');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/participant/pelatihan', [BatchParticipantController::class, 'pelatihan'])
        ->name('pelatihan');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/participant/absensi', function () {
        return view('participant.absensi');
    })->name('absensi');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/participant/tugas', function () {
        return view('participant.tugas');
    })->name('tugas');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/participant/sertifikat', function () {
        return view('participant.sertifikat');
    })->name('sertifikat');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/participant/settings', function () {
        return view('participant.settings');
    })->name('profile-participant');
});


// <!---------------- Role Routes ---------------->
Route::resource('roles', RoleController::class)->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';