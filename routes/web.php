<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TitikController;
use App\Http\Controllers\KondisController;
// use App\Http\Controllers\MapController;//navigasi bar
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

Route::get('/', function () {
    return view('home');
});
/*tambahkan class agar dapat akses xampp */
Route::resource('webGI11S', WebGIS11Controller::class);
/*comment bila perlu*/
// Route::resource('webGIS', WebGISController::class)->only(['index', 'show']);
Route::get('/titik/json',[TitikController::class,'titik']);
Route::get('/titik/lokasi',[TitikController::class,'lokasi']);
Route::get('/titik/kondisi',[TitikController::class,'kondisi']);
Route::get('/kondisi/json',[KondisController::class,'kondisi']);
Route::get('/kondisi/lokasi',[KondisController::class,'lokasi']);//caranya cari di KondisController:seuaikan dengan public funtion
//navigasi bar
// Route::get('/', [MapController::class, 'index']);
// Route::get('/markers/{type?}', [MapController::class, 'getMarkers']);
// Route::post('/markers', [MapController::class, 'store']);
// Route::put('/markers/{id}', [MapController::class, 'update']);
// Route::delete('/markers/{id}', [MapController::class, 'destroy']);
