<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CekAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$role)
    {

        if ($request->is('api/*')) {
            if (auth()->user() && in_array(auth()->user()->role, $role)) {
                return $next($request);
            }
            $message = 'Unauthorized'; // Pesan untuk kegagalan otentikasi
            abort(401, $message);
        } else {
            if (auth()->user() && in_array(auth()->user()->role, $role)) {
                return $next($request);
            }

            return redirect()->route('getlogin');




            // dd(auth()->user()->role);

        }
    }
}
