<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProgramRequest;
use App\Models\Program;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    /**
     * GET /api/programs
     * List all programs with their expert.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Program::with('expert');

        if ($request->has('category')) {
            $query->where('category', $request->category);
        }

        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $programs = $query->latest()->paginate(10);

        return response()->json($programs);
    }

    /**
     * GET /api/programs/{id}
     * Get a single program with expert and application count.
     */
    public function show(Program $program): JsonResponse
    {
        $program->load('expert');
        $program->loadCount('applications');

        return response()->json($program);
    }

    /**
     * POST /api/programs
     * Create a new program (admin only).
     */
    public function store(StoreProgramRequest $request): JsonResponse
    {
        $program = Program::create($request->validated());
        $program->load('expert');

        return response()->json([
            'message' => 'Program created successfully.',
            'program' => $program,
        ], 201);
    }

    /**
     * PUT /api/programs/{id}
     * Update a program (admin only).
     */
    public function update(StoreProgramRequest $request, Program $program): JsonResponse
    {
        $program->update($request->validated());
        $program->load('expert');

        return response()->json([
            'message' => 'Program updated successfully.',
            'program' => $program,
        ]);
    }

    /**
     * DELETE /api/programs/{id}
     * Delete a program (admin only).
     */
    public function destroy(Program $program): JsonResponse
    {
        $program->delete();

        return response()->json(['message' => 'Program deleted successfully.']);
    }
}