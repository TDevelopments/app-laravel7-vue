<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Role;
use App\Models\Order;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Http\Resources\OrderResource;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function signup(UserRequest $request)
    {
        // $request->validate([
        //     'name' => 'required|string',
        //     'email' => 'required|string|email|unique:users',
        //     'password' => 'required|string|confirmed',
        // ]);
        // $user = new User([
        //     'name' => $request->name,
        //     'email' => $request->email,
        //     'password' => bcrypt($request->password),
        // ]);
        // $user->save();

        // return response()->json([
        //     'message' => 'Successfully created user!'], 201);
        
        $request['password']=Hash::make($request['password']);
        $request['remember_token'] = Str::random(10);
        $user = User::create($request->toArray());
        $user->roles()->attach(Role::where('name', 'user')->first());
        $token = $user->createToken('Laravel Password Grant Client')->accessToken;
        $response = ['token' => $token];
        return response($response, 200);
    }

    public function login(Request $request)
    {
        $request->validate([
            'dni' => 'required|integer',
            'password' => 'required|string',
            'remember_me' => 'boolean',
        ]);
        $user = User::where('dni', $request->dni)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                // $token = $user->createToken('Laravel Password Grant Client')->accessToken;
                $tokenResult = $user->createToken('Personal Access Token');
                $response = [
                    // 'token' => $token
                    'access_token' => $tokenResult->accessToken,
                    'token_type' => 'Bearer',
                    'expires_at' => Carbon::parse(
                        $tokenResult->token->expires_at)
                        ->toDateTimeString(),
                    'user' => new UserResource($user),
                ];
                return response($response, 200);
            } else {
                $response = ["message" => "Password mismatch"];
                return response($response, 422);
            }
        } else {
            $response = ["message" =>'User does not exist'];
            return response($response, 422);
        }
        // $credentials = request(['dni', 'password']);
        // if (!Auth::attempt($credentials)) {
        //     return response()->json([
        //         'message' => 'Unauthorized'], 401);
        // }
        // $user = $request->user();
        // $tokenResult = $user->createToken('Personal Access Token');
        // $token = $tokenResult->token;
        // if ($request->remember_me) {
        //     $token->expires_at = Carbon::now()->addWeeks(1);
        // }
        // $token->save();
        // return response()->json([
        //     'access_token' => $tokenResult->accessToken,
        //     'token_type' => 'Bearer',
        //     'expires_at' => Carbon::parse(
        //         $tokenResult->token->expires_at)
        //         ->toDateTimeString(),
        //     'user' => new UserResource($user),
        // ]);
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json(['message' =>
            'Successfully logged out']);
    }

    public function user(Request $request)
    {
        // return response()->json($request->user());
        return new UserResource($request->user());
    }
    
    public function update(UpdateUserRequest $request)
    { 
        $user = $request->user();
        $user->update($request->all());
        return new UserResource($user);
    }

    public function orderByUser(Request $request)
    {
        $user = $request->user()->id;
        $order = Order::firstWhere('user_id', $user);
        return new OrderResource($order);
    }
}
