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

    public function index(): JsonResponse
    {
        $dogs = $this->dogService->getAll();
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
        $this->validate($request, [
            'breed' => 'required|string|unique:dogs|max:255',
            'size' => 'required|string|max:255',
            'shedding' => 'required|integer|max:255',
            'energy' => 'required|integer|max:255',
            'protectiveness' => 'required|integer|max:255',
            'trainability' => 'required|integer|max:255',
        ]);

        $dog = $this->dogService->create($request->all());

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
