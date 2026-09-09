<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\RepaymentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\auth\AccountController;
use App\Http\Controllers\TeacherController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get("/categories", function () {
    return "this my first route.";
});

Route::get("/categories/create", function () {
    return "this route use to create a new resource.";
})->name("categories.create");

Route::get("/categories/{id}", function ($id) {
    return "you get id {$id}";
});

Route::get("/categories/search/by/{name?}", function ($name = "MON MINH") {
    return "you search for name {$name}";
})->name("categories.search");

Route::prefix('accounts')->controller(AccountController::class)->group(function () {
    Route::get('/login', 'login')->name('login');
    Route::post('/login', 'authenticate')->name('authenticate');

    Route::get('/register', 'register')->name('register');
    Route::post('/register', 'create')->name('create');

    Route::match(['get', 'post'], '/logout', 'logout')->name('logout');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('welcome');
    })->name('dashboard');

    Route::middleware(['role:admin'])->group(function () {
        Route::resource('employees', EmployeeController::class);
        Route::resource('customers', CustomerController::class);
        Route::resource('posts', PostController::class);
    });


    Route::get('/loans', [LoanController::class, 'index'])->name('loans.index');


    Route::get('/loans/apply', [LoanController::class, 'create'])->name('loans.apply');
    Route::post('/loans/apply', [LoanController::class, 'store'])->name('loans.store');
    Route::get('/loans/my', [LoanController::class, 'myLoans'])->name('loans.my');
    Route::post('/loans/{loan}/cancel', [LoanController::class, 'cancel'])->name('loans.cancel'); // បន្ថែម Route Cancel ត្រង់នេះ
    Route::get('/loans/{loan}/schedule', [LoanController::class, 'schedule'])->name('loans.schedule');
    Route::get('/loans/{loan}/show', [LoanController::class, 'show'])->name('loans.show');


    Route::middleware(['role:admin,loan_officer'])->group(function () {
        Route::get('/loans/pending', [LoanController::class, 'pendingLoans'])->name('loans.pending');
        Route::post('/loans/{loan}/approve', [LoanController::class, 'approve'])->name('loans.approve');
        Route::post('/loans/{loan}/disburse', [LoanController::class, 'disburse'])->name('loans.disburse');
    });


    Route::middleware(['role:admin,cashier'])->group(function () {
        Route::get('/loans/{loan}/repay', [RepaymentController::class, 'create'])->name('loans.repay');
        Route::post('/loans/{loan}/repay', [RepaymentController::class, 'store'])->name('loans.repay.store');
    });

    Route::middleware(['role:admin'])->group(function () {
        Route::get('/dashboard/overdue', [DashboardController::class, 'overdue'])->name('dashboard.overdue');
    });
});


Route::get('/teacher/create', [TeacherController::class, 'createData']);
Route::get('/teacher/update', [TeacherController::class, 'updateData']);
Route::get('/teacher/query', [TeacherController::class, 'queryData']);
Route::get('/teacher/delete', [TeacherController::class, 'deleteData']);