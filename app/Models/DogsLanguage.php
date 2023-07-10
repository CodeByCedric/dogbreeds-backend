<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DogsLanguage extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $primaryKey = ['dog_id', 'language'];
    protected $fillable = ['name', 'description'];

    public function dog()
    {
        return $this->belongsTo(Dog::class);
    }
}
