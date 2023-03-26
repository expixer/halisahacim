<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Stadium;
use Carbon\Carbon;
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
            'stadium_id' => 'required|exists:stadiums,id',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
            'duration' => 'required|integer|min:1|max:3',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:pending,approved,rejected,canceled',
        ]);

        $reservation = auth()->user()->reservations()->create($data);

        return $reservation;
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

        $stadium = Stadium::find($request->id);

        return $stadium->getAvailableHours($request->date, $request->duration);
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
