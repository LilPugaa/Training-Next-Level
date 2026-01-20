<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Batch extends Model
{
    /** @use HasFactory<\Database\Factories\BatchFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'category_id',
        'trainer_id',
        'start_date',
        'end_date',
        'zoom_link',
        'min_quota',
        'max_quota',
        'status',
    ];

    public function category() {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function trainer() {
        return $this->belongsTo(User::class, 'trainer_id');
    }

    public function participants() {
        return $this->belongsToMany(
            User::class, 
            'batch_participants', 
            'batch_id', 
            'user_id'
        )
        ->withPivot(['status', 'approved_by'])
        ->withTimestamps();
    }

    public function materials() {
        return $this->hasMany(Material::class, 'batch_id');
    }

    public function tasks() {
        return $this->hasMany(Task::class, 'batch_id');
    }

    public function refreshStatus() {

        $now = now();

        if ($now->lt($this->start_date)) {
            $newStatus = 'Scheduled';
        } elseif ($now->between($this->start_date, $this->end_date)) {
            $newStatus = 'Ongoing';
        } else {
            $newStatus = 'Completed';
        }

        if ($this->status !== $newStatus) {
            $this->update(['status' => $newStatus]);
        }
    }

    public function getDisplayCodeAttribute() {

        // Ambil role trainer
        $trainer = $this->trainer;

        // Mapping role ke kode
        $roleCodes = [
            'trainer' => 'TRN',
        ];

        $roleName = $trainer->role->name ?? null;
        $roleCode = $roleCodes[$roleName] ?? 'USR';

        // Tahun batch dibuat
        $year = $this->created_at->format('Y');

        // Urutan batch dalam tahun yang sama
        $batchPosition = Batch::whereYear('created_at', $year)
            ->orderBy('created_at')
            ->pluck('id')
            ->search($this->id);

        $batchNumber = str_pad($batchPosition + 1, 3, '0', STR_PAD_LEFT);

        return "{$roleCode}-{$year}-{$batchNumber}";
    }
}
