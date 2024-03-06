<?php

namespace App\Http\Controllers\Layanan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PermintaanTenagaKerja extends Controller
{
    public function index()
    {
        return view('portal.layanan.permintaan-tenaga-kerja');
    }
}
