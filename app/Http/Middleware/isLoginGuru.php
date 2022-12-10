<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class isLoginGuru
{

    public function handle(Request $request, Closure $next)
    {
        if(Auth::check() || Auth::guard("admin")->check()){
            return $next($request);
        }
        
        return redirect("/login");
    }
}
