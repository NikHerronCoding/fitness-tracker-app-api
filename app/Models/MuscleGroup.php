<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class MuscleGroup extends Model
{
    protected $fillable = ['slug','name','region_slug'];

    public function variants(): BelongsToMany
    {
        return $this->belongsToMany(ExerciseVariant::class, 'exercise_variant_muscle_group')
            ->withPivot(['proportion','role'])
            ->withTimestamps();
    }
}
