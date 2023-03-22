<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Api\V1\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerifyMobileController extends Controller
{

    public function verifyMobileCode(Request $request): \Illuminate\Http\JsonResponse
    {

        $request->validate([
            'code' => ['required', 'numeric'],
        ]);

        // Already verified
        if ($request->user()->hasVerifiedMobile()) {
            return response()->json([
                'status' => false,
                'message' => 'Telefon numarası zaten onaylanmış'
            ], 400);
        }

        // Code wrong
        if (!$request->user()->verifyMobileCode($request->code)) {
            return response()->json([
                'status' => false,
                'message' => 'Telefon numarası kodu yanlış'
            ], 400);
        }

        // Code correct
        $request->user()->markMobileAsVerified();
        return response()->json([
            'status' => true,
            'message' => 'Telefon numarası başarıyla onaylandı'
        ]);

    }

    public function resendVerifyCode(Request $request): \Illuminate\Http\JsonResponse
    {
        $secondsOfValidation = (int)config('mobile.seconds_of_validation');

        // hakkı varsa
        if (config('mobile.max_attempts') > 0
            && $secondsOfValidation > 0
            && $request->user()->mobile_verify_code_sent_at->diffInSeconds() > $secondsOfValidation) {
            return response()->json([
                'status' => true
            ]);
        } else {
            return response()->json([
                'status' => false,
                'validation_seconds' => $secondsOfValidation,
                'wait_seconds' => $secondsOfValidation - $request->user()->mobile_verify_code_sent_at->diffInSeconds()
            ]);
        }
    }
}
