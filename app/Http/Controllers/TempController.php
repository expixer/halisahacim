<?php

namespace App\Http\Controllers;

class TempController extends Controller
{
    public function gitpull()
    {
        $output = shell_exec('cd .. && git pull');
        echo "<pre>$output</pre>";
    }
}
