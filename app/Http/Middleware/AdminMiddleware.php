<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Ļauj piekļūt tikai lietotājiem ar lomu "admin".
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()?->role !== 'admin') {
            return response()->json([
                'message' => 'Piekļuve atļauta tikai administratoriem.',
            ], 403);
        }

        return $next($request);
    }
}
