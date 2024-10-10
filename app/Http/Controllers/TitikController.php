<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TitikModel;

class TitikController extends Controller
{
    // Konstruktor dengan dua underscore
    public function __construct()  // Perbaiki di sini
    {
        $this->TitikModel = new TitikModel();  // Properti untuk TitikModel
    }

    public function index()
    {
        return view('home');
    }

    public function titik()
    {
        $results = $this->TitikModel->allData();  // Mengakses model
        return json_encode($results);
    }

    public function lokasi()
    {
        $results = $this->TitikModel->getLokasi();  // Mengakses model
        return json_encode($results);
    }
}

