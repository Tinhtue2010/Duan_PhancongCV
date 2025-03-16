<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRoleCBQL2
{
    public function handle(Request $request, Closure $next)
    {   
        if(!$request->user()){
            return redirect('dang-nhap');
        }
        elseif ($request->user() && $request->user()->quyen_han !== "CBQL2") {
            return redirect('dang-nhap');
        }

        return $next($request);
    }
}