<?php

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

use App\Http\Controllers\RoleController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes([
    'register' => false,
    'verify' => false,
    ]);


Route::middleware(['auth'])->group(function (){
    Route::get('/home', 'HomeController@index')->name('home');

    Route::name('task.')->group(function () {
        Route::get('/tasks/add', [TaskController::class, 'pageAdd'])->name('add');
        Route::get('/tasks/edit/{id}', [TaskController::class, 'pageEdit'])->name('edit');
        Route::post('/tasks/addTask', [TaskController::class, 'storeTask'])->name('addPost');
        Route::post('/tasks/editTask', [TaskController::class, 'storeTask'])->name('editPost');
        Route::get('/tasks/list/{parameters?}', [TaskController::class, 'index'])->name('list');
        Route::delete('/tasks/delete', [TaskController::class, 'delete'])->name('delete');
    });

    Route::name('user.')->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('list');
        Route::get('/users/add', [UserController::class, 'pageAdd'])->name('add');
        Route::get('/users/edit/{id}', [UserController::class, 'pageEdit'])->name('edit');
        Route::post('/users/addPost', [UserController::class, 'addUser'])->name('addPost');
        Route::post('/users/editPost', [UserController::class, 'editUser'])->name('editPost');
        Route::delete('/users/delete', [UserController::class, 'delete'])->name('delete');
    });

    Route::name('role.')->group(function () {
        Route::get('/roles', [RoleController::class, 'index'])->name('list');
        Route::get('/roles/add', [RoleController::class, 'pageAdd'])->name('add');
        Route::get('/roles/edit/{id}', [RoleController::class, 'pageEdit'])->name('edit');
        Route::post('/roles/addPost', [RoleController::class, 'add'])->name('addPost');
        Route::post('/roles/editPost', [RoleController::class, 'edit'])->name('editPost');
        Route::delete('/roles/delete', [RoleController::class, 'delete'])->name('delete');
    });
});











