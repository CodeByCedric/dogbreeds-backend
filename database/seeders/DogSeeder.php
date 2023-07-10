<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $labradorDescription = "The Labrador Retriever is a friendly and outgoing breed...";
        $germanShepherdDescription = "The German Shepherd is a highly intelligent and versatile breed...";
        $goldenRetrieverDescription = "The Golden Retriever is a lovable and family-friendly breed...";
        $bulldogDescription = "The Bulldog is a calm and courageous breed...";
        $poodleDescription = "The Poodle is a highly intelligent and elegant breed...";
        $beagleDescription = "The Beagle is a small and merry breed known for its excellent scenting abilities...";
        $boxerDescription = "The Boxer is a medium-sized breed with a playful and energetic personality...";
        $frenchBulldogDescription = "The French Bulldog is a small and affectionate breed with a charming personality...";
        $yorkshireTerrierDescription = "The Yorkshire Terrier is a small and glamorous breed with a confident demeanor...";
        $rottweilerDescription = "The Rottweiler is a strong and loyal breed known for its protective nature...";

        DB::table('dogs')->insert([
            [
                'name' => "Labrador Retriever",
                'description' => $labradorDescription,
                'exercise_needs' => 8,
                'grooming_requirements' => 3,
                'trainability' => 9,
                'protectiveness' => 4,
            ],
            [
                'name' => "German Shepherd",
                'description' => $germanShepherdDescription,
                'exercise_needs' => 9,
                'grooming_requirements' => 5,
                'trainability' => 10,
                'protectiveness' => 10,
            ],
            [
                'name' => "Golden Retriever",
                'description' => $goldenRetrieverDescription,
                'exercise_needs' => 8,
                'grooming_requirements' => 6,
                'trainability' => 9,
                'protectiveness' => 3,
            ],
            [
                'name' => "Bulldog",
                'description' => $bulldogDescription,
                'exercise_needs' => 4,
                'grooming_requirements' => 3,
                'trainability' => 6,
                'protectiveness' => 5,
            ],
            [
                'name' => "Poodle",
                'description' => $poodleDescription,
                'exercise_needs' => 7,
                'grooming_requirements' => 9,
                'trainability' => 10,
                'protectiveness' => 2,
            ],
            [
                'name' => "Beagle",
                'description' => $beagleDescription,
                'exercise_needs' => 7,
                'grooming_requirements' => 5,
                'trainability' => 7,
                'protectiveness' => 2,
            ],
            [
                'name' => "Boxer",
                'description' => $boxerDescription,
                'exercise_needs' => 9,
                'grooming_requirements' => 4,
                'trainability' => 7,
                'protectiveness' => 8,
            ],
            [
                'name' => "French Bulldog",
                'description' => $frenchBulldogDescription,
                'exercise_needs' => 5,
                'grooming_requirements' => 2,
                'trainability' => 6,
                'protectiveness' => 2,
            ],
            [
                'name' => "Yorkshire Terrier",
                'description' => $yorkshireTerrierDescription,
                'exercise_needs' => 6,
                'grooming_requirements' => 9,
                'trainability' => 7,
                'protectiveness' => 2,
            ],
            [
                'name' => "Rottweiler",
                'description' => $rottweilerDescription,
                'exercise_needs' => 8,
                'grooming_requirements' => 4,
                'trainability' => 8,
                'protectiveness' => 9,
            ],
        ]);
    }
}

