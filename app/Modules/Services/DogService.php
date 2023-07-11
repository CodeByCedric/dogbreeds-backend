<?php

namespace App\Modules\Services;

use App\Models\Dog;
use Illuminate\Database\Eloquent\Collection;

class DogService
{
    public function getAll(): Collection
    {
        return Dog::all();
    }

    public function getById($id)
    {
        return Dog::find($id);
    }

    public function create($data)
    {
        return Dog::create($data);
    }

    public function update(Dog $dog, $data): Dog
    {
        $dog->update($data);
        return $dog;
    }

    public function delete(Dog $dog): ?bool
    {
        return $dog->delete();
    }

    public function findByBreed($breed)
    {
        return Dog::where('breed', $breed)->get();
    }
}

