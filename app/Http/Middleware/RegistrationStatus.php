<?php

namespace App\Http\Middleware;

use Closure;
use \Locker\Repository\Lrs\EloquentRepository as LrsRepo;
use \app\locker\statements\xAPIValidation as XApiValidator;
use \Locker\Helpers\Exceptions as Exceptions;
use \Locker\Helpers\Helpers as Helpers;

class RegistrationStatus
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
        $site = \App\Site::first();
        if( $site ){
          if( $site->registration != 'Open' ) return Redirect::to('/');
        }
        return $next($request);
    }
}