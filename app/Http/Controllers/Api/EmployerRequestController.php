<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmployerRequestRequest;
use App\Models\EmployerRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EmployerRequestController extends Controller
{
    /**
     * GET /api/employer-requests
     * List all employer requests (admin only).
     */
    public function index(Request $request): JsonResponse
    {
        $query = EmployerRequest::query();

        if ($request->has('request_type')) {
            $query->where('request_type', $request->request_type);
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $requests = $query->latest()->paginate(15);

        return response()->json($requests);
    }

    /**
     * GET /api/employer-requests/{id}
     * Get a single employer request (admin only).
     */
    public function show(EmployerRequest $employerRequest): JsonResponse
    {
        return response()->json($employerRequest);
    }

    /**
     * POST /api/employer-requests
     * Company submits a request (public).
     */
    public function store(StoreEmployerRequestRequest $request): JsonResponse
    {
        $employerRequest = EmployerRequest::create($request->validated());

        return response()->json([
            'message' => 'Request submitted successfully. Our team will reach out within 24 hours.',
            'request' => $employerRequest,
        ], 201);
    }

    /**
     * PATCH /api/employer-requests/{id}/status
     * Update request status (admin only).
     */
    public function updateStatus(Request $request, EmployerRequest $employerRequest): JsonResponse
    {
        $request->validate([
            'status' => ['required', Rule::in(['pending', 'in_progress', 'resolved'])],
        ]);

        $employerRequest->update(['status' => $request->status]);

        return response()->json([
            'message' => 'Status updated.',
            'request' => $employerRequest,
        ]);
    }

    /**
     * DELETE /api/employer-requests/{id}
     * Delete a request (admin only).
     */
    public function destroy(EmployerRequest $employerRequest): JsonResponse
    {
        $employerRequest->delete();

        return response()->json(['message' => 'Request deleted successfully.']);
    }
}