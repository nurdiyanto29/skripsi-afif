<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {

        if ($request->is('api/*')) {
            $message = 'Unauthorized'; // Pesan untuk kegagalan otentikasi
            abort(401, $message);
        } else {
            return route('getlogin'); // Kembalikan rute login untuk aplikasi web
        }

    }
}
