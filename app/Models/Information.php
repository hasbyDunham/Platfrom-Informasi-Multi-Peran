<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Information extends Model
{

    // Menyimpan slug otomatis ketika membuat atau memperbarui berita
    public static function boot()
    {
        parent::boot();

        // Menggunakan event 'creating' untuk membuat slug otomatis sebelum berita disimpan
        static::creating(function ($information) {
            // Membuat slug dari judul jika slug tidak ada
            if (empty($information->slug)) {
                $information->slug = Str::slug($information->title);
            }

            // Menangani duplikasi slug
            $slug = $information->slug;
            $originalSlug = $slug;
            $count = 1;

            // Periksa apakah slug sudah ada, jika ya, tambahkan angka di belakang slug
            while (Information::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $count;
                $count++;
            }

            // Set slug yang unik
            $information->slug = $slug;
        });
    }

    use HasFactory;

}
