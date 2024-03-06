<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LevelMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $level): Response
    {
        if($request->user()->level !== $level){
            if($request->user()->level == '1'){
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('home');
            }
        }
        return $next($request);
    }
}
