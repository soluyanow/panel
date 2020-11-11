<?php

use Illuminate\Support\Facades\Route;

use App\Settings;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;

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

/*Route::get('/', function () {
    return view('welcome');
})->middleware('auth');

Route::get('/', function () {
    return view('index');
})->middleware('auth');

Route::get('/home', 'HomeController@index')->name('home');*/

Auth::routes();

Route::prefix('/')->group(function () {
    Route::get('/', 'TasksController@index')->name('tasks')->middleware('auth');
});

Route::prefix('tasks')->group(function () {
    Route::get('/', 'TasksController@index')->name('tasks')->middleware('auth');
    //Route::get('/filter/types/{1}', 'TasksController@filter')->name('filter')->middleware('auth');
    Route::get('/show/{id}', 'TasksController@show')->name('tasks.show')->middleware('auth');
    Route::get('/delete/{id}', 'TasksController@delete')->name('tasks.delete')->middleware('auth');
});

Route::prefix('settings')->group(function () {
    Route::get('/', 'SettingsController@index')->name('settings')->middleware('auth');
    Route::post('/update', 'SettingsController@update')->name('settings.update')->middleware('auth');
    Route::any('/success', 'SettingsController@success')->name('settings.success')->middleware('auth');
});

Route::prefix('clients')->group(function () {
    Route::get('/', 'ClientsController@index');
    Route::get('/show/{id}', 'ClientsController@show')->name('clients.show')->middleware('auth');
    Route::post('/update', 'ClientsController@update')->name('clients.update')->middleware('auth');
    Route::get('/new', 'ClientsController@new')->name('clients.new')->middleware('auth');
    Route::post('/create', 'ClientsController@create')->name('clients.create')->middleware('auth');
    Route::get('/delete/{id}', 'ClientsController@delete')->name('clients.delete')->middleware('auth');
});

Route::prefix('statuses')->group(function () {
    Route::get('/', 'StatusesController@index')->name('statuses')->middleware('auth');
    Route::get('/show/{id}', 'StatusesController@show')->name('statuses.show')->middleware('auth');
    Route::post('/update', 'StatusesController@update')->name('statuses.update')->middleware('auth');
    Route::get('/new', 'StatusesController@new')->name('statuses.new')->middleware('auth');
    Route::post('/create', 'StatusesController@create')->name('statuses.create')->middleware('auth');
    Route::get('/delete/{id}', 'StatusesController@delete')->name('statuses.delete')->middleware('auth');
});

Route::prefix('types')->group(function () {
    Route::get('/', 'TypesController@index')->name('types')->middleware('auth');
    Route::get('/show/{id}', 'TypesController@show')->name('type')->middleware('auth');
    Route::get('/new', 'TypesController@new')->name('types.new')->middleware('auth');
    Route::post('/create', 'TypesController@create')->name('types.create')->middleware('auth');
    Route::post('/update', 'TypesController@update')->name('update')->middleware('auth');
    Route::get('/delete/{id}', 'TypesController@delete')->name('types.delete')->middleware('auth');
});

Route::get('/error', function () {
    $obSettings = new Settings();
    $debugMode = $obSettings->where('name', '=', 'debug_mode')->first()->toArray();

    $arDebug = [];
    if ((boolean) $debugMode['value']) {
        foreach (debug_backtrace() as $d => $debug) {
            $arDebug[$d] = $debug;
            $arDebug[$d]['object'] =json_encode($debug['object']);
            $arDebug[$d]['args'] = json_encode($debug['args']);
        }
    }

    return view('error')->with('debug', $arDebug);
})->middleware('auth');
