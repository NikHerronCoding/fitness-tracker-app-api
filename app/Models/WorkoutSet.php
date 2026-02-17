<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkoutSet extends Model
{
    protected $fillable = [
        'workout_entry_id',
        'position',
        'weight',
        'reps',
        'rir',
        'rpe',
        'notes',
    ];

    protected $casts = [
        'weight' => 'decimal:2',
        'rir' => 'decimal:1',
        'rpe' => 'decimal:1',
    ];

    public function entry(): BelongsTo
    {
        return $this->belongsTo(WorkoutEntry::class, 'workout_entry_id');
    }
}
