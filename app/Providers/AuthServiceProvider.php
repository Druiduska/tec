<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class AuthServiceProvider extends ServiceProvider {
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot () {
        $this->registerPolicies();


        VerifyEmail::toMailUsing( function ($notifiable, $url) {
            $url_array = explode( '/', $url );
            $url_array[ 2 ] = env( 'FRONT_SERVER_DOMAIN' ) . ( env( 'FRONT_SERVER_PORT' ) ? ( ':' . env( 'FRONT_SERVER_PORT' ) ) : '' );
            $front_url = implode( '/', $url_array );

            return ( new MailMessage )
                ->from( address: env( 'MAIL_FROM_ADDRESS' ), name: 'Morexod' )
                ->greeting( 'Hello' )
                ->subject( 'Verify Email Address' )
                ->line( 'Please click the button below to verify your email address on the site "Morexod."' )
                ->action( 'Verify Email Address', $front_url )
                ->view( 'mail.verification' );
        } );
        //
    }
}
