<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Registers a new user.
     *
     * @param RegisterRequest $request The request containing the user's name, email, and password.
     * @return \Illuminate\Http\JsonResponse The response containing a success message, access token, and token type.
     */
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Đăng ký thành công.',
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    /**
     * Authenticates a user and generates an access token.
     *
     * @param LoginRequest $request The request containing the user's email and password.
     * @return \Illuminate\Http\JsonResponse The response containing the access token and token type.
     *     If the credentials are invalid, it returns a JSON response with a 401 status code and an error message.
     */
    public function login(LoginRequest $request)
    {
        if (!Auth::attempt($request)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $user = $request->user();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['access_token' => $token, 'token_type' => 'Bearer']);
    }

    /**
     * Logs out the authenticated user by revoking their access token.
     *
     * @param Request $request The incoming request containing the authenticated user.
     * @return \Illuminate\Http\JsonResponse A JSON response indicating successful logout.
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }
}
