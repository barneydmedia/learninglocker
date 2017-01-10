<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use \Locker\Repository\Lrs\EloquentRepository as LrsRepo;
use \app\locker\statements\xAPIValidation as XApiValidator;
use \Locker\Helpers\Exceptions as Exceptions;
use \Locker\Helpers\Helpers as Helpers;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = null;

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {

        // // Checks for logged in user.
        // Route::filter('auth', function() {
        //   if (Auth::guest()) return Redirect::guest('/');
        // });


        // /*
        // |--------------------------------------------------------------------------
        // | Submit statement via basic http authentication
        // |--------------------------------------------------------------------------
        // |
        // | Login in once using key / secret to store statements or retrieve statements.
        // |
        // */
        // Route::filter('auth.statement', function($route, $request){

        //   $method = Request::server('REQUEST_METHOD');

        //   if( $method !== "OPTIONS" ){

        //     // Validates authorization header.
        //     $auth_validator = new XApiValidator();
        //     $authorization = LockerRequest::header('Authorization');
        //     if ($authorization !== null && strpos($authorization, 'Basic') === 0) {
        //       $authorization = gettype($authorization) === 'string' ? substr($authorization, 6) : false;
        //       $auth_validator->checkTypes('auth', $authorization, 'base64', 'headers');
              
        //       if ($auth_validator->getStatus() === 'failed') {
        //         throw new Exceptions\Validation($auth_validator->getErrors());
        //       }
        //     } else if ($authorization !== null && strpos($authorization, 'Bearer') === 0) {
        //       $bridgedRequest  = OAuth2\HttpFoundationBridge\Request::createFromRequest(Request::instance());
        //       $bridgedResponse = new OAuth2\HttpFoundationBridge\Response();
        //       if (!App::make('oauth2')->verifyResourceRequest($bridgedRequest, $bridgedResponse)) {
        //         throw new Exceptions\Exception('Unauthorized request.', $bridgedResponse->getStatusCode());
        //       }
        //     } else if ($authorization === null) {
        //       throw new Exceptions\Exception('Unauthorized request.', 401);
        //     }

        //     $lrs = Helpers::getLrsFromAuth();

        //     //attempt login once
        //     if ( ! Auth::onceUsingId($lrs->owner_id) ) {
        //       throw new Exceptions\Exception('Unauthorized request.', 401);
        //     }

        //   }
        // });

        // // Checks for super admin.
        // Route::filter('auth.super', function( $route, $request ){
        //   if( Auth::user()->role != 'super' ){
        //     return Redirect::to('/');
        //   }
        // });

        // // Checks for LRS admin.
        // Route::filter('auth.admin', function( $route, $request ){

        //   $lrs      = Lrs::find( $route->parameter('lrs') );
        //   $user     = Auth::user()->_id;
        //   $is_admin = false;
        //   foreach( $lrs->users as $u ){
        //     //is the user on the LRS user list with role admin?
        //     if($u['user'] == $user && $u['role'] == 'admin'){
        //       $is_admin = true;
        //     }
        //   }
        //   if( !$is_admin ){
        //     return Redirect::to('/');
        //   }

        // });

        // // Checks for LRS access.
        // Route::filter('auth.lrs', function( $route, $request ){
        //   //check to see if lrs id exists?
        //   $lrs  = Lrs::find( $route->parameter('id') );
        //   //if not, let's try the lrs parameter
        //   if( !$lrs ){
        //     $lrs  = Lrs::find( $route->parameter('lrs') );
        //   }
        //   $user = \Auth::user();

        //   if( $lrs ){
        //     //get all users will access to the lrs
        //     foreach( $lrs->users as $u ){
        //       $get_users[] = $u['_id'];
        //     }
        //     //check current user is in the list of allowed users, or is super admin
        //     if( !in_array($user->_id, $get_users) && $user->role != 'super' ){
        //       return Redirect::to('/');
        //     }

        //   }else{
        //     return Redirect::to('/');
        //   }

        // });

        // // Checks for LRS edit access.
        // Route::filter('edit.lrs', function( $route, $request ){

        //   //check to see if lrs id exists?
        //   $lrs  = Lrs::find( $route->parameter('id') );
        //   //if not, let's try the lrs parameter
        //   if( !$lrs ){
        //     $lrs  = Lrs::find( $route->parameter('lrs') );
        //   }

        //   $user = \Auth::user();

        //   if( $lrs ){

        //     //get all users with admin access to the lrs
        //     foreach( $lrs->users as $u ){
        //       if( $u['role'] == 'admin' ){
        //         $get_users[] = $u['_id'];
        //       }
        //     }

        //     //check current user is in the list of allowed users or is super
        //     if( !in_array($user->_id, $get_users) && $user->role != 'super' ){
        //       return Redirect::to('/');
        //     }

        //   }else{
        //     return Redirect::to('/');
        //   }

        // });

        // // Checks for LRS creation access.
        // Route::filter('create.lrs', function( $route, $request ){

        //   $site       = Site::first();
        //   $allowed    = $site->create_lrs;
        //   $user_role  = \Auth::user()->role;

        //   if( !in_array($user_role, $allowed) ){
        //     return Redirect::to('/');
        //   }

        // });

        // /*
        // |---------------------------------------------------------------------------
        // | Check whether registration has been enabled
        // |---------------------------------------------------------------------------
        // */

        // Route::filter('registration.status', function( $route, $request ){
        //   $site = \Site::first();
        //   if( $site ){
        //     if( $site->registration != 'Open' ) return Redirect::to('/');
        //   }
        // });

        // /*
        // |---------------------------------------------------------------------------
        // | Check the person deleting a user account, is allowed to.
        // |
        // | User's can delete their own account as can super admins
        // |---------------------------------------------------------------------------
        // */

        // Route::filter('user.delete', function( $route, $request ){
        //   $user = $route->parameter('users');
        //   if( \Auth::user()->_id != $user && !\Locker\Helpers\Access::isRole('super') ){
        //     return Redirect::to('/');
        //   }
        // });


        // /*
        // |--------------------------------------------------------------------------
        // | Guest Filter
        // |--------------------------------------------------------------------------
        // |
        // | The "guest" filter is the counterpart of the authentication filters as
        // | it simply checks that the current user is not logged in. A redirect
        // | response will be issued if they are, which you may freely change.
        // |
        // */

        // Route::filter('guest', function()
        // {
        //   if (Auth::check()) return Redirect::to('/');
        // });

        // /*
        // |--------------------------------------------------------------------------
        // | CSRF Protection Filter
        // |--------------------------------------------------------------------------
        // |
        // | The CSRF filter is responsible for protecting your application against
        // | cross-site request forgery attacks. If this special token in a user
        // | session does not match the one given in this request, we'll bail.
        // |
        // */

        // Route::filter('csrf', function()
        // {
        //   $token = Request::ajax() ? LockerRequest::header('X-CSRF-Token') : Input::get('_token');
        //   if (Session::token() !== $token)
        //   {
        //     throw new Illuminate\Session\TokenMismatchException;
        //   }
        // });

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        // $this->mapApiRoutes();

        $this->mapWebRoutes();

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::group([
            'middleware' => 'web',
            'namespace' => $this->namespace,
        ], function ($router) {
            require base_path('routes/web.php');
        });
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::group([
            'middleware' => 'api',
            'namespace' => $this->namespace,
            'prefix' => 'api',
        ], function ($router) {
            require base_path('routes/api.php');
        });
    }
}
