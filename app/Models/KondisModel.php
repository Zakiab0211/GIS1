<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class KondisModel extends Model
{
    public function allData(){
        $result = DB::table('tbl_kondisi')
        ->select('id', 'nama_lahan', 'suhu', 'kelembapan', 'rekomendasi')
        ->get();
        return $result;
    }
}
