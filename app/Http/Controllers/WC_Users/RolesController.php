<?php

namespace App\Http\Controllers\users;

use App\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // list roles here
	    $roles = Role::paginate(20);
	    return view('WC_Users.roles' , compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
	    $this->validate($request, [
		    'name' => 'required|unique:roles|max:50',
	    ]);

	    $role = new Role($request->all());
	    $role->save();
	    flash('New user role added successfully.')->success()->important();
	    return back();

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
	public function edit($id , Request $request)
	{
		if(strcmp($request->header('X-CSRF-TOKEN') , $request->session()->token()) == 0) {
			$role = Role::findOrFail($id);
			return view('WC_Settings.ajax-templates.edit-role' , compact('role'));
		}
		else{
			echo "<div class='alert alert-danger' style='margin: 20px'><strong>Exception:</strong> Token mismatch exception occured.</div>";
		}
	}

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
	public function update(Request $request, $id)
	{

		// dd(Role::findOrFail($id));
		$this->validate($request, [
			'name' => 'required|unique:roles|max:50',
		]);
		Role::findOrFail($id)->update($request->all());
		flash('User role has been updated successfully.')->success()->important();
		return back();
	}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
	    Role::whereId($id)->delete();

	    flash('User role has been deleted successfully.')->success()->important();
	    return back();
    }
}
