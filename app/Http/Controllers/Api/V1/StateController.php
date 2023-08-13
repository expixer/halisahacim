<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\State;

class StateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($city): \Illuminate\Database\Eloquent\Collection
    {
        return State::where('city_id', $city)->get();
    }
}
