<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KondisModel;

class KondisController extends Controller{
    public function __construct()  // Perbaiki di sini
    {
        $this->KondisModel = new KondisModel();  // Properti untuk TitikModel
    }

    public function index()
    {
        return view('home');
    }

    public function kondisi()
    {
        $results = $this->KondisModel->getKondisi();  // Mengakses model
        return json_encode($results);
    }

    public function lokasi()
    {
        $results = $this->KondisModel->getLokasi();  // Mengakses model ,$id='' , $id
        return json_encode($results);
    }


}