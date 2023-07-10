<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dog extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'description',
        'exercise_needs',
        'grooming_requirements',
        'trainability',
        'protectiveness',
        'timestamps',
    ];
}
