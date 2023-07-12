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

    public function create($data, $languages)
    {
        $validator = Validator::make($data, [
            'exercise_needs' => 'required|integer|digits_between:1,10',
            'grooming_requirements' => 'required|integer|digits_between:1,10',
            'trainability' => 'required|integer|digits_between:1,10',
            'protectiveness' => 'required|integer|digits_between:1,10',
            'name' => 'required|array',
            'name.*' => 'required|string|max:255',
            'description' => 'required|array',
            'description.*' => 'required|string',
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

        foreach ($languages as $index => $language) {
            $dogLanguage = new DogsLanguage([
                'language' => $language,
                'name' => $data['name'][$index],
                'description' => $data['description'][$index],
            ]);

            $dog->translations()->save($dogLanguage);
        }

        return $dog;
    }

//    public function create($data, $language)
//    {
//        $validator = Validator::make($data, [
//            'exercise_needs' => 'required|integer|digits_between:1,10',
//            'grooming_requirements' => 'required|integer|digits_between:1,10',
//            'trainability' => 'required|integer|digits_between:1,10',
//            'protectiveness' => 'required|integer|digits_between:1,10',
//            'name' => 'required|string|max:255',
//            'description' => 'required|string',
//        ]);
//
//        if ($validator->fails()) {
//            throw new \InvalidArgumentException($validator->errors()->first());
//        }
//
//        $dog = Dog::create([
//            'exercise_needs' => $data['exercise_needs'],
//            'grooming_requirements' => $data['grooming_requirements'],
//            'trainability' => $data['trainability'],
//            'protectiveness' => $data['protectiveness'],
//        ]);
//
//        $dogLanguage = new DogsLanguage([
//            'language' => $language,
//            'name' => $data['name'],
//            'description' => $data['description'],
//        ]);
//
//        $dog->translations()->save($dogLanguage);
//
//        return $dog;
//    }

    public function update(Dog $dog, $data, $language): Dog
    {
        $validator = Validator::make($data, [
            'exercise_needs' => 'nullable|integer|digits_between:1,10',
            'grooming_requirements' => 'nullable|integer|digits_between:1,10',
            'trainability' => 'nullable|integer|digits_between:1,10',
            'protectiveness' => 'nullable|integer|digits_between:1,10',
            'name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            throw new \InvalidArgumentException($validator->errors()->first());
        }

        $dog->update([
            'exercise_needs' => $data['exercise_needs'],
            'grooming_requirements' => $data['grooming_requirements'],
            'trainability' => $data['trainability'],
            'protectiveness' => $data['protectiveness'],
        ]);

        $translation = $dog->translations()
            ->where('language', $language)
            ->first();

        $translation?->update([
            'name' => $data['name'],
            'description' => $data['description'],
        ]);

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

