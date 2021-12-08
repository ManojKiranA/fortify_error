<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        Fortify::loginView(function () {
            \Log::info(  ' -22 loginView::');
            return view('auth.login', [] );
        });

        Fortify::authenticateUsing(function (Request $request) {
            \Log::info(  ' -22 authenticateUsing::');
            dd($request);
            $user = User::where('email', $request->email)->first();
            \Log::info(  varDump($user, ' -1 $user::') );
            \Log::info(  varDump($request, ' -2 $request::') );
            $request = request();
            $requestData = $request->all();

            \Log::info('-1 $requestData ::' . print_r($requestData, true));

            if ($user && Hash::check($request->password, $user->password)) {
                \Log::info('-0 $user->id ::' . print_r($user->id, true));
                \Log::info('-3 $user->status ::' . print_r($user->status, true));

                if ( $user->status === 'A') {
                    return $user;
                }
                else {
                    throw ValidationException::withMessages([
                        Fortify::username() => "Account is inactive",
                    ]);
                }

            }
        });

        Fortify::registerView(function () {
            \Log::info(  ' -33 registerView::');
            return view('auth.register', [] );
        });

        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(5)->by($request->email.$request->ip());
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });
    }
}
