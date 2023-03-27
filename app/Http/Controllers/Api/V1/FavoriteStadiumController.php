<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FavoriteStadiumController extends Controller
{
    public function index()
    {
        return auth()->user()->favoriteStadiums()->with('stadium')->get();
    }

    public function store()
    {
        $data = request()->validate(
            [
                'stadium_id' => 'required|exists:stadia,id',
            ]
        );
        //$favorites = auth()->user()->favoriteStadiums()->findOrFail(request());
        $favorites = auth()->user()->favoriteStadiums()->create($data);

        return $favorites;
    }

    public function destroy($id)
    {
        $favorites = auth()->user()->favoriteStadiums()->findOrFail($id);
        if ($favorites) {
            $favorites->delete();
        }

        return response()->json(null, 204);
    }
}
