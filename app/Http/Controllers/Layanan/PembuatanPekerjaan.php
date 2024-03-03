<?php

namespace App\Http\Controllers\Layanan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PembuatanPekerjaan extends Controller
{
    public function index()
    {
        return view('portal.layanan.pembuatan-pekerjaan');
    }
}
