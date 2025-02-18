<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Information;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InformationController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:information-list|information-create|information-edit|information-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:information-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:information-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:information-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user(); // Ambil user yang sedang login

        $data = Information::with('user', 'category')
            ->orderBy('created_at', 'desc')->paginate(5); // Urutkan dari yang terbaru

        // Jika user adalah writer, hanya tampilkan informasi yang ditulis oleh mereka
        if ($user->hasRole('Writer')) {
            $data->where('user_id', $user->id);
            return view('writer.information.index', compact('data')); // View untuk writer
        } elseif ($user->hasRole('Admin')) {
            // Jika admin, tampilkan semua data
            return view('admin.dataMaster.information.index', compact('data')); // View untuk admin
        }

        // $data = $data->paginate(5); // Eksekusi query

        abort(403, 'Unauthorized access.'); // Akses ditolak jika bukan admin atau writer

        // return view('adimin.dataMaster.information.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Categorie::all(); // Ambil semua kategori
        return view('admin.dataMaster.information.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'category_id' => 'required|exists:categories,id', // Pastikan kategori ada di database
            'status' => 'required|in:draft,published',   // Hanya boleh draft atau published
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi gambar
        ]);

        // Simpan data
        $information = new Information();
        $information->title = $request->title;
        $information->content = $request->content;
        $information->category_id = $request->category_id;
        $information->user_id = auth()->id(); // Ambil ID user yang sedang login
        $information->status = $request->status;

        // Simpan gambar jika ada
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName(); // Nama unik
            $file->storeAs('public/images/informations', $filename); // Simpan ke storage

            $information->image = 'storage/images/informations/' . $filename; // Simpan path
        }

        $information->save();

        // Beri notifikasi sukses
        toast('Information Added', 'success');

        // Redirect ke halaman informasi
        return redirect()->route('admin.information.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Information $information)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Information $information)
    {
        return view('dataMaster.information.update', compact('information'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Information $information)
    {
        // Validasi input
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|in:draft,published',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Update data
        $information->title = $request->title;
        $information->content = $request->content;
        $information->category_id = $request->category_id;
        $information->status = $request->status;

        // Update slug jika title berubah
        if ($request->title !== $information->title) {
            $information->slug = \Illuminate\Support\Str::slug($request->title);
        }

        // Update gambar jika ada file baru
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($information->image && file_exists(public_path($information->image))) {
                unlink(public_path($information->image));
            }

            // Simpan gambar baru
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/informations'), $filename);
            $information->image = 'images/informations/' . $filename;
        }

        $information->save();

        toast('Information Updated', 'success');
        return redirect()->route('information.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Information $information)
    {
        // Hapus gambar jika ada
        if ($information->image && file_exists(public_path($information->image))) {
            unlink(public_path($information->image));
        }

        // Hapus data dari database
        $information->delete();

        toast('Information Deleted', 'success');
        return redirect()->route('information.index');
    }
}
