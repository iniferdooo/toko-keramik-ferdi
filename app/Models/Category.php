<?php

namespace App\Models;

use Illuminate\Support\Str; 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
    ];

    // Otomatis buat slug dari name
protected static function boot()
{
    parent::boot();
    static::creating(function ($category) {
        $category->slug = Str::slug($category->name); 
    });
}

    // Relasi: 1 kategori punya banyak produk
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}