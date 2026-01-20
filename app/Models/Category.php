<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory;

    public function batches() {
        return $this->hasMany(Batch::class, 'category_id');
    }

    protected $fillable = ['name', 'description'];

    // Kategori yang menjadi prerequisite
    public function prerequisites() {
        return $this->belongsToMany(
            Category::class,
            'category_prerequisites',
            'category_id',
            'prerequisite_id'
        );
    }

    // Kategori yang membutuhkan kategori ini
    public function requiredFor() {
        return $this->belongsToMany(
            Category::class,
            'category_prerequisites',
            'prerequisite_id',
            'category_id'
        );
    }
}
