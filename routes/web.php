<?php

Use Illuminate\Support\Facades\DB;




//
//$noti  = DB::table('notifications')->where('data->message_id', '3')->get();
//dd($noti);



/*
$redLovers = DB::table('notifications')
    ->where(JSON_EXTRACT('data.conversation_id'), '6')
    // SELECT * FROM notifications WHERE JSON_EXTRACT(`notifications.data`, "$.id") = 5
    ->get();
*/


// $redLovers  = DB::table('notifications')->where($data->conversation_id, '3')->get();
//
//dd($redLovers);

// https://github.com/musonza/chat#update-conversation-details


/*
$participants = [1,2];
$conversation = Chat::createConversation($participants);

$data = ['title' => 'PHP Channel', 'description' => 'PHP Channel Description'];
$conversation->update(['data' => $data]);
*/

/*
$user1 = App\User::find(1);
$user2 = App\User::find(2);

$unreadCount = Chat::for($user1)->unreadCount();
print_r($unreadCount);

*/

//
//echo $conversation->messages;

//$conversation = Chat::conversation(6);
//$user = App\User::find(1);

/*echo $unreadCount = Chat::for($user)->unreadCount();
*/

//Chat::removeParticipants($conversation, [1,2]);

// dd($user);


/*

echo $conversation->data['title'];



$users  = [$user1, $user2];

*/
/*
$messages = Chat::conversations()->for($user1)->limit(25)->page(1)->get();

echo $messages;


echo $unreadCount = Chat::for($user1)->unreadCount();



// echo $message = Chat::messageById(1);

 // $unreadCount = Chat::for($user1)->unreadCount();



print_r(Chat::commonConversations($users));

// print_r(Chat::conversations()->for($users)->limit(25)->page(1)->get());




// Chat::addParticipants($conversation, 3);

// Chat::removeParticipants($conversation, 3);

*/

/*
$message = Chat::message('Hello')
    ->from(1) // user
    ->to($conversation) // conversation
    ->send();
*/



// $user = \App\User::find(3);

/*





  */





Route::get('/', function () {
    return redirect('login');
});

Auth::routes();

Route::get('/logout', 'Auth\LoginController@logout');

// Route::get('/home', 'HomeController@index')->name('home');

Route::get('/user/verify/{token}', 'Auth\RegisterController@verifyUser');

Route::get('/password-recovered',function(){
    return view('auth.passwords.password-recovered');
});


Route::group(['middleware' => 'auth'], function() {




    Route::get('/send_email_again/{id}', 'CompanyController@send_email_again');
  Route::get('get_notifications', 'WC_Users\UsersController@get_notifications');




    Route::resource('/users', 'WC_Users\UsersController');


    Route::get('chatter','WC_Chatter\CompanyChatterController@chatter');

    Route::resource('company.chatter', 'WC_Chatter\CompanyChatterController');
    Route::get('user/chats' , 'WC_Chatter\CompanyChatterController@user_chats');
    Route::post('leave/chat' , 'WC_Chatter\CompanyChatterController@leave_chat');

    Route::resource('company.products', 'WC_Products\CompanyProductsController');

    Route::get('company/{company_id}/products/{product_id}/delete','WC_Products\CompanyProductsController@destroy');
    Route::get('company/{company_id}/products/{product_id}/media/{media_id}/delete','WC_Products\CompanyProductsController@delete_media');



    Route::resource('company.posts', 'WC_Posts\companyPostsController');


    Route::get('company/{company_id}/posts/{post_id}/delete','WC_Posts\companyPostsController@destroy');
    Route::get('company/{company_id}/posts/{post_id}/media/{media_id}/delete','WC_Posts\companyPostsController@delete_media');





    Route::resource('business-agents', 'WC_BusinessAgents\businessAgentController');

    Route::get('/home', 'CompanyController@index');

    Route::post('company/{id}/settings','CompanyController@admins');
    Route::get('company-admin/{id}','CompanyController@delete_company_admin');

    Route::get('company/{id}/send_message','WC_Chatter\CompanyChatterController@send_message');
    Route::get('company/{id}/retrieve_messages','WC_Chatter\CompanyChatterController@retrieve_messages');
    Route::post('company/{id}/invite_user_in_chat','WC_Chatter\CompanyChatterController@add_user_in_conversation');

    Route::get('/company-register', 'CompanyController@register');
    Route::resource('/company', 'CompanyController');
    Route::get('/company-delete/{id}', 'CompanyController@delete');

    Route::get('company/verify/{token}','CompanyController@verifyCompany');
    Route::get('verify-company',function(){
        return view('company_emails.verify-company');
    });
});




Route::get('/sucess',function (){
    return view('layouts.success');
});


//

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
Route::get('/email_me_smtp', function (Request $request) {

    //Load composer's autoloader
    require 'vendor/autoload.php';

    $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
    try {
        //Server settings
        $mail->SMTPDebug = 2;                                 // Enable verbose debug output
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'mbaigarid@gmail.com';                 // SMTP username
        $mail->Password = 'maryam123';                           // SMTP password
        $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 465;                                    // TCP port to connect to

        //Recipients
        $mail->setFrom('mbaigarid@gmail.com', 'Mohsin');
        $mail->addAddress('tauqeerabbas01@gmail.com', 'Tauqeer Abbas ');     // Add a recipient
        //$mail->addAddress('ellen@example.com');               // Name is optional
        //$mail->addReplyTo('info@example.com', 'Information');
        // $mail->addCC('cc@example.com');
        //$mail->addBCC('bcc@example.com');

        //Attachments
        //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

        //Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Here is the subject';
        $mail->Body    = 'This Mohsin Baig is the HTML message body <b>in bold!</b>';
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        $mail->send();
        

//        echo 'Message has been sent';
    } catch (Exception $e) {
        echo '<pre>';
        echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
        echo '</pre>';
    }
});



Route::get('/email_me_live', function (Request $request) {
    $mail = new PHPMailer();
    $mail->isMail();
    $mail->isHTML(true);
    /*$mail->From     = "support@webicosoft.com";
    $mail->FromName = "ZeeManager";*/
    $mail->setFrom('no-reply@zeemanager.com', 'ZeeManager Notification');
    $mail->Subject = "You have been added to   - ZeeManager";
    $mail->MsgHTML('hello');
    $mail->addAddress('tauqeerabbas01@gmail.com' ,'Tauqeer Abbas');
    $mail->send();

});




