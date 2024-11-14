<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Stadium;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index()
    {
        return auth()->user()->reservations()->with('stadium')->get();
    }

    public function store()
    {
        $data = request()->validate([
            'stadium_id' => 'required|exists:stadia,id',
            'match_date' => 'required|date',
            'match_time' => 'required|date_format:H:i',
            'match_team' => 'string',
            'match_team_players' => 'integer|min:1|max:11',
            'match_team2' => 'string',
            'match_team2_players' => 'integer|min:1|max:11',
            'match_type' => 'in:league,friendly',
            'match_duration' => 'integer|min:1|max:4',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:pending,approved,rejected,canceled',
            'notes' => 'string',
            'phone' => 'string',
            'email' => 'string',
        ]);
        $auth = auth();

        return $auth->user()->reservations()->create(
            array_merge($data, [
                'user_id' => $auth->id(),
                'match_type' => $data['match_type'] ?? 'friendly',
                'match_duration' => $data['match_duration'] ?? 1,
            ])
        );
    }

    public function show($id)
    {
        return auth()->user()->reservations()->with('stadium')->findOrFail($id);
    }

    public function update($id)
    {
        $data = request()->validate([
            'stadium_id' => 'required|exists:stadiums,id',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
            'duration' => 'required|integer|min:1|max:3',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:pending,approved,rejected,canceled',
        ]);

        $reservation = auth()->user()->reservations()->findOrFail($id);
        $reservation->update($data);

        return $reservation;
    }

    public function destroy($id)
    {
        $reservation = auth()->user()->reservations()->findOrFail($id);
        $reservation->delete();

        return response()->json(null, 204);
    }

    public function getAvailableHours(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:stadia,id',
            'date' => 'required|date',
        ]);

        $stadium = Stadium::query()->find($request->id);

        return $stadium->getAvailableHours($request->date);
    }

    public function getAvailableHoursForDuration(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:stadia,id',
            'date' => 'required|date',
            'duration' => 'required|integer|min:1|max:15',
        ]);

        $stadium = Stadium::find($request->id);

        return $stadium->getAvailableHoursForDuration($request->date, $request->duration);
    }
}
