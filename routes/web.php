<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TitikController;
use App\Http\Controllers\KondisController;

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
Route::get('/kondisi/json',[KondisController::class,'kondisi']);
