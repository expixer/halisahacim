<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ApplyForPanelNotification;

class EmailController extends Controller
{
    public function applyForPanel(Request $request)
    {
        $name = $request->input('name');
        $surname = $request->input('surname');
        $phone = $request->input('phone');
        $facility_name = $request->input('facility_name');

        Mail::to('test@outlook.com')->send(new ApplyForPanelNotification($name, $surname, $phone, $facility_name));

        return response()->json(['message' => 'Başvurunuz Başarıyla Alındı']);
    }
}
