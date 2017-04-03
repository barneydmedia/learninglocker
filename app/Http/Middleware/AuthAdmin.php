<?php

namespace App\Http\Middleware;

use Closure;
use \Locker\Repository\Lrs\EloquentRepository as LrsRepo;
use \app\locker\statements\xAPIValidation as XApiValidator;
use \Locker\Helpers\Exceptions as Exceptions;
use \Locker\Helpers\Helpers as Helpers;

class AuthAdmin
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
        $lrs      = \App\Lrs::find( $request->route('lrs') );
        $user     = \Auth::user()->_id;
        $is_admin = false;
        foreach( $lrs->users as $u ){
          //is the user on the LRS user list with role admin?
          if($u['user'] == $user && $u['role'] == 'admin'){
            $is_admin = true;
          }
        }
        if( !$is_admin ){
          return Redirect::to('/');
        }

        return $next($request);
    }
}
