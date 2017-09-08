<?php

namespace Zein\Zacl\Middleware;

use Closure;
use Zein\Zacl\Lib;
use Illuminate\Contracts\Auth\Guard;
use Route;
use Zein\Zacl\Models\Permission;

class AuthorizeRoute
{
    protected $auth;
    public function __construct(Guard $auth)
    {        
        $this->auth = $auth;
    }
    public function handle($request, Closure $next, $guard = null)
    {
        $authorized     = false;  
        if ( $this->auth->check() ) {
            $user       = $this->auth->user();
        } 
        $routename = $request->route()->getName();
        if ($user->isadmin){
            $authorized = true;
        }else{
            $prefix = 'routegenerate|';
            $permissionname = $prefix.$routename;
            if($user->can($permissionname)){
                $authorized = true;
            }
        }
        if($authorized){
            return $next($request);
        }else{
            return Lib::sendError('You dont have permission in this action');
        }
        
    }
}
