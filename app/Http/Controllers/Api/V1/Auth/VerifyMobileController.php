<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Api\V1\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerifyMobileController extends Controller
{

    public function verifyMobileCode(Request $request)
    {

        $request->validate([
            'code' => ['required', 'numeric'],
        ]);

        // Code correct
        if ($request->user()->verifyMobileCode()) {
                $request->user()->markMobileAsVerified();
                return response()->json([
                    'status' => true,
                ]);
        }else{
            return response()->json([
                'status' => false,
            ], 401);
        }
    }

    public function checkVerifyCode(Request $request)
    {
        $secondsOfValidation = (int) config('mobile.seconds_of_validation');
        if ($secondsOfValidation > 0
            &&  $request->user()->mobile_verify_code_sent_at->diffInSeconds() > $secondsOfValidation
            && $request->user()->mobile_verify_code == $request->code) {
            return response()->json([
               'status' => true
            ]);
        }else{
            return response()->json([
                'status' => false,
                'validation_seconds' => $secondsOfValidation,
                'wait_seconds' => $secondsOfValidation - $request->user()->mobile_verify_code_sent_at->diffInSeconds()
            ]);
        }
    }
}
