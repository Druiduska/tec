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

class AuthController extends Controller {
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct () {
        $this->middleware( 'auth:api', [ 'except' => [ 'login', 'registration', 'verifiedEmail' ] ] );
    }

    /**
     * @param Request $request
     * @param         $id
     * @param         $hash
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function verifiedEmail (Request $request, $id, $hash) {
        $userById = User::findOrFail( $id );
//        Проверка хэша email
        $urlRoute = URL::route( 'verification.verify', [ 'id' => $id, 'hash' => $hash, 'expires' => $request->get( 'expires' ) ] );
        if ($hash !== sha1( $userById->email )) {
            return response()->json( [ 'error' => 'Incorrect request', 'code' => 1 ], 403 );
        }
//        Проверка сигнатуры
        $Signature = hash_hmac( 'sha256', $urlRoute, env( 'APP_KEY' ) );
        if ($request->get( 'signature' ) !== $Signature) {
            return response()->json( [ 'error' => 'Incorrect request', 'code' => 2 ], 403 );
        }
//        Проверка срока годности письма со ссылкой на верификацию
//        Пока не решил как этот кусок будет работать и нужен ли он вообще...
//        $dNow = Carbon::now();
//        $dExpires = Carbon::createFromTimestamp( (integer) $request->get( 'expires' ) );
//        if ($dNow > $dExpires && $dExpires->diffInHours( $dNow ) < ( (int) env( 'DELAY_VERIFICATION' ) - 1 )) {
//            return response()->json( [ 'error' => 'Incorrect request', 'code' => 4 ], 403 );
//        }
        if (!$userById->hasVerifiedEmail()) {
            $userById->markEmailAsVerified();
            event( new Verified( $userById ) );
            return response()->json( [ 'message' => ' Successfully verification!', 'code' => 0 ] );
        }
        return response()->json( [ 'error' => 'Already verified.', 'code' => 8 ], 403 );
    }

    /**
     * Request for re-verification email
     * sending re-verification email
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function reVerificationEmail(){
        $user = auth()->user();
        $user->sendEmailVerificationNotification();
        return response()->json( [ 'message' => 'Successfully was sended re-verification email' ] );
    }

    /**
     * Get a JWT via given credentials.
     *
     * @param LoginRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function login (LoginRequest $request) {
        $credentials = $request->toArray();

        if (!$token = auth()->attempt( $credentials )) {

            return response()->json( [ 'error' => 'Unauthorized' ], 401 );
        }

        $accessAction = new AccessAction(auth()->user()->id);
        $accessAction->onLogin();

        return $this->respondWithToken( $token );
    }

    /**
     * User registration
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function registration (RegistrationRequest $request) {
        $credentials = $request->toArray();
        $userId = AuthAction::registration(
            name: $credentials[ 'name' ],
            email: $credentials[ 'email' ],
            password: $credentials[ 'password' ]
        );
        return response()->json( [ 'message' => 'Successfully registration!', 'id' => $userId] );
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me () {
        return response()->json( auth()->user() );
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout () {
        auth()->logout();
        return response()->json( [ 'message' => 'Successfully logged out' ] );
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh () {
        return $this->respondWithToken( auth()->refresh() );
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken ($token) {
        return response()->json( [
                                     'access_token' => $token,
                                     'token_type'   => 'bearer',
                                     'expires_in'   => auth()->factory()->getTTL() * 60
                                 ] );
    }
    protected function delete(){
        auth()->user()->delete();
        auth()->logout();
        return response()->json( [ 'message' => 'Successfully delete' ] );
    }
}
