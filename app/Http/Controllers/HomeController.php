<?php

namespace App\Http\Controllers;

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
        $this->middleware('auth');
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

        if ($user) {
            if ($user->hasRole('Admin')) {
                return redirect('/admin'); // Jika role Admin
            } elseif ($user->hasRole('Writer')) {
                return redirect('/writer'); // Jika role Writer
            }
        }

        // Jika tidak ada role yang sesuai, tetap tampilkan halaman utama
        return view('home');

        // return view('home');
    }
}
