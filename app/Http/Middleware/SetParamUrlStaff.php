<?php

namespace App\Http\Middleware;

use App\Models\Place;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;

class SetParamUrlStaff
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        /**
         * Set / Check Session PlaceID And Pram Url
         */
        $hinan = request()->query('hinan');
        if (!empty($hinan)) {
            Session::put('placeID', $hinan);
            $checkError500 = checkPlaceIdError500();
            if ($checkError500) {
                return redirect()->route('userMap')
                    ->with('error', trans('common.place_inactive_message'));
            }
        } else {
            $checkError500 = checkPlaceIdError500();
            if ($checkError500) {
                return redirect()->route('userMap')
                    ->with('error', trans('common.place_inactive_message'));
            }
            /**
             * Exclude post and put . methods
             */
            if ($request->method() != 'POST' && $request->method() != 'PUT') {
                return $this->redirectUrlParam();
            }
        }

        return $next($request);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectUrlParam()
    {
        $url = URL::full();
        if (request()->has('family_code') || request()->has('name')) {
            $urlPram = $url.'&hinan='.getPlaceID();
        } else {
            $urlPram = $url.'?hinan='.getPlaceID();
        }
        return redirect($urlPram);
    }
}
