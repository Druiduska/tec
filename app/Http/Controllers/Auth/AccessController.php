<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Auth\AccessAction;
use App\Actions\Auth\AuthAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegistrationRequest;
use App\Models\Auth\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class AccessController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', []);
    }

    /**
     * Sets the start of the user's work
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function setLogin($id)
    {
        (new AccessAction($id))->onLogin();
        return response()->json(['message' => 'The logged-in user is set', 'code' => 0]);
    }

    /**
     * Sets the last user activity
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function setAccess($id)
    {
        (new AccessAction($id))->onAccess();
        return response()->json(['message' => 'The last user access is set', 'code' => 0]);
    }
}
