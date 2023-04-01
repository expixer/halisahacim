<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Process;

class TempController extends Controller
{
    public function gitpull()
    {
        $output = shell_exec('cd .. && git pull');
        echo "<pre>$output</pre>";
    }
}
