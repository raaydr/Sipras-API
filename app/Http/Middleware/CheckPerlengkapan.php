<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Perlengkapan;
use App\Http\Resources\PerlengkapanResource;
use Auth;

class CheckPerlengkapan extends BaseController
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $currentlevel =  Auth::user()->level;        
        $user_id = Auth::user()->id;
        $Perlengkapan = Perlengkapan::findOrFail($request->id);
        if($currentlevel == 0 || $user_id == $Perlengkapan->user_id){
            return $next($request);
        }
        return $this->sendError('Anda Tidak Berhak Mengubah');
    }
}
