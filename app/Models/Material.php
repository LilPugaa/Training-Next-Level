<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    /** @use HasFactory<\Database\Factories\MaterialFactory> */
    use HasFactory;

    protected $fillable = [
        'batch_id',
        'trainer_id',
        'judul_materi',
        'tipe_materi',
        'link_materi',
    ];

    public function batch() {
        return $this->belongsTo(Batch::class, 'batch_id');
    }

    public function trainer() {
        return $this->belongsTo(User::class, 'trainer_id');
    }
}
