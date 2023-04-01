<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Process;

class TempController extends Controller
{
    public function gitpull()
    {
        $process = Process::run('git pull');
        return response($process->output());

    }
}
