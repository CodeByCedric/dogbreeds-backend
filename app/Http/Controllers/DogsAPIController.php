<?php

namespace App\Http\Controllers;


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

    public function updateAllLanguages(Request $request): void
    {
        $data = $request->all();

        $this->dogService->update($data);


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
