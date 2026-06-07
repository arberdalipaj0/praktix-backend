<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreApplicationRequest;
use App\Models\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ApplicationController extends Controller
{
    /**
     * GET /api/applications
     * List all applications (admin only).
     */
    public function index(Request $request): JsonResponse
    {
        $query = Application::with('program.expert');

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('program_id')) {
            $query->where('program_id', $request->program_id);
        }

        $applications = $query->latest()->paginate(15);

        return response()->json($applications);
    }

    /**
     * GET /api/applications/{id}
     * Get a single application (admin only).
     */
    public function show(Application $application): JsonResponse
    {
        $application->load('program.expert');

        return response()->json($application);
    }

    /**
     * POST /api/applications
     * Student submits an application (public).
     */
    public function store(StoreApplicationRequest $request): JsonResponse
    {
        $application = Application::create($request->validated());

        return response()->json([
            'message'     => 'Application submitted successfully. We will contact you soon.',
            'application' => $application,
        ], 201);
    }

    /**
     * PATCH /api/applications/{id}/status
     * Update application status (admin only).
     */
    public function updateStatus(Request $request, Application $application): JsonResponse
    {
        $request->validate([
            'status' => ['required', Rule::in(['new', 'under_review', 'accepted', 'rejected'])],
            'notes'  => ['nullable', 'string'],
        ]);

        $application->update([
            'status' => $request->status,
            'notes'  => $request->notes ?? $application->notes,
        ]);

        return response()->json([
            'message'     => 'Application status updated.',
            'application' => $application,
        ]);
    }

    /**
     * DELETE /api/applications/{id}
     * Delete an application (admin only).
     */
    public function destroy(Application $application): JsonResponse
    {
        $application->delete();

        return response()->json(['message' => 'Application deleted successfully.']);
    }
}
