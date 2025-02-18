<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB;
// Use Alert;


class CategorieController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:categorie-list|categorie-create|categorie-edit|categorie-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:categorie-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:categorie-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:categorie-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Categorie::latest()->paginate(5);

        confirmDelete("Delete", "Are you sure you want to delete?");
        return view('admin.dataMaster.categories.index', compact('data'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.dataMaster.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        request()->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        categorie::create($request->all());

        toast('Categories Added','success');
        return redirect()->route('categories.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Categorie $categorie)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $categorie = Categorie::findOrFail($id);
        return view('admin.dataMaster.categories.update', compact('categorie'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        request()->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        $categorie = Categorie::findOrFail($id);
        $categorie->update($request->all());

        toast('Categories Updated','success');
        return redirect()->route('categories.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Categorie::find($id)->delete();
        toast('Delete Data Successfully','success');
        return redirect()->route('categories.index');
    }
}
