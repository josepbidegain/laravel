<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\Password;
use Illuminate\Mail\Message;
use Mail;
class PasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('guest');
    }

    public function getReset(){
        return view('auth.passwords.email');
    }


     /**
     * Send a email with reset link to the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postEmail(Request $request)
    {
        $this->validate($request, ['email' => 'required|email']);

        $response = \Password::sendResetLink($request->only('email'), function (Message $message) {
            $message->subject($this->getEmailSubject());
        });

        switch ($response) {
            case \Password::RESET_LINK_SENT:
                return redirect()->back()->with('status', trans($response));

            case \Password::INVALID_USER:
                return redirect()->back()->withErrors(['email' => trans($response)]);
        }
    }

    public function getEmail($token){
        return view('auth.passwords.reset',['token'=>$token]);
    }


     /**
     * Reset the given user's password.
     * Handle a POST request to reset a user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postReset(Request $request)
    {
        $this->validate($request, [
            'token' => 'required',
            'email' => 'required|email:users',
            'password' => 'required|min:3|confirmed',
        ]);

        $credentials = $request->only(
            'email', 'password', 'password_confirmation', 'token'
        );

        $response = \Password::reset($credentials, function ($user, $password) {
            $this->resetPassword($user, $password);
        });

        switch ($response) {
            case \Password::PASSWORD_RESET:
                return redirect()->back()->with('status', trans($response));
            default:
                return redirect()->back()
                            ->withInput($request->only('email'))
                            ->withErrors(['email' => trans($response)]);

        }
    }
    
}
