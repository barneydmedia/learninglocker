<?php

namespace App\Http\Middleware;

use Closure;
use \Locker\Repository\Lrs\EloquentRepository as LrsRepo;
use \app\locker\statements\xAPIValidation as XApiValidator;
use \Locker\Helpers\Exceptions as Exceptions;
use \Locker\Helpers\Helpers as Helpers;

class Csrf
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
        // $token = \Request::ajax() ? \App\LockerRequest::header('X-CSRF-Token') : $request->input('_token');
        // if (\Session::token() !== $token)
        // {
        //   throw new \Illuminate\Session\TokenMismatchException;
        // }
        return $next($request);
    }
}
