<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Exercise extends Model
{
    protected $fillable = ['name','category','equipment','created_by_user_id'];

    public function variants(): HasMany
    {
        return $this->hasMany(ExerciseVariant::class);
    }
}
