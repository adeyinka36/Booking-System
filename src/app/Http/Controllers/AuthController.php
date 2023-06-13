<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index()
    {
        return response()->json(['data' => UserResource::collection(User::all())]);
    }

    public function register(UserRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);


        $token = $this->createToken($user, (bool)$user->is_admin);

        $cookie = cookie('booking_token', $token, 60*24);

        return response()->json([
            'data' => new UserResource($user),
            'token' => $token,
        ], 201)->withCookie($cookie);

    }


    public function store(UserRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);

        return response()->json([
            'data' => new UserResource($user)
        ], 201);
    }


    public function show(User $user)
    {
        return response()->json(['data' => new UserResource($user)]);
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        if(!Auth::attempt(["email" => $data['email'], "password" => $data['password']])){
            return response()->json(['Message' => 'User not found'], 404);
        }

        $user  = User::find(Auth::user()->getAuthIdentifier());

        $token = $this->createToken($user, (bool)$user->is_admin);

        $cookie = cookie('booking_token', $token, 60*24);

        return response()->json([
            'data' => new UserResource($user),
            'token' => $token,
        ], 200)->withCookie($cookie);
    }

    public function update(UserUpdateRequest $request, User $user)
    {
        $data = $request->validated();
        $user->update($data);
        return response()->json([
            'data' => new UserResource($user)
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        $cookie = cookie('booking_token', null, -1);
        return response()->json([
            'message' => 'Logged out'
        ])->withCookie($cookie);
    }

    public function destroy(User $user)
    {
        $user->tokens()->delete();
        $user->delete();
        return response()->json([], 204)->withCookie(cookie('booking_token', null, -1));
    }

    public function user(Request $request)
    {
        return response()->json(['data' => $request->user() ? new UserResource($request->user()) : null]);
    }

    public function createToken(User $user, bool $is_admin = false)
    {
        return  $is_admin ? $user->createToken($user['email'],['make_admin_changes'])->plainTextToken : $user->createToken($user['email'], ['make_user_changes'])->plainTextToken;
    }
}
