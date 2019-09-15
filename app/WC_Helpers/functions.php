<?php
use Illuminate\Support\Facades\DB;

/**
 * Private helpers function for checked, selected, and disabled.
 *
 * Compares the first two arguments and if identical marks as $type
 *
 * @since 2.8.0
 * @access private
 *
 * @param mixed  $helper  One of the values to compare
 * @param mixed  $current (true) The other value to compare if not just true
 * @param bool   $echo    Whether to echo or just return the string
 * @param string $type    The type of checked|selected|disabled we are doing
 * @return string html attribute or empty string
 */

/*function get_company_types(){

    return $types = array(
        "PUBLIC_COMPANY"=>"Public Company",
        "EDUCATIONAL"=>"Educational Institution",
        "SELF_EMPLOYED"=>"Self-Employed",
        "GOVERNMENT_AGENCY"=>"Government Agency",
        "NON_PROFIT"=>"Nonprofit",
        "SELF_OWNED"=>"Sole Proprietorship",
        "PRIVATELY_HELD"=>"Privately Held",
        "PARTNERSHIP"=>"Partnership"
    );
}
*/

function get_site_logo(){
   /* $site_logo = \App\WC_Models\Media::where('fk_db_key','=',"site_logo")->first();
    if($site_logo)
        return $site_logo->filename;
    else
        return '';*/
}

function get_favicon(){
   /* $site_logo = \App\WC_Models\Media::where('fk_db_key','=',"favicon")->first();
    if($site_logo)
        return $site_logo->filename;
    else
        return '';
   */
}


function checked_selected_helper( $helper, $current, $echo, $type ) {
    if ( (string) $helper === (string) $current )
        $result = " $type='$type'";
    else
        $result = '';
    if ( $echo )
        echo $result;
    return $result;
}

function selected( $selected, $current = true, $echo = true ) {
    return checked_selected_helper( $selected, $current, $echo, 'selected' );
}

function disabled( $disabled, $current = true, $echo = true ) {
    return checked_selected_helper( $disabled, $current, $echo, 'disabled' );
}

function checked( $checked, $current = true, $echo = true ) {
    return checked_selected_helper( $checked, $current, $echo, 'checked' );
}

if (!function_exists('get_ini_bytes')) {
    function get_ini_bytes($val){
        $val = trim($val);
        $last = strtolower($val[strlen($val)-1]);
        switch($last) {
            // The 'G' modifier is available since PHP 5.1.0
            case 'g':
                $val = (int) $val * 1024;
            case 'm':
                $val = (int) $val * 1024;
            case 'k':
                $val = (int) $val * 1024;
        }
        return $val;
    }
}

if (!function_exists('formatBytes')) {
    function formatBytes($bytes, $precision = 2) {
        if ($bytes > pow(1024,3)) return round($bytes / pow(1024,3), $precision)."gb";
        else if ($bytes > pow(1024,2)) return round($bytes / pow(1024,2), $precision)."mb";
        else if ($bytes > 1024) return round($bytes / 1024, $precision)."kb";
        else return ($bytes)."B";
    }
}

function getAutoIncrementedID($table){
    $data = DB::select("SHOW TABLE STATUS LIKE '".$table."'");

    $data = array_map(function ($value) {
        return (array)$value;
    }, $data);

    return $data[0]['Auto_increment'];
}

function get_attachments(){
    return $attachments = array(
        'pdf'  => 'pdf',
        'doc'  => 'word',
        'ppt'  => 'powerpoint',
        'pptx' => 'powerpoint',
        'docx' => 'word',
        'jpg'  => 'image',
        'jpeg' => 'image',
        'PNG'  => 'image',
        'bmp'  => 'image',
        'gif'  => 'image',
        'xlsx' => 'excel',
        'csv'  => 'excel',
        'xls'  => 'excel',
        'txt'  => 'text',
        'zip'  => 'zip',
        'rar'  => 'zip',
    );
}

function get_months_list(){
    return $attachments = array(
        '1'  => 'January',
        '2' => 'February',
        '3'    => 'March',
        '4'    => 'April',
        '5'      => 'May',
        '6'     => 'June',
        '7'     => 'July',
        '8'   => 'August',
        '9'=> 'September',
        '10'  => 'October',
        '11' => 'November',
        '12' => 'December',
    );
}

function get_txt_max(){
    return "50";
}

function date_format_php_list($index){
    $val = "-";
    switch($index) {
        case '0':
            $val = 'Y-m-d';     // 2017-10-30
            break;
        case '1':
            $val = 'F j, Y';    // October 30, 2017
            break;
        case '2':
            $val = 'm/d/Y';     // 10/30/2017
            break;
        case '3':
            $val = 'd/m/Y';      //  30/10/2017
            break;
        case '4':
            $val = 'd-m-Y';      // 30-10-2017
            break;
        case '5':
            $val = 'd-m-Y h:i A';      // 30-10-2017
            break;
    }
    return $val;
}

function date_format_js_list(){
    return array(
    "default"       =>   "ddd mmm dd yyyy HH:MM:ss",
    "pakDate"       =>   "dd-mm-yyyy",
    "shortDate"     =>   "m/d/yy",
    "mediumDate"    =>   "mmm d, yyyy",
    "longDate"      =>   "mmmm d, yyyy",
    "fullDate"      =>   "dddd, mmmm d, yyyy",
    "shortTime"     =>   "h:MM TT",
    "mediumTime"    =>   "h:MM:ss TT",
    "longTime"      =>   "h:MM:ss TT Z",
    "isoDate"       =>   "yyyy-mm-dd",
    "isoTime"       =>   "HH:MM:ss",
    "isoDateTime"   =>   "yyyy-mm-dd'T'HH:MM:ss",
    "isoUtcDateTime"=>   "UTC:yyyy-mm-dd'T'HH:MM:ss'Z'"
    );

}

 function format_invited_user_message($message){
    $message = json_decode($message) ;

     $conversation = \App\WC_Models\Conversation::find($message->conversation_id);
     $invited_to_user_obj = \App\User::find($message->invited_to_id);
     $invited_from_user_obj = \App\User::find($message->invited_from_id);

     if($invited_to_user_obj->id == Auth::id()) {
         return "You are invited to chat with $invited_from_user_obj->first_name $invited_from_user_obj->last_name ";
     } else {
         return "$invited_to_user_obj->first_name  $invited_to_user_obj->last_name is been  invited to chat from $invited_from_user_obj->first_name $invited_from_user_obj->last_name  ";
     }

}
  function remove_user($message){
    $message = json_decode($message) ;
  //conversation search
    $conversation = \App\WC_Models\Conversation::find($message->conversation_id);
    //leave user search or find
    $invited_to_user_obj = \App\User::find($message->deleted_from_id);
    //$invited_from_user_obj = \App\User::find($message->invited_from_id);
      if($invited_to_user_obj) {
          return "$invited_to_user_obj->first_name  $invited_to_user_obj->last_name has left conversation";
      }
}


?>