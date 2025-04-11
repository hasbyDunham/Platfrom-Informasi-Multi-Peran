<?php

namespace App\Http\Controllers;

use App\Models\Information;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        // Mengecek apakah user sudah login dan memiliki role tertentu
        $user = Auth::user();
        $mainNews = Information::where('approval_status', 'approved')
                ->latest()
                ->first();
        // Jika tidak ada role yang sesuai, tetap tampilkan halaman utama
        return view('front.home', compact('user', 'mainNews'));

        // return view('home');
    }
}
