<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;
use App\Models\Place;

class PlaceCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!Session::has('placeID')) {
            return redirect()->route('placeIDError');
        }

        $checkError500 = checkPlaceIdError500();
        if ($checkError500) {
            return redirect()->route('placeIDError');
        }

        return $next($request);
    }
}
