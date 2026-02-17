<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WorkoutEntry extends Model
{
    protected $fillable = [
        'workout_session_id',
        'exercise_variant_id',
        'position',
        'notes',
    ];

    public function session(): BelongsTo
    {
        return $this->belongsTo(WorkoutSession::class, 'workout_session_id');
    }

    public function exerciseVariant(): BelongsTo
    {
        return $this->belongsTo(ExerciseVariant::class);
    }

    public function sets(): HasMany
    {
        return $this->hasMany(WorkoutSet::class)->orderByRaw('COALESCE(position, id)');
    }
}
