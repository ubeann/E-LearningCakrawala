<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminEmployeeMiddleware
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
        if (Auth::user()->status != "admin" and Auth::user()->status != 'employee') {
            /*
            silahkan modifikasi pada bagian ini
            apa yang ingin kamu lakukan jika rolenya tidak sesuai
            */
            return redirect()->to('dashboard');
        }
        return $next($request);
    }
}
