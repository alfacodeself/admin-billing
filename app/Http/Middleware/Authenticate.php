<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        // if (!$request->isJson()) {
        //     return route('login');
        // }
        $request->expectsJson() ? response()->json(['message' => 'Unauthenticated'], 401) : redirect()->guest(route('login'));
    }
}