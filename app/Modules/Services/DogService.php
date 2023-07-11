<?php

namespace App\Modules\Services;

use App\Models\Dog;
use App\Models\DogsLanguage;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Validator;

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
        $validator = Validator::make($data, [
            'exercise_needs' => 'required',
            'grooming_requirements' => 'required',
            'trainability' => 'required',
            'protectiveness' => 'required',
            'name' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            throw new \InvalidArgumentException($validator->errors()->first());
        }

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
        $validator = Validator::make($data, [
            'breed' => 'string|unique:dogs|max:255',
            'size' => 'string|max:255',
            'shedding' => 'integer|max:255',
            'energy' => 'integer|max:255',
            'protectiveness' => 'integer|max:255',
            'trainability' => 'integer|max:255',
        ]);

        if ($validator->fails()) {
            throw new \InvalidArgumentException($validator->errors()->first());
        }

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

