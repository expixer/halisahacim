<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Response;
class PasswordUpdateController extends Controller
{
    public function __invoke(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $request->validate([
                'current_password' => ['required', 'current_password'],
                'password' => ['required', 'confirmed', Password::defaults()],
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $errors = $e->validator->errors()->getMessages();
            return response()->json(['message' => 'Eski şifre uyuşmuyor', 'status' => 0], 422);
        }

        auth()->user()->update([
            'password' => Hash::make($request->input('password')),
        ]);

        return response()->json([
            'message' => 'Şifreniz başarıyla güncellendi',
            'status' => 1
        ], 202);
    }
}
