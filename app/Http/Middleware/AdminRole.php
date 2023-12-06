<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Auth;

class AdminRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $currentlevel =  Auth::user()->level;        

        
        if($currentlevel == 0){
            return $next($request);
        }
        return $this->sendError('Anda Tidak Berhak Mengubah');
    }
}
