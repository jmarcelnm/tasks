<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class RegisterController extends Controller
{
    /**
     * Handle the incoming request.
     * 
     * @param RegisterRequest $request
     */
    public function __invoke(RegisterRequest $request): JsonResponse
    {
        $user = User::create($request->getData());

        return response()->json([
            'user' => $user,
            'token' => $user->createToken('auth_token')->plainTextToken
        ]);
    }
}
