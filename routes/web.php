<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminController;

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
    Route::get('/coordinator/dashboard', function () {
        return view('coordinator.dashboard');
    })->name('coordinator.dashboard');
});
Route::middleware(['auth'])->group(function () {
    Route::get('/coordinator/kategori-pelatihan', function () {
        return view('coordinator.kategori-pelatihan');
    })->name('kategori-pelatihan');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/coordinator/batch-management', function () {
        return view('coordinator.batch-management');
    })->name('batch-management');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/coordinator/validasi-peserta', function () {
        return view('coordinator.validasi-peserta');
    })->name('validasi-peserta');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/coordinator/monitoring-absensi', function () {
        return view('coordinator.monitoring-absensi');
    })->name('monitoring-absensi');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/coordinator/laporan', function () {
        return view('coordinator.laporan');
    })->name('laporan');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/coordinator/settings', function () {
        return view('coordinator.settings');
    })->name('settings-coordinator');
});


// <!---------------- Trainer Routes ----------------> 
Route::middleware(['auth'])->group(function () {
    Route::get('/trainer/dashboard', function () {
        return view('trainer.dashboard');
    })->name('trainer.dashboard');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/trainer/batches', function () {
        return view('trainer.batches');
    })->name('batches');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/trainer/approval-kehadiran', function () {
        return view('trainer.approval-kehadiran');
    })->name('approval-kehadiran');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/trainer/penilaian-tugas', function () {
        return view('trainer.penilaian-tugas');
    })->name('penilaian-tugas');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/trainer/upload-materi', function () {
        return view('trainer.upload-materi');
    })->name('upload-materi');
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
    Route::get('/branch_pic/validasi-data', function () {
        return view('branch_pic.validasi-data');
    })->name('validasi-data');
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
    Route::get('/participant/dashboard', function () {
        return view('participant.dashboard');
    })->name('participant.dashboard');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/participant/pendaftaran', function () {
        return view('participant.pendaftaran');
    })->name('pendaftaran');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/participant/pelatihan', function () {
        return view('participant.pelatihan');
    })->name('pelatihan');
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