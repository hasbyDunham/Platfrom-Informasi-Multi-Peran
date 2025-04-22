<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Categorie extends Model
{
    protected $fillable = [
        'name',
        'slug'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_categories', 'user_id', 'category_id');
    }

    public function informations()
    {
        return $this->hasMany(Information::class, 'category_id');
    }


    // Menyimpan slug otomatis ketika membuat atau memperbarui berita
    public static function boot()
    {
        parent::boot();

        // Menggunakan event 'creating' untuk membuat slug otomatis sebelum berita disimpan
        static::creating(function ($categorie) {
            // Membuat slug dari judul jika slug tidak ada
            if (empty($categorie->slug)) {
                $categorie->slug = Str::slug($categorie->name);
            }

            // Menangani duplikasi slug
            $slug = $categorie->slug;
            $originalSlug = $slug;
            $count = 1;

            // Periksa apakah slug sudah ada, jika ya, tambahkan angka di belakang slug
            while (Categorie::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $count;
                $count++;
            }

            // Set slug yang unik
            $categorie->slug = $slug;
        });
    }

    use HasFactory;
}
