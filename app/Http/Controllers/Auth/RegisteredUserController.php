<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Fortify\Fortify;

class RegisteredUserController extends Controller
{
    protected $guard;

    public function __construct(StatefulGuard $guard)
    {
        $this->guard = $guard;
    }

    /**
     * Show the registration view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function create(Request $request)
    {
        return view('auth.register'); // Return the registration view directly
    }

    /**
     * Create a new registered user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Laravel\Fortify\Contracts\CreatesNewUsers  $creator
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, CreatesNewUsers $creator)
    {
        // Ensure usernames are lowercase if specified
        if (config('fortify.lowercase_usernames')) {
            $request->merge([
                Fortify::username() => Str::lower($request->{Fortify::username()}),
            ]);
        }

        // Create the new user
        // event(new Registered($user = $creator->create($request->all())));

        $user = $creator->create($request->all());


        // Log the user in after registration
        $this->guard->login($user, $request->boolean('remember'));

        // Check if email is verified
        if (! $user->hasVerifiedEmail()) {
            // If not verified, redirect to the verification notice page
            return redirect()->route('verification.notice');
        }

        // If email is verified, redirect to the login page
        return redirect()->route('login'); // Adjust this to your desired redirect after successful registration
    }
}
