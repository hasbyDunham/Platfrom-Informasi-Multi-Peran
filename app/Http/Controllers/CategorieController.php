<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Http\Request;

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
        $data = categorie::latest()->paginate(5);

        return view('categories.index', compact('data'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categories.create');
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

        return redirect()->route('categorie.index')
            ->with('success', 'categorie created successfully.');
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
    public function edit(Categorie $categorie)
    {
        return view('categories.update', compact('categorie'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Categorie $categorie)
    {
        request()->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        $categorie->update($request->all());

        return redirect()->route('categorie.index')
            ->with('success', 'categorie updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Categorie $categorie)
    {
        $categorie->delete();

        return redirect()->route('categorie.index')
            ->with('success', 'categorie deleted successfully');
    }
}
