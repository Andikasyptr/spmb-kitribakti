<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiswaDashboardController extends Controller
{
    public function index()
    {
        $siswa = Auth::user(); // asumsi user login sebagai siswa

        return view('siswa.dashboard.index', compact('siswa'));
    }
}
