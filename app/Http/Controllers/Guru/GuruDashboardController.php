<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuruDashboardController extends Controller
{
    public function index()
    {
        $guru = Auth::user(); // asumsi user login sebagai guru

        return view('guru.dashboard.index', compact('guru'));
    }
}
