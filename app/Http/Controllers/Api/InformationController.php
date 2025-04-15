<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Information;
use Illuminate\Http\Request;
use Str;
use Hash;
use Illuminate\Support\Facades\Validator;

class InformationController extends Controller
{
    public function index()
    {
        $informations = Information::with(['category', 'user'])->latest()->get();
        return response()->json([
            'success' => true,
            'message' => 'Daftar Informasi',
            'data' => $informations,
        ], 200);
    }

    public function show($slug)
    {
        $information = Information::with('category')->where('slug', $slug)->firstOrFail();
        return response()->json([
            'success' => true,
            'message' => 'Detail Informasi',
            'data' => $information,
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $information = Information::create([
                'title' => $request->title,
                'content' => $request->content,
                'category_id' => $request->category_id,
                'user_id' => auth()->id(),
                'image' => $request->image,
                'slug' => Str::slug($request->title),
                'approval_status' => 'pending',
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Informasi berhasil dibuat',
                'data' => $information,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan',
                'errors' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($slug)
    {
        $information = Information::where('slug', $slug)->firstOrFail();
        $information->delete();
        return response()->json([
            'success' => true,
            'message' => 'Informasi berhasil dihapus',
        ], 200);
    }
}
