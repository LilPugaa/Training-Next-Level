<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use App\Models\Batch;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'role_id',
        'branch_id',
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function materi() {
        return $this->hasMany(Material::class, 'trainer_id');
    }

    public function task() {
        return $this->hasMany(Task::class, 'trainer_id');
    }

    public function batchParticipants() {
        return $this->hasMany(BatchParticipant::class);
    }

    public function batches()
    {
        return $this->belongsToMany(
            Batch::class,
            'batch_participants',
            'user_id',
            'batch_id'
        )
        ->withPivot(['status', 'approved_by'])
        ->withTimestamps();
    }

    public function getInitialsAttribute()
    {
        if (!$this->name) {
            return '?';
        }
        return collect(explode(' ', trim($this->name)))
            ->filter()
            ->map(fn ($word) => strtoupper(substr($word, 0, 1)))
            ->take(2)
            ->join('');
    }

    // public function getDisplayCodeAttribute() {

    //     // Mapping role ke kode
    //     $roleCodes = [
    //         'admin' => 'ADM',
    //         'coordinator' => 'TCR',
    //         'trainer' => 'TRN',
    //         'branch_pic' => 'PIC',
    //         'participant' => 'PRT',
    //     ];

    //     // Ambil role user
    //     $roleName = $this->role->name;

    //     $roleCode = $roleCodes[$roleName] ?? 'USR';

    //     $userWithSameRole = User::where('role_id', $this->role_id)
    //         ->orderBy('created_at')
    //         ->pluck('id')
    //         ->toArray();

    //     // Cari posisi user
    //     $userPosition = array_search($this->id, $userWithSameRole);

    //     // Urutan dimulai dari 1
    //     $userNumber = $userPosition + 1;

    //     $batchPosition = Batch::orderBy('created_at')
    //         ->pluck('id')
    //         ->search($this->batch_id);

    //     $batchNumber = str_pad($batchPosition + 1, 3, '0', STR_PAD_LEFT);

    //     return "{$roleCode}-{$userNumber}-{$batchNumber}";
    // }
}