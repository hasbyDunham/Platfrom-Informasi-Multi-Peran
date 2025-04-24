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
        $user       = Auth::user();
        $categories = Categorie::with(['informations' => function ($query) {
            $query->latest()->take(5); // ambil 5 berita terbaru per kategori
        }])->get();
        $mainNews = Information::where('approval_status', 'approved')
            ->latest()
            ->first();
        $otherNews = Information::where('id', '!=', optional($mainNews)->id)
            ->where('approval_status', 'approved')
            ->latest()
            ->take(6)
            ->get();
        // Jika tidak ada role yang sesuai, tetap tampilkan halaman utama
        return view('front.home', compact('user', 'mainNews', 'otherNews', 'categories'));

        // return view('home');
    }

    public function singelInformation($slug)
    {
        $information = Information::with(['category', 'user', 'user.categories'])
            ->where('slug', $slug)
            ->where('approval_status', 'approved')
            ->firstOrFail();

        $otherNews = Information::where('id', '!=', optional($information)->id)
            ->where('approval_status', 'approved')
            ->latest()
            ->take(5)
            ->get();

        return view('front.singelInformation', compact('information', 'otherNews'));
    }

    public function storeComment(Request $request, $slug)
    {
        $request->validate([
            'body' => 'required|string|max:1000',
        ]);

        $information = Information::where('slug', $slug)->firstOrFail();

        $information->comments()->create([
            'user_id' => auth()->id(),
            'body'    => $request->body,
        ]);

        return back()->with('success', 'Komentar berhasil dikirim.');
    }

    public function byCategory($slug)
    {
        $category = Categorie::where('slug', $slug)->firstOrFail();

        $informations = $category->informations()->latest()->paginate(6);

        return view('front.byCategorie', compact('category', 'informations'));
    }


    public function myInformation(){
        $user = Auth::User();
        $category = Categorie::All();
        $information = Information::with('user', 'category')
            ->Where('user_id', $user->id)
            ->orderBy('createdAt', 'desc')
            ->paginate(5);

        return view('front.myInformation', compact('user', 'category', 'information'));
    }

}
