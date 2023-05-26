<?php

namespace App\Http\Middleware;

use App\Actions\Auth\AccessAction;
use Illuminate\Auth\Middleware\Authenticate as Middleware;


class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return 'Unauthorized' ;
        }
    }

    /**
     * @param $request
     * @param array $guards
     * @return void
     * @throws \Illuminate\Auth\AuthenticationException
     */
    protected function authenticate($request, array $guards)
    {
        parent::authenticate($request, $guards);
        $accessAction = new AccessAction(auth()->user()->id);
        $accessAction->onAccess();
    }

}
