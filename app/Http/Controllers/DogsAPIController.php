<?php

namespace App\Http\Controllers;


use App\Modules\Services\DogService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


//Todo: move validation to service
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

    public function store(Request $request)
    {
        $this->validate($request, [
            'exercise_needs' => 'required',
            'grooming_requirements' => 'required',
            'trainability' => 'required',
            'protectiveness' => 'required',
            'name' => 'required',
            'description' => 'required',
        ]);

        $data = $request->only([
            'exercise_needs',
            'grooming_requirements',
            'trainability',
            'protectiveness',
            'name',
            'description',
        ]);

        $language = $request->input('lang', 'en');

        $dog = $this->dogService->create($data, $language);

        return response()->json($dog, 201);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $dog = $this->dogService->getDogInfoById($id);

        if (!$dog) {
            return response()->json(['message' => 'Dog not found'], 404);
        }

        $this->validate($request, [
            'breed' => 'string|unique:dogs|max:255',
            'size' => 'string|max:255',
            'shedding' => 'integer|max:255',
            'energy' => 'integer|max:255',
            'protectiveness' => 'integer|max:255',
            'trainability' => 'integer|max:255',
        ]);

        $dog = $this->dogService->update($dog, $request->all());

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
