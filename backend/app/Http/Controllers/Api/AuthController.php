<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        $data = $request->validate([
            'phone' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $user = User::query()
            ->where('phone', $data['phone'])
            ->where('status', 1)
            ->first();

        if (! $user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Sai tài khoản hoặc mật khẩu!',
            ], 401);
        }

        $passwordMatches = Hash::check($data['password'], $user->password) || $user->password === $data['password'];

        if (! $passwordMatches) {
            return response()->json([
                'status' => 'error',
                'message' => 'Sai tài khoản hoặc mật khẩu!',
            ], 401);
        }

        if ($user->password === $data['password']) {
            $user->password = Hash::make($data['password']);
            $user->save();
        }

        return response()->json([
            'status' => 'success',
            'user' => [
                'id' => $user->id,
                'fullname' => $user->fullname,
                'phone' => $user->phone,
                'status' => $user->status,
                'user_type' => $user->user_type,
                'cart' => [],
            ],
        ]);
    }

    public function register(Request $request): JsonResponse
    {
        try {
            $data = $request->validate([
                'fullname' => ['required', 'string', 'max:255'],
                'phone' => ['required', 'string', 'max:30', 'unique:users,phone'],
                'password' => ['required', 'string', 'min:6'],
            ]);
        } catch (ValidationException $exception) {
            $message = $exception->validator->errors()->first() ?: 'Thiếu dữ liệu!';

            return response()->json([
                'status' => 'error',
                'message' => $message,
            ], 422);
        }

        $user = User::create([
            'fullname' => trim($data['fullname']),
            'phone' => trim($data['phone']),
            'password' => Hash::make($data['password']),
            'status' => 1,
            'user_type' => 0,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Đăng ký thành công',
            'user' => [
                'id' => $user->id,
                'fullname' => $user->fullname,
                'phone' => $user->phone,
                'user_type' => $user->user_type,
                'cart' => [],
            ],
        ]);
    }
}
