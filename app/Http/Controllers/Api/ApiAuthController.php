<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use OpenApi\Attributes as OA;

#[OA\Tag(name: "Auth", description: "Operations related to user authentication")]

class ApiAuthController extends Controller
{
    #[OA\Post(
        path: "/register",
        tags: ["Auth"],
        summary: "Register a new user",
        description: "Register a new user and return an access token.",
        requestBody: new OA\RequestBody(
            description: "User registration data",
            required: true,
            content: new OA\MediaType(
                mediaType: "application/json",
                schema: new OA\Schema(
                    // required: ["name", "email", "password"],
                    properties: [
                        new OA\Property(property: "name", type: "string", description: "The user's name"),
                        new OA\Property(property: "email", type: "string", description: "The user's email address"),
                        new OA\Property(property: "password", type: "string", description: "The user's password"),
                    ]
                )
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: "User registered successfully",
                content: new OA\MediaType(
                    mediaType: "application/json",
                    schema: new OA\Schema(
                        required: ["token"],
                        properties: [
                            new OA\Property(property: "token", type: "string", description: "Access token for the registered user"),
                        ]
                    )
                )
            ),
            new OA\Response(
                response: 422,
                description: "Validation error"
            )
        ]
    )]
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['token' => $user->createToken('Personal Access Token')->plainTextToken], 201);
    }

    #[OA\Post(
        path: "/login",
        tags: ["Auth"],
        summary: "Log in a user",
        description: "Log in a user and return an access token.",
        requestBody: new OA\RequestBody(
            description: "User login data",
            required: true,
            content: new OA\MediaType(
                mediaType: "application/json",
                schema: new OA\Schema(
                    required: ["email", "password"],
                    properties: [
                        new OA\Property(property: "email", type: "string", description: "The user's email address"),
                        new OA\Property(property: "password", type: "string", description: "The user's password"),
                        // new OA\Property(property: "token_name", type: "string", description: "The name of the token (optional)", example: "Personal Access Token")
                    ]
                )
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: "Login successful",
                content: new OA\MediaType(
                    mediaType: "application/json",
                    schema: new OA\Schema(
                        required: ["token"],
                        properties: [
                            new OA\Property(property: "token", type: "string", description: "Access token for the logged-in user"),
                        ]
                    )
                )
            ),
            new OA\Response(
                response: 401,
                description: "Unauthorized"
            ),
            new OA\Response(
                response: 422,
                description: "Validation error"
            )
        ]
    )]
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
    
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    
        $tokenName = $request->input('token_name', 'Personal Access Token');
        $token = $request->user()->createToken($tokenName);
    
        return response()->json(['token' => $token->plainTextToken]);
    }
}
