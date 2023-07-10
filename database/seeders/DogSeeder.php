<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Get the absolute path to the dogs.json file
        $jsonPath = base_path('database/seeders/dogs.json');

        // Read the contents of the dogs.json file
        $json = file_get_contents($jsonPath);
        $dogsData = json_decode($json, true);

        foreach ($dogsData['dogs'] as $dogData) {
            $dogId = DB::table('dogs')->insertGetId([
                'exercise_needs' => $dogData['exercise_needs'],
                'grooming_requirements' => $dogData['grooming_requirements'],
                'trainability' => $dogData['trainability'],
                'protectiveness' => $dogData['protectiveness'],
            ]);

            $translations = [
                ['language' => 'en', 'name' => $dogData['name_en'], 'description' => $dogData['description_en']],
                ['language' => 'nl', 'name' => $dogData['name_nl'], 'description' => $dogData['description_nl']],
            ];

            foreach ($translations as $translation) {
                DB::table('dogs_languages')->insert([
                    'dog_id' => $dogId,
                    'language' => $translation['language'],
                    'name' => $translation['name'],
                    'description' => $translation['description'],
                ]);
            }
        }

    }
}

