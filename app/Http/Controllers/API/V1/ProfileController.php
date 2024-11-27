<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Profile\UpdateProfileRequest;
use App\Services\UserService;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function update(UpdateProfileRequest $request)
    {
        $user = $this->userService->updateProfile($request->user(), $request->validated());
        return response()->json(['user' => $user], 200);
    }

    public function delete(Request $request)
    {
        $this->userService->deleteAccount($request->user());
        return response()->json(['message' => 'Account deleted successfully.'], 200);
    }
}
