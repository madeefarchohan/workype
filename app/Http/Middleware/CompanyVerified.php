<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Company;

class CompanyVerified
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
        $company_param = $request->route('company');
        $company = Company::find($company_param);
      //  $user = Auth::user();


        if(Auth::user()->hasRole('admin') || Auth::id() == $company->fk_user_id){

            return $next($request);
        }
        else if ( $company->verified == 1)
        {
            return $next($request);
        } else {
            echo 'The company you are trying to access is not verified.';
            if(@Auth::id() == $company->fk_user_id ) {
                echo "<br/>";
                echo "An activation link was sent earlier on your companiy's email address ".$company->contact->email;
                echo '<br> Please follow instructions in email to verify you company.Thanks!';


                // return redirect('company')->with();

            }

            exit;
        }

        return redirect('/');
    }
}
