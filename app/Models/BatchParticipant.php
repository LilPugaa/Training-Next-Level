<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BatchParticipant extends Model
{
    /** @use HasFactory<\Database\Factories\BatchParticipantFactory> */
    use HasFactory;

    protected $fillable = [
        'batch_id',
        'user_id',
        'approved_by',
        'status',
    ];

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function participants()
    {
        return $this->belongsToMany(User::class, 'batch_participants');
    }
}
