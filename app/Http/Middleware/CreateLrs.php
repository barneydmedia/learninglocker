<?php

namespace App\Http\Middleware;

use Closure;
use \Locker\Repository\Lrs\EloquentRepository as LrsRepo;
use \app\locker\statements\xAPIValidation as XApiValidator;
use \Locker\Helpers\Exceptions as Exceptions;
use \Locker\Helpers\Helpers as Helpers;

class CreateLrs
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $site       = \App\Site::first();
        $allowed    = $site->create_lrs;
        $user_role  = \Auth::user()->role;

        if( !in_array($user_role, $allowed) ){
          return Redirect::to('/');
        }

        return $next($request);
    }
}
