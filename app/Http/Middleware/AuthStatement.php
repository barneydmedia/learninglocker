<?php

namespace App\Http\Middleware;

use Closure;
use \Locker\Repository\Lrs\EloquentRepository as LrsRepo;
use \app\locker\statements\xAPIValidation as XApiValidator;
use \Locker\Helpers\Exceptions as Exceptions;
use \Locker\Helpers\Helpers as Helpers;

class AuthStatement
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
        $method = Request::server('REQUEST_METHOD');

        if( $method !== "OPTIONS" ){

          // Validates authorization header.
          $auth_validator = new XApiValidator();
          $authorization = LockerRequest::header('Authorization');
          if ($authorization !== null && strpos($authorization, 'Basic') === 0) {
            $authorization = gettype($authorization) === 'string' ? substr($authorization, 6) : false;
            $auth_validator->checkTypes('auth', $authorization, 'base64', 'headers');
            
            if ($auth_validator->getStatus() === 'failed') {
              throw new Exceptions\Validation($auth_validator->getErrors());
            }
          } else if ($authorization !== null && strpos($authorization, 'Bearer') === 0) {
            $bridgedRequest  = OAuth2\HttpFoundationBridge\Request::createFromRequest(Request::instance());
            $bridgedResponse = new OAuth2\HttpFoundationBridge\Response();
            if (!App::make('oauth2')->verifyResourceRequest($bridgedRequest, $bridgedResponse)) {
              throw new Exceptions\Exception('Unauthorized request.', $bridgedResponse->getStatusCode());
            }
          } else if ($authorization === null) {
            throw new Exceptions\Exception('Unauthorized request.', 401);
          }

          $lrs = Helpers::getLrsFromAuth();

          //attempt login once
          if ( ! Auth::onceUsingId($lrs->owner_id) ) {
            throw new Exceptions\Exception('Unauthorized request.', 401);
          }
        }

        return $next($request);
    }
}
