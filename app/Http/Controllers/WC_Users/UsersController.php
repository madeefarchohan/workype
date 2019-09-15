<?php

namespace App\Http\Controllers\WC_Users;

//use App\WC_Models\ActivityStream;
use App\Contact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
//use App\Role;
use App\WC_Models\Address;
use App\WC_Models\PersonalDetails;
//use App\WC_Models\ContactDetails;
//use App\WC_Models\Department;
//use App\WC_Models\Designation;
//use App\WC_Models\EmployeeDetails;
use App\WC_Models\Media;
//use App\WC_Models\PersonalDetails;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
//use Intervention\Image\ImageManager;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\Role;
use Intervention\Image\ImageManager;
use App\Http\Controllers\WC_Chatter\CompanyChatterController;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('manage_profile', ['only' => ['edit','update']]);
        $this->middleware('admin', ['only' => ['store','index']]);
    }

    public function get_notifications()
    {
        $response = array();
        $CompanyChatterControllerObj = new CompanyChatterController();
        $user_conversations_obj = $CompanyChatterControllerObj->cur_user_conversations();
        $logged_user_obj = User::find(Auth::id());


        $logged_user_obj1 = User::find(Auth::id());
        $unread_notifications_obj = $logged_user_obj1->unreadNotifications;

        ob_start();
        ?>

            <?php if($user_conversations_obj) {
                foreach ($user_conversations_obj as $user_conversation_obj) { ?>
                    <li>
                        <a href="<?php  echo url('company')."/".$user_conversation_obj->fk_company_id."/chatter?conversation_id=".$user_conversation_obj->id ?>" >
                                <span class="photo">
                                    <img src="<?php echo config('constants.base_url')."/".config('constants.company_logo_small').@($user_conversation_obj->company)->company_image->filename?>"
                                 class="img-circle" alt=""> </span>
                            <span class="subject">
                                                                  <span class="from"> <?php echo @$user_conversation_obj->company->name ?>   </span>
                                                                    <?php /*<span class="time">Just Now </span>*/?>
                                                                    </span>
                            <span class="message">  <?php echo $user_conversation_obj->last_message();?> </span>
                        </a>
                    </li>
                <?php }
            }
          ?>


        <?php

        $response['unread_messages_count'] = count($unread_notifications_obj);
        $response['unread_messages_html'] = ob_get_clean();
        return $response;

    }






    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
	    $roles = Role::all();
        $users = User::where('verified', '=', '1')->orderBy('id','desc')->paginate(20);

        return view('WC_Users.list-users' , compact('users','roles'));
    }

	public function isAdmin() {

		return $this->hasRole('admin'); // ?? something like this! should return true or false
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
    public function store(Request $request) {

	    


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user_obj = User::find($id);

        $arr = get_countries_list();
        if(isset($user_obj->personal_detail->nationality))
        {
        if(array_key_exists($user_obj->personal_detail->nationality,$arr))
        {
            $nationality = $arr[$user_obj->personal_detail->nationality];
        }
        }
        return view('WC_Users.user-profile' , compact('user_obj','nationality'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

	    $contact_detail  = Contact::where('fk_id','=',$id)->where('fk_db_key','user')->first();
        $personal_detail = PersonalDetails::where('fk_user_id','=',$id)->first();
	    $address = Address::where(['fk_db_key' => 'user_present', 'fk_id' => $id])->first();



	    $userProfilePic = Media::where(['fk_db_key' => "user_profile_pic" , 'fk_id' => $id])->first();
	    $active_tab = (!empty(session('active_tab'))) ? session('active_tab') : "";

	    $user = User::find($id);

	    $roles = Role::all();

	    return view('WC_Users.edit-user-profile',compact('id','contact_detail','address','active_tab','userProfilePic','user','roles','personal_detail'));
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

        $user = User::find($id);
        if($user){
            $user->update($request->all());
        }


        $personal_detail = PersonalDetails::where('fk_user_id','=',$id)->first();
        if($personal_detail){

            $personal_detail->update($request->all());

            /*$user = User::find($id);
            if(Auth::user()->hasRole('admin'))
                $user->status = $request->status;
            $user->save();
            */
        }
        else {

            $request->request->add(['fk_user_id' => $id]);
            $new = new PersonalDetails($request->all());
            $new->save();

            /*$user = User::find($id);
            if(Auth::user()->hasRole('admin'))
                $user->status = $request->status;
            $user->save();*/
        }




        $contact_detail  = Contact::where('fk_id','=',$id)->where('fk_db_key','user')->first();
        if($contact_detail){
            $contact_detail->update($request->all());
        }
        else{
            $request->request->add(['fk_id' => $id]);
            $request->request->add(['fk_db_key' => 'user']);
            $new = new Contact($request->all());
            $new->save();
        }




        if(isset($request->new_password) && isset($request->confirm_password)){

            $this->validate($request, [
               // 'new_password' => 'required|min:6',
                'new_password' => 'required|string|min:6|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
                'confirm_password' => 'required|string|same:new_password|min:6|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
            ]);

            //// bcrypt passwords
            $current_password = bcrypt($request->current_password);
            $new_password = bcrypt($request->new_password);
            $confirm_password = bcrypt($request->confirm_password);
            //dd($new_password."  <br> ".$confirm_password);
            if($request->new_password != $request->confirm_password){

//                $request->session()->flash('toaster-titel','Sorry!');
//                $request->session()->flash('toaster-message','New password and confirm password doesn\'t match.');
//                $request->session()->flash('toaster-type','error');




                //flash("New password and confirm password doesn't match.")->error()->important();



                return redirect('/users/'.$id.'/edit')->with('active_tab' , $request->active_tab)->with('status',"New password and confirm password do not match .");
            }
            $user = User::find($id);
            if($user){
                if(Auth::user()->hasRole('admin')){
                    $user->password = $new_password;
                    $user->save();
                }
                else {
                    if (!Hash::check($request->current_password, $user->password)) {
//                        $request->session()->flash('toaster-title','Sorry!');
//                        $request->session()->flash('toaster-message','Current password doesn\'t match our record.');
//                        $request->session()->flash('toaster-type','error');

                        // actually commented; // flash("Current password doesn't match our record.")->error()->important();


                        //return redirect('/users/' . $id . '/edit')->with('active_tab', $request->active_tab);


                        return redirect('/users/'.$id.'/edit')->with('active_tab' , $request->active_tab)->with('status',"Current password do not match our record.");



                    }
                    $user->password = $new_password;
                    $user->save();
                }
                /*$request->session()->flash('toaster-title','Congratulations!');
                $request->session()->flash('toaster-message','Password has been changed successfully.');
                $request->session()->flash('toaster-type','success');*/
                //flash("Password has been changed successfully.")->success()->important();


              //  return redirect('/users/'.$id.'/edit')->with('active_tab' , $request->active_tab);

                return redirect('/users/'.$id.'/edit')->with('active_tab' , $request->active_tab)->with('status',"Password has been changed successfully.");

            }
           /* $request->session()->flash('toaster-title','Sorry!');
            $request->session()->flash('toaster-message','User not found.');
            $request->session()->flash('toaster-type','error');
            //flash("User not found.")->error()->important();
            return redirect('/users/'.$id.'/edit')->with('active_tab' , $request->active_tab);*/
            return redirect('/users/'.$id.'/edit')->with('active_tab' , $request->active_tab)->with('status',"User not found.");

        }



        $unique = time();
        $manager = new ImageManager();

        //Checking if he wants to remove then remove School Logo
        if ($request->existUserProfilePic == 1) {
            $mediaCheckUserProfilePic = Media::where(['fk_db_key' => "user_profile_pic", 'fk_id' => $id])->first();
            if ($mediaCheckUserProfilePic) {

                @unlink(config('constants.user_avatar') . $mediaCheckUserProfilePic->filename);
                @unlink(config('constants.user_avatar_small') . $mediaCheckUserProfilePic->filename);
                @unlink(config('constants.user_avatar_medium') . $mediaCheckUserProfilePic->filename);
                @unlink(config('constants.user_avatar_large') . $mediaCheckUserProfilePic->filename);

                $mediaCheckUserProfilePic->delete();
            }
        }

        //    Saving School Logo if exist
        if ($request->file('user_profile_pic')) {

            $nameUserProfilePic = $request->file('user_profile_pic')->getClientOriginalName();
            $nameUserProfilePic = $unique.'-'.$nameUserProfilePic;
            //  Moving Image
            $request->file('user_profile_pic')->move(config('constants.user_avatar'), $nameUserProfilePic);

            //Generating Thumbnail
            $manager->make(config('constants.user_avatar') . $nameUserProfilePic)->resize(45, 45 )->save(config('constants.user_avatar_small') . $nameUserProfilePic);
            $manager->make(config('constants.user_avatar') . $nameUserProfilePic)->resize(65, 65)->save(config('constants.user_avatar_medium'). $nameUserProfilePic);
            $manager->make(config('constants.user_avatar') . $nameUserProfilePic)->resize(200, 200)->save(config('constants.user_avatar_large') . $nameUserProfilePic);

            //saving to database
            $mediaEmployeePic = Media::where(['fk_db_key' => "user_profile_pic", 'fk_id' => $id])->first();
            if ($mediaEmployeePic) {

                @unlink(config('constants.user_avatar') . $mediaCheckUserProfilePic->filename);
                @unlink(config('constants.user_avatar_small') . $mediaCheckUserProfilePic->filename);
                @unlink(config('constants.user_avatar_medium') . $mediaCheckUserProfilePic->filename);
                @unlink(config('constants.user_avatar_large') . $mediaCheckUserProfilePic->filename);


                $mediaEmployeePic->filename = $nameUserProfilePic;
                $mediaEmployeePic->type     = $request->file('user_profile_pic')->getClientOriginalExtension();
                $mediaEmployeePic->size     = $request->file('user_profile_pic')->getClientSize();
                $mediaEmployeePic->save();

            }
            else {

                $mediaNewEmployeePic            = new Media();
                $mediaNewEmployeePic->fk_db_key = "user_profile_pic";
                $mediaNewEmployeePic->fk_by_id  = Auth::id();
                $mediaNewEmployeePic->fk_id     = $id;
                $mediaNewEmployeePic->filename  = $nameUserProfilePic;
                $mediaNewEmployeePic->type      = $request->file('user_profile_pic')->getClientOriginalExtension();
                $mediaNewEmployeePic->size      = $request->file('user_profile_pic')->getClientSize();

                $mediaNewEmployeePic->save();
            }
        }



        return back()->with('active_tab' , $request->active_tab)->with('status','user information has been updated successfully.');




















	    if(isset($request->submit_Personal_detail)){


	    }





	    if(isset($request->submit_user_profile_pic)) {

		    $unique = time();
		    $manager = new ImageManager();

		    //Checking if he wants to remove then remove School Logo
		    if ($request->existEmployeePic == 1) {
			    $mediaCheckUserProfilePic = Media::where(['fk_db_key' => "user_profile_pic", 'fk_id' => $id])->first();
			    if ($mediaCheckUserProfilePic) {

				    @unlink(('uploads/employee-profile/' . $mediaCheckUserProfilePic->filename));
				    @unlink(('uploads/employee-profile/small/' . $mediaCheckUserProfilePic->filename));
				    @unlink(('uploads/employee-profile/medium/' . $mediaCheckUserProfilePic->filename));
				    @unlink(('uploads/employee-profile/large/' . $mediaCheckUserProfilePic->filename));

				    $mediaCheckUserProfilePic->delete();
			    }
		    }

		    //    Saving School Logo if exist
		    if ($request->file('user_profile_pic')) {

			    $nameUserProfilePic = $request->file('user_profile_pic')->getClientOriginalName();
			    $nameUserProfilePic = $unique.'-'.$nameUserProfilePic;
			    //  Moving Image
			    $request->file('user_profile_pic')->move('uploads/employee-profile/', $nameUserProfilePic);

			    //Generating Thumbnail
			    $manager->make('uploads/employee-profile/' . $nameUserProfilePic)->resize(45, 45 )->save('uploads/employee-profile/small/' . $nameUserProfilePic);
			    $manager->make('uploads/employee-profile/' . $nameUserProfilePic)->resize(65, 65)->save('uploads/employee-profile/medium/' . $nameUserProfilePic);
			    $manager->make('uploads/employee-profile/' . $nameUserProfilePic)->resize(200, 200)->save('uploads/employee-profile/large/' . $nameUserProfilePic);

			    //saving to database
			    $mediaEmployeePic = Media::where(['fk_db_key' => "user_profile_pic", 'fk_id' => $id])->first();
			    if ($mediaEmployeePic) {

				    @unlink(('uploads/employee-profile/' . $mediaEmployeePic->filename));
				    @unlink(('uploads/employee-profile/small/' . $mediaEmployeePic->filename));
				    @unlink(('uploads/employee-profile/medium/' . $mediaEmployeePic->filename));
				    @unlink(('uploads/employee-profile/large/' . $mediaEmployeePic->filename));

				    $mediaEmployeePic->filename = $nameUserProfilePic;
				    $mediaEmployeePic->type     = $request->file('user_profile_pic')->getClientOriginalExtension();
				    $mediaEmployeePic->size     = $request->file('user_profile_pic')->getClientSize();
				    $mediaEmployeePic->save();

			    }
			    else {

				    $mediaNewEmployeePic            = new Media();
				    $mediaNewEmployeePic->fk_db_key = "user_profile_pic";
				    $mediaNewEmployeePic->fk_by_id  = "1";
				    $mediaNewEmployeePic->fk_id     = $id;
				    $mediaNewEmployeePic->filename  = $nameUserProfilePic;
				    $mediaNewEmployeePic->type      = $request->file('user_profile_pic')->getClientOriginalExtension();
				    $mediaNewEmployeePic->size      = $request->file('user_profile_pic')->getClientSize();

				    $mediaNewEmployeePic->save();
			    }
		    }
	    }

	    if(isset($request->new_password) && isset($request->confirm_password)){

            $this->validate($request, [
                'new_password' => 'required|min:3',
            ]);

            //// bcrypt passwords
            $current_password = bcrypt($request->current_password);
            $new_password = bcrypt($request->new_password);
            $confirm_password = bcrypt($request->confirm_password);
            //dd($new_password."  <br> ".$confirm_password);
            if($request->new_password != $request->confirm_password){
                $request->session()->flash('toaster-titel','Sorry!');
                $request->session()->flash('toaster-message','New password and confirm password doesn\'t match.');
                $request->session()->flash('toaster-type','error');
                //flash("New password and confirm password doesn't match.")->error()->important();
                return redirect('/users/'.$id.'/edit')->with('active_tab' , $request->active_tab);
            }
	        $user = User::find($id);
	        if($user){
	            if(Auth::user()->hasRole('admin')){
                    $user->password = $new_password;
                    $user->save();
                }
                else {
                    if (!Hash::check($request->current_password, $user->password)) {
                        $request->session()->flash('toaster-title','Sorry!');
                        $request->session()->flash('toaster-message','Current password doesn\'t match our record.');
                        $request->session()->flash('toaster-type','error');
                        //flash("Current password doesn't match our record.")->error()->important();
                        return redirect('/users/' . $id . '/edit')->with('active_tab', $request->active_tab);
                    }
                    $user->password = $new_password;
                    $user->save();
                }
                $request->session()->flash('toaster-title','Congratulations!');
                $request->session()->flash('toaster-message','Password has been changed successfully.');
                $request->session()->flash('toaster-type','success');
                //flash("Password has been changed successfully.")->success()->important();
                return redirect('/users/'.$id.'/edit')->with('active_tab' , $request->active_tab);
            }
            $request->session()->flash('toaster-title','Sorry!');
            $request->session()->flash('toaster-message','User not found.');
            $request->session()->flash('toaster-type','error');
            //flash("User not found.")->error()->important();
            return redirect('/users/'.$id.'/edit')->with('active_tab' , $request->active_tab);
        }


        $request->session()->flash('toaster-title','Congratulations!');
        $request->session()->flash('toaster-message','User detail has been updated successfully.');
        $request->session()->flash('toaster-type','success');
        //flash('Employee Detail has been updated successfully.')->success()->important();
        return redirect('/users/'.$id.'/edit')->with('active_tab' , $request->active_tab);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,Request $request)
    {
        $user = User::find($id);
        if($user){
            $user->status = 0;
            $user->save();
            $request->session()->flash('toaster-title','Congratulations!');
            $request->session()->flash('toaster-message','User has been deleted successfully.');
            $request->session()->flash('toaster-type','success');
            //flash('User has been deleted Successfully.')->success()->important();
        }
        else{
            $request->session()->flash('toaster-title','Sorry!');
            $request->session()->flash('toaster-message','User not found.');
            $request->session()->flash('toaster-type','error');
            //flash('User not found.')->success()->important();
        }
        return back();
    }

    private function send_mail($user,$password){

        try{

            $sender_name = Auth::user()->personal_detail->full_name;
            $user_name = $user->personal_detail->full_name;

            // live server
            $mail = new PHPMailer();
            $mail->isMail();
           /* $mail->From     = "support@webicosoft.com";
            $mail->FromName = option('logo_text');*/
            $mail->setFrom('no-reply@zeemanager.com', 'ZeeManager Notification');
            $mail->Subject = $sender_name." invited you to join ".option('site_title')." - ZeeManager";
            $mail->MsgHTML('Hello '.$user_name.',
                    <br><br>
                    We would like to inform you that '.$sender_name.' invited you to join '.option('site_title').' – ZeeManager (Online Project Management System) as his/her team member. Please click link below to accept invited request:
                    <br><br><a href="webicosoft.zeemanager.com" target="_blank">webicosoft.zeemanager.com</a>
                    <br><br>Refer below your login credentials:
                    <br><br>URL: <a href="webicosoft.zeemanager.com" target="_blank">http://webicosoft.zeemanager.com</a>
                    <br><br>Username: '.$user->username.'
                    <br><br>Email: '.$user->email.'
                    <br><br>Password: '.$password.'
                    <br><br>Please make sure to change your password and fill the profile after activating and login.
                    <br><br>-----------------------------------------------------------------------
                    <br>This is an automated message, please don’t reply it.
                    <br><br>Sincerely,
                    <br>'.option('site_title').' - ZeeManager,
                    <br><a href="webicosoft.zeemanager.com" target="_blank">http://webicosoft.zeemanager.com</a>'
            );
            $mail->addAddress($user->email ,$user->personal_detail->full_name);
            $mail->send();
            return;



            // SMTP if you are using on local server, also fill below password field for your smtp

            /*$mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->CharSet =  'utf-8';
            $mail->SMTPAuth = true; #set it true
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
            $mail->Host = 'smtp.gmail.com'; #gmail has host  smtp.gmail.com
            $mail->Port = 587; #gmail has port  587 . without double quotes
            $mail->Username = 'abwaraich10@gmail.com'; #your username. actually your email
            $mail->Password = ''; # your password. your mail password
            $mail->setFrom('no-reply@zeemanager.com', 'ZeeManager Notification');
            $mail->Subject = $sender_name." invited you to join ".option('site_title')." - ZeeManager";
            $mail->MsgHTML('Hello '.$user_name.',
                    <br><br>
                    We would like to inform you that '.$sender_name.' invited you to join '.option('site_title').' – ZeeManager (Online Project Management System) as his/her team member. Please click link below to accept invited request:
                    <br><br><a href="webicosoft.zeemanager.com" target="_blank">webicosoft.zeemanager.com</a>
                    <br><br>Refer below your login credentials:
                    <br><br>URL: <a href="webicosoft.zeemanager.com" target="_blank">http://webicosoft.zeemanager.com</a>
                    <br><br>Username: '.$user->username.'
                    <br><br>Email: '.$user->email.'
                    <br><br>Password: '.$password.'
                    <br><br>Please make sure to change your password and fill the profile after activating and login.
                    <br><br>-----------------------------------------------------------------------
                    <br>This is an automated message, please don’t reply it.
                    <br><br>Sincerely,
                    <br>'.option('site_title').' - ZeeManager,
                    <br><a href="webicosoft.zeemanager.com" target="_blank">http://webicosoft.zeemanager.com</a>'
            );
            $mail->addAddress($user->email ,$user->personal_detail->full_name);
            $mail->send();

            return;*/



        }catch(phpmailerException $e){
            dd($e);
        }catch(Exception $e){
            dd($e);
        }
    }

    public function get_all_users(Request $request){
        $id = $request->id;
        $users = User::where('status','=','1')->with('personal_detail','employee_detail.designation')->get();
        return view('WC_Users.template-requests.users-select2',compact('users','id'));
    }

    public function get_user_dept_desi(Request $request){
        if($request->department != 0 && $request->designation == 0) {
            $users = User::where('status', '=', '1')->with('personal_detail')
                ->whereHas('employee_detail',function ($q) use( $request){
                    $q->whereHas('department', function ($q) use ($request) {
                        $q->where('id', $request->department);
                    });
                })->get();
        }
        else if($request->department == 0 && $request->designation != 0) {
            $users = User::where('status', '=', '1')->with('personal_detail')
                ->whereHas('employee_detail',function ($q) use( $request){
                    $q->whereHas('designation', function ($q) use ($request) {
                        $q->where('id', $request->designation);
                    });
                })->get();
        }
        else if($request->department != 0 && $request->designation != 0) {
            $users = User::where('status', '=', '1')->with('personal_detail')
                ->whereHas('employee_detail',function ($q) use( $request){
                    $q->whereHas('department', function ($q) use ($request) {
                        $q->where('id', $request->department);
                    })->whereHas('designation', function ($q) use ($request) {
                            $q->where('id', $request->designation);
                        });
                })->get();
        }

        return json_encode([
           'users' => $users,
           'employee' => $request->select_employee
        ]);
    }
}
