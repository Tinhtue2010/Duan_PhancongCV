<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRoleCanBo
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->user() && $request->user()->loai_tai_khoan !== "Cán bộ") {
            return redirect('dang-nhap');
        }

        return $next($request);
    }
}