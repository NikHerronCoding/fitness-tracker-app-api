<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ExerciseVariant extends Model
{
    protected $fillable = ['exercise_id','name','default_cues','is_default'];

    protected $casts = ['is_default' => 'boolean'];

    public function exercise(): BelongsTo
    {
        return $this->belongsTo(Exercise::class);
    }

    public function muscleGroups(): BelongsToMany
    {
        return $this->belongsToMany(MuscleGroup::class, 'exercise_variant_muscle_group')
            ->withPivot(['proportion','role'])
            ->withTimestamps();
    }

    public function workoutEntries()
    {
        return $this->hasMany(\App\Models\WorkoutEntry::class);
    }

}
