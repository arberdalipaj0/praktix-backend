<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreExpertRequest;
use App\Models\Expert;
use Illuminate\Http\JsonResponse;

class ExpertController extends Controller
{
    /**
     * GET /api/experts
     * List all experts.
     */
    public function index(): JsonResponse
    {
        $experts = Expert::withCount('programs')->latest()->get();

        return response()->json($experts);
    }

    /**
     * GET /api/experts/{id}
     * Get a single expert with their programs.
     */
    public function show(Expert $expert): JsonResponse
    {
        $expert->load('programs');

        return response()->json($expert);
    }

    /**
     * POST /api/experts
     * Create a new expert (admin only).
     */
    public function store(StoreExpertRequest $request): JsonResponse
    {
        $expert = Expert::create($request->validated());

        return response()->json([
            'message' => 'Expert created successfully.',
            'expert'  => $expert,
        ], 201);
    }

    /**
     * PUT /api/experts/{id}
     * Update an expert (admin only).
     */
    public function update(StoreExpertRequest $request, Expert $expert): JsonResponse
    {
        $expert->update($request->validated());

        return response()->json([
            'message' => 'Expert updated successfully.',
            'expert'  => $expert,
        ]);
    }

    /**
     * DELETE /api/experts/{id}
     * Delete an expert (admin only).
     */
    public function destroy(Expert $expert): JsonResponse
    {
        $expert->delete();

        return response()->json(['message' => 'Expert deleted successfully.']);
    }
}
