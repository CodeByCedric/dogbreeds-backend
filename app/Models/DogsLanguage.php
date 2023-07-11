<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DogsLanguage extends Model
{
    use HasFactory;

    protected $primaryKey = ['dog_id', 'language'];
    protected $keyType = 'string';

    //add the line $keyType = 'string'; to ensure the primary key is treated as a string since it's a composite key.
    public $incrementing = false;

    protected $fillable = ['dog_id', 'language', 'name', 'description'];

    public function dog()
    {
        return $this->belongsTo(Dog::class, 'dog_id');
    }
}
