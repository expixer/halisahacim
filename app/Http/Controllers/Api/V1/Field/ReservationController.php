<?php

namespace App\Http\Controllers\Api\V1\Field;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Stadium;
use Illuminate\Http\Request;

class ReservationController extends Controller {
  public function reservations(Request $request) {
    $start_date = $request->start_date;
    $end_date = $request->end_date ?? date('Y-m-d', strtotime($start_date . ' + 6 days'));
    if ($request->has('date')) {
      $start_date = $request->date;
      $end_date = $request->date;
    }

    return Reservation::with('stadium')
      ->whereHas('stadium', function ($query) {
        $query->where('firm_id', auth()->user()->firm_id);
      })
      ->whereDate('created_at', '>=', $start_date)
      ->whereDate('created_at', '<=', $end_date)
      ->get();
  }

  public function reservation_approve(Request $request, Reservation $reservation) {
    $reservation->update([
      'status' => 'approved',
    ]);

    // Send notification to user

    return $reservation;
  }

  public function reservation_reject(Request $request, Reservation $reservation) {
    $reservation->update([
      'status' => 'rejected',
    ]);

    // Send notification to user

    return $reservation;
  }

  public function reservation_detail(Request $request, $reservation) {
    return Reservation::with('stadium')
      ->whereHas('stadium', function ($query) {
        $query->where('firm_id', auth()->user()->firm_id);
      })
      ->findOrFail($reservation);
  }

  public function reservation_update(Request $request, $reservation) {
    $data = $request->validate([
      'date'       => 'date',
      'time'       => 'date_format:H:i',
      'price'      => 'numeric|min:0',
      'status'     => 'in:pending,approved,rejected,canceled',
    ]);

    $reservation = Reservation::with('stadium')
      ->whereHas('stadium', function ($query) {
        $query->where('firm_id', auth()->user()->firm_id);
      })
      ->findOrFail($reservation);

    $reservation->update($data);

    return $reservation;

  }

  public function getAvailableHoursForStadium(Request $request) {
    $request->validate([
      'id'   => 'required|exists:stadia,id',
      'date' => 'required|date',
    ]);

    $stadium = Stadium::query()
      ->find($request->id);

    return $stadium->getAvailableHoursForStadium($request->date);
  }

}
