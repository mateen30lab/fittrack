<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PremiumMiddleware
{
    public function handle(Request $request, Closure $next)
    {

        if(!auth()->user()->hasPremium()){

            return redirect()
                ->route('premium.index')
                ->with('error','Upgrade to Premium.');

        }

        return $next($request);

    }
}