<?php

namespace App\Http\Controllers;

/**
 * @OA\OpenApi(
 *     @OA\Info(
 *         title="User API",
 *         version="1.0.0",
 *         description="API for managing users",
 *         @OA\Contact(
 *             email="beghiba@gmail.com"
 *         ),
 *         @OA\License(
 *             name="BEGHDI Hibz",
 *             url="https://opensource.org/licenses/MIT"
 *         )
 *     )
 * )
 */

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class UserAuthController extends Controller
{
    /**
     * Register a new user.
     *
     * @OA\Post(
     *     path="/api/register",
     *     summary="Register a new user",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="User registration details",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 required={"name", "email", "password", "c_password"},
     *                 @OA\Property(
     *                     property="name",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="email",
     *                     type="string",
     *                     format="email"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="c_password",
     *                     type="string",
     *                     description="Confirm password, must match the 'password' field"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User registered successfully",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="token",
     *                 type="string",
     *                 description="Access token for the registered user"
     *             ),
     *             @OA\Property(
     *                 property="name",
     *                 type="string",
     *                 description="Name of the registered user"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="The given data was invalid."
     *             ),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 description="Validation errors",
     *                 example={
     *                     "email": {"The email field is required."},
     *                     "password": {"The password field is required."},
     *                     "name": {"The name field is required."}
     *                 }
     *             )
     *         )
     *     )
     * )
     */

    public function register(Request $request)
    {
        $registerUserData = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|min:8',
        ]);
        $user = User::create([
            'name' => $registerUserData['name'],
            'email' => $registerUserData['email'],
            'password' => Hash::make($registerUserData['password']),
        ]);

        $token = Auth::guard('api');

        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/login",
     *     summary="Login user",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="User login details",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 required={"email", "password"},
     *                 @OA\Property(
     *                     property="email",
     *                     type="string",
     *                     format="email",
     *                     description="User email"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string",
     *                     format="password",
     *                     description="User password"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User logged in successfully",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="status",
     *                 type="string",
     *                 example="success",
     *                 description="Status of the response"
     *             ),
     *             @OA\Property(
     *                 property="user",
     *                 type="object",
     *                 @OA\Property(
     *                     property="id",
     *                     type="integer",
     *                     format="int64",
     *                     description="User ID"
     *                 ),
     *                 @OA\Property(
     *                     property="name",
     *                     type="string",
     *                     description="User's name"
     *                 ),
     *                 @OA\Property(
     *                     property="email",
     *                     type="string",
     *                     format="email",
     *                     description="User's email"
     *                 ),
     *                 @OA\Property(
     *                     property="created_at",
     *                     type="string",
     *                     format="date-time",
     *                     description="User creation datetime"
     *                 ),
     *                 @OA\Property(
     *                     property="updated_at",
     *                     type="string",
     *                     format="date-time",
     *                     description="User update datetime"
     *                 )
     *             ),
     *             @OA\Property(
     *                 property="authorization",
     *                 type="object",
     *                 @OA\Property(
     *                     property="token",
     *                     type="string",
     *                     description="Access token for the logged in user"
     *                 ),
     *                 @OA\Property(
     *                     property="type",
     *                     type="string",
     *                     description="Type of token"
     *                 ),
     *                 @OA\Property(
     *                     property="expires_in",
     *                     type="integer",
     *                     description="Token expiration time in seconds"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="status",
     *                 type="string",
     *                 example="error",
     *                 description="Status of the response"
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Invalid Credentials",
     *                 description="Error message"
     *             )
     *         )
     *     )
     * )
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $credentials = $request->only('email', 'password');

        $token = Auth::guard('api')->attempt($credentials);
        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid Credentials',
            ], 401);
        }

        $user = Auth::guard('api')->user();
        return response()->json([
            'status' => 'success',
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
                'expires_in' => config('jwt.ttl') * 60, // Token expiration time in seconds
            ]
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/logout",
     *     summary="Logout the user",
     *     tags={"Authentication"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successfully logged out",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="status",
     *                 type="string",
     *                 example="success",
     *                 description="Status of the response"
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Successfully logged out",
     *                 description="Success message"
     *             )
     *         )
     *     )
     * )
     */

    public function logout()
    {
        Auth::guard('api')->logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/refresh",
     *     summary="Refresh the authentication token",
     *     tags={"Authentication"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Token refreshed successfully",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="user",
     *                 type="object",
     *                 description="User object",
     *                 @OA\Property(
     *                     property="id",
     *                     type="integer",
     *                     format="int64",
     *                     description="User ID"
     *                 ),
     *                 @OA\Property(
     *                     property="name",
     *                     type="string",
     *                     description="User's name"
     *                 ),
     *                 @OA\Property(
     *                     property="email",
     *                     type="string",
     *                     format="email",
     *                     description="User's email address"
     *                 )
     *             ),
     *             @OA\Property(
     *                 property="authorisation",
     *                 type="object",
     *                 description="Authorization information",
     *                 @OA\Property(
     *                     property="token",
     *                     type="string",
     *                     description="Refreshed access token"
     *                 ),
     *                 @OA\Property(
     *                     property="type",
     *                     type="string",
     *                     description="Token type (e.g., bearer)"
     *                 )
     *             )
     *         )
     *     )
     * )
     */

    public function refresh()
    {
        return response()->json([
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }

    public function user()
    {
        return Auth::user();
    }
}
