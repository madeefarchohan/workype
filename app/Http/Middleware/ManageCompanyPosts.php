<?php

namespace App\Http\Middleware;

use App\WC_Models\CompanyPost;
use App\Company;
use Closure;
use Illuminate\Support\Facades\Auth;

class ManageCompanyPosts
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
        $user = Auth::user();
        if(Auth::user()->hasRole('admin')){

            return $next($request);
        }
        else if ( Auth::check()  && $user->id == $company->fk_user_id)
        {
            return $next($request);
        }

        return redirect('/');
    }
}
