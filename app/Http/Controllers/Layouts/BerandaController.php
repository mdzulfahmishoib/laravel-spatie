<?php

namespace App\Http\Controllers\Layouts;

use App\Http\Controllers\Controller;
use App\Models\data_aset\data_aset;
use App\Models\data_master\aset;
use App\Models\gudang\barang;
use App\Models\gudang\barang_keluar;
use App\Models\gudang\barang_masuk;
use App\Models\informasi\kantor;
use App\Models\pengadaan\pengadaan;
use App\Models\penghapusan\penghapusan_aset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BerandaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('layouts.beranda');
    }


}
