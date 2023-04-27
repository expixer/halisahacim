<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordUpdateController extends Controller
{
    public function __invoke(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password'         => ['required', 'confirmed', Password::defaults()],
        ]);

        $update = auth()->user()->update([
            'password' => Hash::make($request->input('password')),
        ]);

        if($update){
            return response()->json([
                'message' => 'Şifreniz başarıyla güncellendi',
                'status' => true
            ], 202);
        }

        return response()->json([
            'message' => 'Eski şifreniz yanlış',
            'status' => false
        ], 202);


    }
}
