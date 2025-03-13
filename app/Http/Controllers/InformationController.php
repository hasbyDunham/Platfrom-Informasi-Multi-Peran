<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Information;
use App\Notifications\InformationApproved;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InformationController extends Controller
{
    public function __construct()
    {
        // MIDDLEWARE CRUD PERMISSIOON
        $this->middleware('permission:information-list|information-create|information-edit|information-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:information-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:information-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:information-delete', ['only' => ['destroy']]);

        // MIDDLEWARE APPROV / REJECT
        $this->middleware('role:Admin', ['only' => ['approve', 'reject']]); // Pastikan Admin hanya bisa approve/reject
        $this->middleware('permission:information-approve', ['only' => ['approve']]); // Pastikan hanya yang punya permission ini yang bisa approve
        $this->middleware('permission:information-reject', ['only' => ['reject']]); // Pastikan hanya yang punya permission ini yang bisa reject
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user(); // Ambil user yang sedang login

        if ($user->hasRole('Writer')) {
            $data = Information::with('user', 'category')
                ->where('user_id', $user->id) // Writer hanya melihat datanya sendiri
                ->orderBy('created_at', 'desc')
                ->paginate(5);

            return view('writer.information.index', compact('data'));
        } elseif ($user->hasRole('Admin')) {
            $data = Information::with('user', 'category')
                ->orderBy('created_at', 'desc')
                ->paginate(5);

            return view('admin.dataMaster.information.index', compact('data'));
        }

        abort(403, 'Unauthorized access.'); // Akses ditolak jika bukan admin atau writer

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        $categories = Categorie::all(); // Ambil semua kategori

        if ($user->hasRole('Writer')) {
            return view('writer.information.create', compact('categories'));
        } elseif ($user->hasRole('Admin')) {
            return view('admin.dataMaster.information.create', compact('categories'));
        }

        abort(403, 'Unauthorized access.');
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi gambar
            // 'approval_status' => 'required|in:draft,published',   // Hanya boleh draft atau published
        ]);

        // Simpan data
        $information = new Information();
        $information->title = $request->title;
        $information->content = $request->content;
        $information->category_id = $request->category_id;
        $information->user_id = auth()->id(); // Ambil ID user yang sedang login
        $information->approval_status = 'pending';

        // Simpan gambar jika ada
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName(); // Nama unik
            $file->storeAs('public/images/informations', $filename); // Simpan ke storage

            $information->image = 'storage/images/informations/' . $filename; // Simpan path
        }

        $information->save();

        // Beri notifikasi sukses
        toast('Information submitted for approval', 'success');

        // Redirect ke halaman informasi
        if (auth()->user()->hasRole('Writer')) {
            return redirect()->route('writer.information.index');
        }

        return redirect()->route('admin.information.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Information $information)
    {
        $user = Auth::user();
        $categories = Categorie::all();

        if ($user->hasRole('Writer') && $user->id !== $information->user_id) {
            abort(403, 'Unauthorized access.');
        }

        // Jika role adalah writer, tampilkan tampilan writer
        if ($user->hasRole('Writer')) {
            return view('writer.information.show', compact('information', 'categories'));
        }

        // Jika role adalah admin, tampilkan tampilan admin
        if ($user->hasRole('Admin')) {
            return view('admin.dataMaster.information.show', compact('information', 'categories'));
        }

        // Jika role tidak dikenali, abort akses
        abort(403, 'Unauthorized access.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Information $information)
    {
        $user = Auth::user();
        $categories = Categorie::all();

        if ($user->hasRole('Writer') && $user->id !== $information->user_id) {
            abort(403, 'Unauthorized access.');
        }

        if ($user->hasRole('Writer')) {
            return view('writer.information.update', compact('information', 'categories'));
        } elseif ($user->hasRole('Admin')) {
            return view('admin.dataMaster.information.update', compact('information', 'categories'));
        }

        abort(403, 'Unauthorized access.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Information $information)
    {

        $user = Auth::user();

        if ($user->hasRole('Writer') && $user->id !== $information->user_id) {
            abort(403, 'Unauthorized access.');
        }

        // Validasi input
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'category_id' => 'required|exists:categories,id',
            'approval_status' => 'required|in:draft,published',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Update data
        $information->title = $request->title;
        $information->content = $request->content;
        $information->category_id = $request->category_id;
        $information->approval_status = $request->approval_status;

        // Update slug jika title berubah
        // if ($request->title !== $information->title) {
        //     $information->slug = \Illuminate\Support\Str::slug($request->title);
        // }

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
        if ($user->hasRole('Writer')) {
            return redirect()->route('writer.information.index');
        }

        return redirect()->route('admin.information.index');
    }


    public function approve(Information $information)
    {
        $information->update(['approval_status' => 'approved']);

        // Kirim notifikasi ke Writer
        $information->user->notify(new InformationApproved('approved'));

        return redirect()->back()->with('success', 'Information approved successfully.');
    }

    public function reject(Information $information)
    {
        $information->update(['approval_status' => 'rejected']);

        // Kirim notifikasi ke Writer
        $information->user->notify(new InformationApproved('rejected'));

        return redirect()->back()->with('error', 'Information rejected.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Information $information)
    {
        $user = Auth::user();

        if ($user->hasRole('Writer') && $user->id !== $information->user_id) {
            abort(403, 'Unauthorized access.');
        }

        // Hapus gambar jika ada
        if ($information->image && file_exists(public_path($information->image))) {
            unlink(public_path($information->image));
        }

        // Hapus data dari database
        $information->delete();

        toast('Information Deleted', 'success');
        if ($user->hasRole('Writer')) {
            return redirect()->route('writer.information.index');
        }

        return redirect()->route('admin.information.index');
    }
}
