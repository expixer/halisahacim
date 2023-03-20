<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use App\Interfaces\MustVerifyMobile;
use Illuminate\Support\Facades\Redirect;

class EnsureMobileIsVerifiedMiddleware
{
    public function handle(Request $request, Closure $next, $redirectToRoute = null)
    {
        if (! $request->user() ||
            ($request->user() instanceof MustVerifyMobile &&
            ! $request->user()->hasVerifiedMobile())) {
            return $request->expectsJson()
                    ? response()->json('Telefon numaranızı onaylamadınız.', 403)
                    : Redirect::guest(URL::route($redirectToRoute ?: 'verification-mobile.notice'));
        }

        return $next($request);
    }
}
