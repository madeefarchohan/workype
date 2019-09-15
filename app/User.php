<?php

namespace App;

use App\WC_Models\ConversationUser;
use App\WC_Models\PersonalDetails;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\MailResetPasswordToken;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use App\WC_Models\Media;

class User extends Authenticatable
{
    use EntrustUserTrait; // add this trait to your user model
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name','last_name','username', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function verifyUser()
    {
        return $this->hasOne('App\VerifyUser');
    }
    /**
     * Send a password reset email to the user
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new MailResetPasswordToken($token));
    }

    public function avatar(){
        return $this->hasOne(Media::class,'fk_id')->where('wc_media.fk_db_key', '=', 'user_profile_pic');

    }

    public function contact(){
        return $this->hasOne(Contact::class,'fk_id')->where('wc_contacts.fk_db_key', '=', 'user');

    }

    public function personal_detail(){
        return $this->hasOne(PersonalDetails::class,'fk_user_id');

    }



}
