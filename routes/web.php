<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\UserImportController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FormDataController;
use App\Http\Controllers\GoalReviewController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\ReviewTypeController;
use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\CeleryController;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function () {
    return redirect(app()->getLocale());
});

Route::get('/registration', function () {
    return redirect(app()->getLocale().'/registration');
});

Route::get("/celery/callback", [CeleryController::class, 'callback']);

Route::get("/celery/webhook", [CeleryController::class, 'webhook']);

Route::group(['prefix' => '{locale}', 'middleware' => 'setlocale'], function() {
    #Route::get('/add_gfa_secret', [UserController::class, 'add_gfa_secret']);
    
    Route::get('/login', [UserController::class, 'login'])->name('login');
    Route::post('/authenticate', [UserController::class, 'authenticate'])->name('users.authenticate');
    Route::post('/forgot_password', [UserController::class, 'forgot_password'])->name('users.forgot_password');
    Route::get('/reset_password/{token}', [UserController::class, 'reset_password']);
    Route::post('/reset_password', [UserController::class, 'reset_password'])->name('users.reset_password');
    
    Route::get('/registration', [CompanyController::class, 'create']);
    Route::get('/cregistered', [CompanyController::class, 'company_registered']);
    Route::resource('companies', CompanyController::class)->only(['create', 'store']);
    
    Route::get('/gfa_register', [PageController::class, 'gfa_register'])->middleware('check_login');
    Route::get('/verify', [PageController::class, 'verify']);
    Route::post('/verify', [PageController::class, 'verify'])->name('verify');
    Route::post('/gfa_authenticate', [PageController::class, 'gfa_authenticate'])->name('gfa_authenticate');
    // ->middleware('2fa');
    Route::get('/gfa_generate_link', [PageController::class, 'gfa_generate_link']);
    Route::get('/gfa_setup/{token}/{user}', [PageController::class, 'gfa_setup']);
    
    #Route::group(['middleware' => ['auth']], function () {
    Route::group(['middleware' => ['auth', 'check_gfa_authenticated']], function () {


        Route::group(['prefix' => 'celery'], function () {
            Route::get('/callback', [CeleryController::class, 'index']);
            Route::get('/contexts', [CeleryController::class, 'contexts']);
            Route::get('/employers', [CeleryController::class, 'employers']);
            Route::get('/employees', [CeleryController::class, 'employees']);
            Route::post('/save_employees', [CeleryController::class, 'save_employees']);
        });
        

        Route::match(['get', 'post'], '/', [UserController::class, 'dashboard']);
        Route::get('/logout', [UserController::class, 'logout']);
        Route::match(['get', 'post'], '/profile', [UserController::class, 'profile']);
        Route::match(['get', 'post'], '/users/{user}/supdate', [UserController::class, 'supdate'])->name('users.supdate');
        Route::post('/users/update_mng', [UserController::class, 'update_mng'])->name('users.update_mng');
        Route::get('/users/{user}/{type}/pdf', [UserController::class, 'pdf'])->name('users.pdf');
        Route::get('/users/employees', [UserController::class, 'employees'])->name('users.employees');
        Route::match(['get', 'post'], '/support', [UserController::class, 'support'])->name('users.support');
        
        Route::match(['get', 'post'], '/users/import', [UserImportController::class, 'index'])->name('user_imports.import');
        
        Route::match(['get', 'post'], '/companies/{company}/{status}/supdate', [CompanyController::class, 'supdate'])->name('companies.supdate');
        
        Route::get('/logs/{module_id}/{module}/view', [LogController::class, 'view'])->name('logs.view');
        
        Route::get('/competencies/{user_id}', [GoalReviewController::class, 'show']);
        
        Route::get('/competencies/{company}/pdf', [CategoryController::class, 'pdf'])->name('categories.pdf');
        
        Route::match(['get', 'post'], '/archives/{archive}/{status}/supdate', [ArchiveController::class, 'supdate'])->name('archives.supdate');
        
        //Route::get('/form_data/view/{form_datum}', [FormDataController::class, 'show'])->name('form_data.view');
        #Route::get('/form_data/{form_datum}/{type}', [FormDataController::class, 'show'])->name('form_data.view');
        Route::get('/form_data/{form_datum}/{random}', [FormDataController::class, 'show'])->name('form_data.view');
        Route::match(['get', 'post'], '/form_data/get_data', [FormDataController::class, 'get_data'])->name('form_data.get_data');
        
        Route::get('/tdownload/', function () {
            $storage_path = config('filesystems.storage_path');
            $template_dir = config('filesystems.dirs.template');
            $file_name = 'personeel_template.xlsx';
            $file_path = asset($storage_path.$template_dir.'/'.$file_name);
            return \Response::make(file_get_contents($file_path), 200, [
                'Content-Disposition' => 'attachment; filename="'.$file_name.'"'
            ]);
        });
        
        Route::get('/support_pdf/', function () {
            $role_code = Auth::user()->user_role->role_code;
            $storage_path = config('filesystems.storage_path');
            $pdf_dir = config('filesystems.dirs.support');
            $file_name = $role_code.'-pb.pdf';
            $file_path = asset($storage_path.$pdf_dir.'/'.$file_name);
            return \Response::make(file_get_contents($file_path), 200, [
                'Content-Disposition' => 'attachment; filename="'.$file_name.'"'
            ]);
        });
        
        Route::resources([
            'users' => UserController::class,
            'user_imports' => UserImportController::class,
            'files' => FileController::class,
            'settings' => SettingController::class,
            'categories' => CategoryController::class,
            'form_data' => FormDataController::class,
            'goal_reviews' => GoalReviewController::class,
            'logs' => LogController::class,
            'review_types' => ReviewTypeController::class,
            'archives' => ArchiveController::class,
            'pages' => PageController::class,
        ]);
        Route::resource('companies', CompanyController::class)->except(['create', 'store']);
    });
});