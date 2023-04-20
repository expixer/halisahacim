<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Carbon\Carbon;

class MatchController extends Controller
{
    public function ActiveMatches()
    {
        return Reservation::where('user_id', auth()->id())->activeMatches()->get();
    }

    public function OldMatches()
    {
        return Reservation::where('user_id', auth()->id())->oldMatches()->get();
    }


}
