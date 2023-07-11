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

    public function getDogInfoById($id)
    {
        $dog = Dog::find($id);

        if ($dog) {
            $language = app()->getLocale();

            $translation = $dog->translations()
                ->where('language', $language)
                ->first();

            if ($translation) {
                $dog->name = $translation->name;
                $dog->description = $translation->description;
            }

            return $dog;
        }

        return null;
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

