<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AcessMiddleware;
use App\Http\Controllers\NurseController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\WorkLeaveController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\Admin\UserRoleController;
use App\Http\Middleware\CheckPermissionMiddleware;

// 🏥 Public Authentication Routes (Login, Register, Logout)
Route::get('/', function () {
    return view('welcome');
});
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
// Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 🏥 Admin Panel Routes (Only accessible after login)
Route::middleware('auth')->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
    Route::controller(UserController::class)->group(function () {
        Route::get('/users', 'index')->name('users.index');
        Route::post('/users', 'store')->name('users.store')->middleware(CheckPermissionMiddleware::class . ':add_User');
        Route::put('/users/{id}', 'update')->name('users.update')->middleware(CheckPermissionMiddleware::class . ':edit_User');
        Route::delete('/users/{id}', 'destroy')->name('users.destroy');
    });

    Route::controller(WorkLeaveController::class)->group(function () {
        Route::get('/work-leaves', 'index')->name('work-leaves.index');
        Route::get('/work-leaves/create', 'create')->name('work-leaves.create');
        Route::post('/work-leaves', 'store')->name('work-leaves.store');
        Route::get('/work-leaves/{workLeave}', 'show')->name('work-leaves.show');
        Route::get('/work-leaves/{workLeave}/edit', 'edit')->name('work-leaves.edit');
        Route::put('/work-leaves/{workLeave}', 'update')->name('work-leaves.update');
        Route::patch('/work-leaves/{workLeave}', 'update')->name('work-leaves.update');
        Route::delete('/work-leaves/{workLeave}', 'destroy')->name('work-leaves.destroy');
    });

    Route::controller(PatientController::class)->group(function () {
        Route::get('/patients', 'index')->name('patients.index');
        Route::get('/patients/create', 'create')->name('patients.create');
        Route::post('/patients', 'store')->name('patients.store');
        Route::get('/patients/{patient}', 'show')->name('patients.show');
        Route::get('/patients/{patient}/edit', 'edit')->name('patients.edit');
        Route::put('/patients/{patient}', 'update')->name('patients.update');
        Route::patch('/patients/{patient}', 'update')->name('patients.update');
        Route::delete('/patients/{patient}', 'destroy')->name('patients.destroy');
    });
   
    Route::controller(DepartmentController::class)->group(function(){
        Route::get('/departments','index')->name('departments.index');
        Route::post('/departments','store')->name('departments.store');
        Route::get('/departments/{department}','show')->name('departments.show');
        Route::get('/departments/{department}/edit','edit')->name('departments.edit');
        Route::put('/departments/{department}','update')->name('departments.update');
        Route::patch('/departments/{department}','update')->name('departments.update');
        Route::delete('/departments/{department}','destroy')->name('departments.destroy');
    
    });

   Route::controller(DoctorController::class)->group(function(){
    Route::get('/doctors','index')->name('doctors.index');      // Show All Doctors
    Route::get('/doctors/{id}', 'show')->name('doctors.show');  // Show Single Doctor
   });

   Route::controller(NurseController::class)->group(function(){
    Route::get('/nurses','index')->name('nurses.index');      // Show All Nurse
    Route::get('/nurses/{id}', 'show')->name('nurses.show');  // Show Single Doctor
   });

    
   Route::controller(EmployeeController::class)->group(function(){
    Route::get('/employees','index')->name('employees.index');
    Route::post('/employees','store')->name('employees.store');
    Route::put('/employees/{employee}','update')->name('employees.update');
    Route::delete('/employees/{employee}','destroy')->name('employees.destroy');
   });
   
    Route::controller(UserRoleController::class)->group(function () {
        Route::get('/role', 'index')->name('users.role');
        Route::post('/role', 'store')->name('role.store');
        Route::put('/role/{id}', 'update')->name('role.update');
        Route::delete('/role/{id}', 'destroy')->name('role.destroy');
        Route::get('/assign-permissions', 'assignpermissionsView')->name('role.view.assign-permissions');
        Route::post('/assign-permissions', 'assignPermissions')->name('role.assignPermissions');
        Route::get('/get-permissions/{model}', 'getPermissionsByModel');
    });

    Route::controller(BillController::class)->group(function(){
       Route::get('/bill','index')->name('bill.index');
       Route::post('/bill/store','store')->name('bills.store');
    });

    Route::controller(PermissionController::class)->group(function(){
        Route::get('/permissions/create', 'create')->name('permissions.create')->middleware(AcessMiddleware::class);
        Route::post('/permissions/store', 'store')->name('permissions.store');
    });
   


});

