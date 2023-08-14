<?php

namespace App\Http\Controllers;


use App\Models\Dog;
use App\Models\DogsLanguage;
use App\Modules\Services\DogService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use InvalidArgumentException;


class DogsAPIController extends Controller
{
    protected DogService $dogService;

    public function __construct(DogService $dogService)
    {
        $this->dogService = $dogService;
    }

    public function index(Request $request): JsonResponse
    {
        $language = $request->input('lang', 'en');
        $dogs = $this->dogService->getAll($language);
        return response()->json($dogs);
    }

    public function show($id): JsonResponse
    {
        $dog = $this->dogService->getDogInfoById($id);

        if (!$dog) {
            return response()->json(['message' => 'Dog not found'], 404);
        }

        return response()->json($dog);
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $data = $request->only([
                'exercise_needs',
                'grooming_requirements',
                'trainability',
                'protectiveness',
                'name',
                'description',
            ]);

            $languages = $request->input('languages', ['en']);

            $dog = $this->dogService->create($data, $languages);

            return response()->json($dog, 201);
        } catch (InvalidArgumentException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function updateAllLanguages(Request $request)
    {
        $data = $request->all();

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
            $dogsLanguage = DogsLanguage::where('dog_id', $data['id'])
                ->where('language', $language)
                ->update([
                    'name' => $names[$index],
                    'description' => $descriptions[$index]
                ]);
        }

    }

    public function update(Request $request, $id): JsonResponse
    {
        $dog = $this->dogService->getDogInfoById($id);

        if (!$dog) {
            return response()->json(['message' => 'Dog not found'], 404);
        }

        $language = $request->input('lang', 'en');

        $dog = $this->dogService->update($dog, $request->all(), $language);

        if (!$dog) {
            return response()->json(['message' => 'Update failed'], 500);
        }

        return response()->json($dog);
    }

    public function destroy($id): JsonResponse
    {
        $dog = $this->dogService->getDogInfoById($id);

        if (!$dog) {
            return response()->json(['message' => 'Dog not found'], 404);
        }

        $this->dogService->delete($dog);

        return response()->json(['message' => 'Dog deleted']);
    }
}
