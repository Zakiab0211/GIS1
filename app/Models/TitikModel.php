<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TitikModel extends Model
{
    public function allData(){
        $result = DB::table('tbl_titik')
        ->select('id', 'nama', 'latitude', 'longtitude', 'Rekomendasi', 'keterangan')
        ->get();
        return $result;
    }

    public function getLokasi(){
        $result = DB::table('tbl_lokasi')
        ->select('id','nama', 'latitude', 'longtitude', 'alamat', 'gambar')
        // ->where('id',$id);
        ->get();
        return $result;
    }

    public function getKondisi(){
        $result = DB::table('tbl_kondisi')
        ->select('id', 'nama_lahan', 'suhu', 'kelembapan', 'rekomendasi' )
        ->get();
        return $result;
    }
}
