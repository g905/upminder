<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\MentorController;
use App\Http\Controllers\MentorServiceController;
use App\Http\Controllers\MentorWeekController;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Auth::routes();

/* --------------------------- */
/* Панель администратора */
/* --------------------------- */

Route::prefix('control')->middleware('auth')->group(function () {
    Route::get('/', [App\Http\Controllers\DashboardController::class, 'index'])->name('admin');
    Route::get('delete/{table}/{id}', [App\Http\Controllers\DashboardController::class, 'delete'])->name('admin_delete_record');

    Route::prefix('company')->group(function () {
        Route::get('ajax', [App\Http\Controllers\CompanyController::class, 'ajax'])->name('admin_company_ajax');
        Route::post('ajax', [App\Http\Controllers\CompanyController::class, 'ajax'])->name('admin_company_ajax');
        Route::get('list', [App\Http\Controllers\CompanyController::class, 'index'])->name('admin_company_list');
        Route::get('form/{id?}', [App\Http\Controllers\CompanyController::class, 'form'])->name('admin_company_form');
        Route::post('form/{id?}', [App\Http\Controllers\CompanyController::class, 'form'])->name('admin_company_form');
        Route::get('categories/list', [App\Http\Controllers\CompanyCategoryController::class, 'index'])->name('admin_company_cat_list');
        Route::get('categories/form/{id}', [App\Http\Controllers\CompanyCategoryController::class, 'form'])->name('admin_company_cat_form');
        Route::post('categories/form/{id}', [App\Http\Controllers\CompanyCategoryController::class, 'form'])->name('admin_company_cat_form');
    });

    Route::prefix('mentor')->group(function () {
        Route::get('ajax', [App\Http\Controllers\MentorController::class, 'ajax'])->name('admin_mentor_ajax');
        Route::post('ajax', [App\Http\Controllers\MentorController::class, 'ajax'])->name('admin_mentor_ajax');
    
        Route::get('index', [App\Http\Controllers\MentorController::class, 'index'])->name('admin.mentor.index');
        
        Route::get('view/{id}', [App\Http\Controllers\MentorController::class, 'view'])->name('admin_mentor_view');
        Route::get('form/{id?}', [App\Http\Controllers\MentorController::class, 'form'])->name('admin_mentor_form');
        Route::post('form/{id?}', [App\Http\Controllers\MentorController::class, 'form'])->name('admin_mentor_form');
        Route::get('categories/list', [App\Http\Controllers\MentorCategoryController::class, 'index'])->name('admin_mentor_cat_list');
        Route::get('categories/form/{id}', [App\Http\Controllers\MentorCategoryController::class, 'form'])->name('admin_mentor_cat_form');
        Route::post('categories/form/{id}', [App\Http\Controllers\MentorCategoryController::class, 'form'])->name('admin_mentor_cat_form');
        
        Route::post('/delete/many',[MentorController::class, 'deleteMany'])->name('admin.mentor.delete.many');
        Route::post('/ajax/get/category/tags', [MentorController::class, 'ajaxGetCategoryTags'])->name('ajax.get.category.tags');
    });
    /* Занятия */
    Route::prefix('lessons')->group(function (){
        Route::get('/', [LessonController::class, 'index'])->name('admin.lessons.index');
        Route::get('/add', [LessonController::class, 'create'])->name('admin.lessons.add');
        Route::get('/edit/{lesson}', [LessonController::class, 'edit'])->name('admin.lessons.edit');
        Route::get('/delete/{lesson}', [LessonController::class, 'destroy'])->name('admin.lessons.delete');
        Route::post('/store', [LessonController::class, 'store'])->name('admin.lessons.store');
        Route::put('/update/{lesson}', [LessonController::class, 'update'])->name('admin.lessons.update');
    });
    /* Занятия */
    
    /* Скачать файл резюме */
    Route::prefix('download')->group(function (){
        Route::get('/resume/{path}', [ApplicationController::class, 'downloadResume'])->name('admin.download.resume');
    });
    /* Скачать файл резюме */
    
    /* Заявки */
    Route::prefix('applications')->group(function (){
        Route::get('/', [ApplicationController::class, 'index'])->name('admin.applications.index');
        Route::get('/add', [ApplicationController::class, 'create'])->name('admin.applications.add');
        Route::get('/edit/{application}', [ApplicationController::class, 'edit'])->name('admin.applications.edit');
        Route::get('/delete/{application}', [ApplicationController::class, 'destroy'])->name('admin.applications.delete');
        Route::post('/store', [ApplicationController::class, 'store'])->name('admin.applications.store');
        Route::put('/update/{application}', [ApplicationController::class, 'update'])->name('admin.applications.update');
    });
    /* Заявки */
    
    Route::prefix('page')->group(function () {
        Route::get('list', [App\Http\Controllers\PageController::class, 'index'])->name('admin_page_list');
        Route::get('form/{id}', [App\Http\Controllers\PageController::class, 'form'])->name('admin_page_form');
        Route::post('form/{id}', [App\Http\Controllers\PageController::class, 'form'])->name('admin_page_form');
    });

    Route::prefix('reviews')->group(function () {
        Route::get('list', [App\Http\Controllers\ReviewController::class, 'index'])->name('admin_rev_list');
        Route::get('form/{id}', [App\Http\Controllers\ReviewController::class, 'form'])->name('admin_rev_form');
        Route::post('form/{id}', [App\Http\Controllers\ReviewController::class, 'form'])->name('admin_rev_form');

    });

    Route::prefix('country')->group(function () {
        Route::get('list', [App\Http\Controllers\CountryController::class, 'index'])->name('admin_country_list');
        Route::get('form/{id}', [App\Http\Controllers\CountryController::class, 'form'])->name('admin_country_form');
        Route::post('form/{id}', [App\Http\Controllers\CountryController::class, 'form'])->name('admin_country_form');

    });

    Route::prefix('city')->group(function () {
        Route::get('list', [App\Http\Controllers\CityController::class, 'index'])->name('admin_city_list');
        Route::get('form/{id}', [App\Http\Controllers\CityController::class, 'form'])->name('admin_city_form');
        Route::post('form/{id}', [App\Http\Controllers\CityController::class, 'form'])->name('admin_city_form');

    });

    Route::prefix('language')->group(function () {
        Route::get('list', [App\Http\Controllers\LanguageController::class, 'index'])->name('admin_language_list');
        Route::get('form/{id}', [App\Http\Controllers\LanguageController::class, 'form'])->name('admin_language_form');
        Route::post('form/{id}', [App\Http\Controllers\LanguageController::class, 'form'])->name('admin_language_form');

    });
    
    Route::prefix('mentor_week')->group(function (){
        Route::get('/', [MentorWeekController::class, 'index'])->name('admin.mentor_week.index');
        Route::get('/add', [MentorWeekController::class, 'create'])->name('admin.mentor_week.add');
        Route::get('/edit/{mentor_week}', [MentorWeekController::class, 'edit'])->name('admin.mentor_week.edit');
        Route::get('/delete/{mentor_week}', [MentorWeekController::class, 'destroy'])->name('admin.mentor_week.delete');
        Route::post('/create', [MentorWeekController::class, 'store'])->name('admin.mentor_week.store');
        Route::put('/update/{mentor_week}', [MentorWeekController::class, 'update'])->name('admin.mentor_week.update');
    });
    Route::prefix('mentor_services')->group(function (){
        Route::get('/', [MentorServiceController::class, 'index'])->name('admin.mentor_services.index');
        Route::get('/add', [MentorServiceController::class, 'create'])->name('admin.mentor_services.add');
        Route::get('/edit/{mentor_service}', [MentorServiceController::class, 'edit'])->name('admin.mentor_services.edit');
        Route::get('/delete/{mentor_service}', [MentorServiceController::class, 'destroy'])->name('admin.mentor_services.delete');
        Route::post('/create', [MentorServiceController::class, 'store'])->name('admin.mentor_services.store');
        Route::put('/update/{mentor_service}', [MentorServiceController::class, 'update'])->name('admin.mentor_services.update');
    });
    
    Route::prefix('task_type')->group(function () {
        Route::get('list', [App\Http\Controllers\CategoryTagsController::class, 'index'])->name('admin_task_type_list');
        Route::get('form/{id}', [App\Http\Controllers\CategoryTagsController::class, 'form'])->name('admin_task_type_form');
        Route::post('form/{id}', [App\Http\Controllers\CategoryTagsController::class, 'form'])->name('admin_task_type_form');
    });

    Route::prefix('settings')->group(function () {
        Route::get('/', [App\Http\Controllers\SettingsController::class, 'index'])->name('admin.settings.index');
        Route::post('/update/{id}', [App\Http\Controllers\SettingsController::class, 'update'])->name('admin.settings.update');
        Route::get('/destroy/{id}', [App\Http\Controllers\SettingsController::class, 'destroy'])->name('admin.settings.destroy');

    });
});

Route::get('/get-avatar/{name}', [MentorController::class, 'getAvatar'])->name('get.avatar');
Route::get('/mentors', [App\Http\Controllers\FrontMentorController::class, 'list'])->name('front.mentors');
Route::post('/mentors', [App\Http\Controllers\FrontMentorController::class, 'list'])->name('front.mentors');