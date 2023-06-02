<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Models\StateUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function show(Request $request): \Illuminate\Http\JsonResponse
    {
        return response()->json(
            User::with([
                'reservations',
                'state' => ['city']
            ])->find(auth()->id())
        );
    }

    public function update(Request $request): \Illuminate\Http\JsonResponse
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'email', Rule::unique('users')->ignore(auth()->user())],
        ]);

        auth()->user()->update($validatedData);

        return response()->json($validatedData, 202);
    }

    public function getAddress(Request $request): \Illuminate\Http\JsonResponse
    {
        return response()->json($request->user()->state()->with('city')->first());
    }

    public function updateAddress(Request $request)
    {
        $validatedData = $request->validate([
            'city_id' => ['required'],
            'state_id' => ['required'], //array kontroklü
        ]);
        DB::transaction(function () use ($validatedData) {
            auth()->user()->update(['city_id' => $validatedData['city_id']]);
            StateUser::query()->where('user_id', auth()->id())->delete();
            foreach ($validatedData as $validatedDatum) {
                StateUser::query()->create([
                    'user_id' => auth()->id(),
                    'state_id' => $validatedDatum['state_id']
                ]);
            }

        });
        return response()->json($validatedData, 202);
    }

    public function updateEmail(Request $request): \Illuminate\Http\JsonResponse
    {
        $validatedData = $request->validate([
            'email' => ['required', 'email', Rule::unique('users')->ignore(auth()->user())],
        ]);

        $update = auth()->user()->update($validatedData);

        if ($update) {
            return response()->json([
                'message' => 'E-mail değişikliği başarılı',
            ]);
        }

        return response()->json([
            'message' => 'E-mail değişikliği başarısız',
        ], 500);

    }
}
