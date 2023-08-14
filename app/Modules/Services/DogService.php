<?php

namespace App\Modules\Services;

use App\Models\Dog;
use App\Models\DogsLanguage;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class DogService
{

    protected array $rulesetAllLanguages = [
        'exercise_needs' => 'required|integer|digits_between:1,10',
        'grooming_requirements' => 'required|integer|digits_between:1,10',
        'trainability' => 'required|integer|digits_between:1,10',
        'protectiveness' => 'required|integer|digits_between:1,10',
        'name' => 'required|array',
        'name.*' => 'required|string|max:255',
        'description' => 'required|array',
        'description.*' => 'required|string',
    ];
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
        $validator = Validator::make($data, $this->rulesetAllLanguages);

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
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

    public function updateDogAndTranslations($data): void
    {
        $validator = Validator::make($data, $this->rulesetAllLanguages);

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        $dogData = [
            'id' => $data['id'],
            'exercise_needs' => $data['exercise_needs'],
            'grooming_requirements' => $data ['grooming_requirements'],
            'trainability' => $data['trainability'],
            'protectiveness' => $data['protectiveness'],
        ];

        $dog = Dog::findOrFail($data['id']);
        $dog->update($dogData);

        $languages = $data['languages'];
        $descriptions = $data['description'];
        $names = $data['name'];

        foreach ($languages as $index => $language) {
            DogsLanguage::where('dog_id', $data['id'])
                ->where('language', $language)
                ->update([
                    'name' => $names[$index],
                    'description' => $descriptions[$index]
                ]);
        }


    }

    public function delete(Dog $dog): ?bool
    {
        return $dog->delete();
    }

}

