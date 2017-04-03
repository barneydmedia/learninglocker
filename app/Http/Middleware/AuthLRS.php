<?php

namespace App\Http\Middleware;

use Closure;
use \Locker\Repository\Lrs\EloquentRepository as LrsRepo;
use \app\locker\statements\xAPIValidation as XApiValidator;
use \Locker\Helpers\Exceptions as Exceptions;
use \Locker\Helpers\Helpers as Helpers;

class AuthLRS
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
        $route    = $request->route();
        $lrs  = \App\Lrs::find( $route->parameter('id') );
        
        //if not, let's try the lrs parameter
        if( !$lrs ){
          $lrs  = \App\Lrs::find( $route->parameter('lrs') );
        }
        
        // I can't figure out why, but sometimes this comes through as "lr"
        if ( !$lrs ){
          $lrs  = \App\Lrs::find( $route->parameter('lr') );
        }
        
        $user = \Auth::user();

        if( $lrs ){
          //get all users will access to the lrs
          foreach( $lrs->users as $u ){
            $get_users[] = $u['_id'];
          }
          //check current user is in the list of allowed users, or is super admin
          if( !in_array($user->_id, $get_users) && $user->role != 'super' ){
            return \Redirect::to('/');
          }

        }else{
          return \Redirect::to('/');
        }

        return $next($request);
    }
}
