<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
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
        $mainNews = Information::latest()->first();
        $otherNews = Information::where('id', '!=', optional($mainNews)->id)
            ->latest()
            ->take(6) // atau sebanyak yang kamu mau
            ->get();
        // Jika tidak ada role yang sesuai, tetap tampilkan halaman utama
        return view('front.home', compact('user', 'mainNews', 'otherNews'));

        // return view('home');
    }

    public function singelInformation($slug)
    {
        $information = Information::with(['category', 'user', 'user.categories'])
            ->where('slug', $slug)
            ->where('approval_status', 'approved')
            ->firstOrFail();

        return view('front.singelInformation', compact('information'));
    }

    public function storeComment(Request $request, $slug)
    {
        $request->validate([
            'body' => 'required|string|max:1000',
        ]);

        $information = Information::where('slug', $slug)->firstOrFail();

        $information->comments()->create([
            'user_id' => auth()->id(),
            'body' => $request->body,
        ]);

        return back()->with('success', 'Komentar berhasil dikirim.');
    }

    public function byCategory($slug)
    {
        $category = Categorie::where('slug', $slug)->firstOrFail();

        $informations = $category->informations()->latest()->paginate(6);

        return view('front.byCategorie', compact('category', 'informations'));
    }

}
