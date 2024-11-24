<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthApiController extends Controller
{
    public function register(Request $request) {
        try {
            $request->validate([
                'name' => ['required', 'string', 'max:100'],
                'email' => ['required', 'string', 'email', 'max:50', 'unique:users'],
                'password' => ['required', 'min:6'],
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $tokenResult = $user->createToken('AUTH')->plainTextToken;

            $data = [
                'access_token' => $tokenResult,
                'token_type' => ' Bearer',
                'user' => $user
            ];

            return $this->sendResponse($data, 'Successfull Register');

        } catch (\Exception $error) {
            return $this->sendError([
                'message' => 'Something went wrong',
                'error message' => $error->getMessage()
            ], 'Registration Failed!');
        }
    }

    public function login(Request $request) {
        try {
            $request->validate([
                'email' => ['required', 'string', 'email'],
                'password' => ['required', 'min:6'],
            ]);


            $credentials = request(['email', 'password']);

            if (!Auth::attempt($credentials)) {
                return $this->sendError('Unauthorized', 'Authentication Failed', 500);
            }

            $user = User::where('email', $request->email)->first();
            $user->tokens()->delete();

            if (!Hash::check($request->password, $user->password)) {
                throw new \Exception('Invalid Credentials');
            }

            $tokenResult = $user->createToken('AUTH')->plainTextToken;

            $data = [
                'access_token' => $tokenResult,
                'token_type' => 'Bearer ',
                'user' => $user
            ];

            return $this->sendResponse($data, 'Successfull Login');

        } catch (\Exception $error) {
            return $this->sendError([
                'message' => 'Authentication',
                'error message' => $error->getMessage()
            ], 'Login Failed!');
        }
    }

    public function getUser() {
        try {

            $user = Auth::user();
            return $this->sendResponse(new UserResource($user), 'Successfully User');

        } catch (\Exception $error) {
            return $this->sendError([
                'message' => 'User Not Found',
                'error message' => $error->getMessage()
            ], 'Get User Failed!');
        }
    }

    public function logout() {
        $user = User::find(Auth::user()->id);
        $user->tokens()->delete();
        return response()->noContent();
    }
}
