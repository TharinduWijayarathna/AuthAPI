<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Profile\UpdateProfileRequest;
use App\Services\UserService;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="Profile",
 *     description="API Endpoints for User Profile Management"
 * )
 */
class ProfileController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Get user profile.
     *
     * @OA\Get(
     *     path="/api/v1/profile",
     *     tags={"Profile"},
     *     summary="Get user profile",
     *     security={{"sanctum":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="User profile retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="user", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="John Doe"),
     *                 @OA\Property(property="email", type="string", example="john.doe@example.com"),
     *                @OA\Property(property="created_at", type="string", format="date-time", example="2024-01-01T00:00:00Z"),
     *                @OA\Property(property="updated_at", type="string", format="date-time", example="2024-01-01T00:00:00Z")
     *            )
     *       )
     *   )
     * )
     */
    public function get(Request $request)
    {
        $user = $this->userService->getProfile($request->user());
        return response()->json(['user' => $user], 200);
    }

    /**
     * Update user profile.
     *
     * @OA\Put(
     *     path="/api/v1/profile",
     *     tags={"Profile"},
     *     summary="Update user profile",
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "email"},
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", example="john.doe@example.com")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Profile updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="user", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="John Doe"),
     *                 @OA\Property(property="email", type="string", example="john.doe@example.com"),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2024-01-01T00:00:00Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2024-01-01T00:00:00Z")
     *             )
     *         )
     *     )
     * )
     *
     */

    public function update(UpdateProfileRequest $request)
    {
        $user = $this->userService->updateProfile($request->user(), $request->validated());
        return response()->json(['user' => $user], 200);
    }

    /**
     * Delete user account.
     *
     * @OA\Delete(
     *     path="/api/v1/profile",
     *     tags={"Profile"},
     *     summary="Delete user account",
     *     security={{"sanctum":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Account deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Account deleted successfully.")
     *         )
     *     )
     * )
     *
     */

    public function delete(Request $request)
    {
        $this->userService->deleteAccount($request->user());
        return response()->json(['message' => 'Account deleted successfully.'], 200);
    }
}
