<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Stadium;
use Illuminate\Http\Request;

class StadiumSearchController extends Controller
{
    public function index(Request $request)
    {
        return Stadium::filter($request->all())->get();
    }
}
