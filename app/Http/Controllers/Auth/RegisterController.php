<?php


namespace App\Http\Controllers\Auth;



use App\User;
use App\Http\Controllers\Controller;
use App\VerifyUser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Mail;
use App\Mail\VerifyMail;
use Illuminate\Support\Facades\Auth;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        
        return Validator::make($data, [
            'first_name' => 'required|string|max:191',
            'last_name' => 'required|string|max:191',
            'username' => 'required|string|min:3|unique:users|regex:/^[A-Za-z0-9_]{1,15}$/',
            'email' => 'required|string|email|max:191|unique:users',
            //'Password' => 'required|string|min:6',  // | confirmed
            'Password' => 'required|string|min:6|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
            'agree' => 'required'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */


    protected function create(array $data)
    {
        $user = User::create([
            'username' => $data['username'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['Password']),
        ]);

        //
        $user->roles()->attach(2); // id only

        $verifyUser = VerifyUser::create([
            'user_id' => $user->id,
            'token' => str_random(40)
        ]);

         Mail::to($user->email)->send(new VerifyMail($user));
        return $user;
    }

    public function verifyUser($token)
    {
        
        $flag = 0;
        $verifyUser = VerifyUser::where('token', $token)->first();
        if(isset($verifyUser) ){
            $user = $verifyUser->user;
            if(!$user->verified) {
                $verifyUser->user->verified = 1;
                $verifyUser->user->save();
                $flag = 1;
                $status = "Your e-mail is verified.";
                flash('Your e-mail is verified.')->success()->important();
            }else{
                $flag = 1;
                $status = "Your e-mail is already verified.";
            }
        }else {
            return redirect('/')->with('warning', "Sorry your email cannot be identified.");

        }
        if($flag == 1) {
           if(! Auth::check()) {
               Auth::login($user);
           }


            return redirect("/company-register")->with('status', $status);
        } else {
            return redirect('/')->with('status', $status);
        }

    }

    protected function registered(Request $request, $user)
    {
        $this->guard()->logout();
        $request->session()->flash('email',$user->email);
        //return redirect('sucess')->with('email',$user->username);
        return redirect('sucess');
        //return redirect('/')->with('status', 'We sent you an activation code. Check your email and click on the link to verify.');
    }
}
