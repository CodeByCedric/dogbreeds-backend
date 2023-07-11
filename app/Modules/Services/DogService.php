<?php

namespace App\Modules\Services;

use App\Models\Dog;
use App\Models\DogsLanguage;
use Illuminate\Database\Eloquent\Collection;

class DogService
{
    public function getAll($language): Collection
    {
        $dogs = Dog::all();

        $dogs->each(function ($dog) use ($language) {
            $translation = $dog->translations()
                ->where('language', $language)
                ->first();

            if ($translation) {
                $dog->name = $translation->name;
                $dog->description = $translation->description;
            }
        });

        return $dogs;
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

    public function create($data, $language)
    {
        $dog = Dog::create([
            'exercise_needs' => $data['exercise_needs'],
            'grooming_requirements' => $data['grooming_requirements'],
            'trainability' => $data['trainability'],
            'protectiveness' => $data['protectiveness'],
        ]);

        $dogLanguage = new DogsLanguage([
            'language' => $language,
            'name' => $data['name'],
            'description' => $data['description'],
        ]);

        $dog->translations()->save($dogLanguage);

        return $dog;
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

