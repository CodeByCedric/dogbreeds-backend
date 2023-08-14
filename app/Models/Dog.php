<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Dog extends Model
{
    use HasFactory;

    protected $fillable = [
        'exercise_needs',
        'grooming_requirements',
        'trainability',
        'protectiveness',
    ];

    public function translations(): HasMany
    {
        return $this->hasMany(DogsLanguage::class, "dog_id");
    }
}
