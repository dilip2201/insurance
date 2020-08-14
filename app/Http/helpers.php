<?php
use App\User;
use Mail as MailUser;
use Carbon\Carbon;
/************************** Dilip Functions ***********************************/

function activeMenu($uri = '') {
    $active = '';
    if (Request::is(Request::segment(1) . '/' . $uri . '/*') || Request::is(Request::segment(1) . '/' . $uri) || Request::is($uri)) {
        $active = 'active';
    }
    return $active;
}

/************************** Dilip Functions end ***********************************/




function getMonthListFromDate($startdate, $enddate, $interval)
{
    $start    = new DateTime(Carbon::parse($startdate)->toDateTimeString());
    $end      = new DateTime(Carbon::parse($enddate)->toDateTimeString()); // Create a datetime object from your Carbon object
   
    $interval = DateInterval::createFromDateString($interval); // 1 month interval
     
    $period   = new DatePeriod($start, $interval, $end); // Get a set of date beetween the 2 period
   
    $months = array();

    foreach ($period as $dt) {
        $months[] = $dt->format("Y-m-d");
    }
   
    return $months;
}


/************************** Sonal Functions ***********************************/
/**
 * @param $permissions
 * @return bool
 * Added by Sonal Ramdatti
 */
function begin()
{
    \DB::beginTransaction();
}

function commit()
{
    \DB::commit();
}

function rollback()
{
    \DB::rollBack();
}
/**
 * For check permission
 */
function checkPermission($permissions)
{
    if (auth()->check()) {
        $userAccess = auth()->user()->role;
        foreach ($permissions as $key => $value) {
            if ($value == $userAccess) {
                return true;
            }
        }
        return false;
    } else {
        return false;
    }
}

/**
 * For check email is valid or not
 */
function checkValidEmail($email = ''){
    $isValid = false;
    list(,$domain) = explode('@',$email);
    $disposables = \Config::get('constants.disposables_email');
    $email = ( in_array($domain,$disposables) ? false : $email );
    if(!in_array($domain,$disposables)){
        $isValid = true; // email is valid
    }
    return $isValid;

}
/**
 * Send mail
 */
function sendmail($view, $data, $subject, $folder='admin')
{


    $receiveremail = $data['email'];
    MailUser::send($folder.'.mail.email-' . $view, array(
        'email' => $receiveremail,
        'data' => $data
    ), function ($message) use ($receiveremail, $subject) {
        $message->to($receiveremail)->subject($subject);
    });
    if (MailUser::failures()) {
        dd('failed');
    }
}
function qualification()
{
    $data = [
        '' => 'Select one',
        'B.Com' => 'B.Com',
        'B.Sc' => 'B.Sc',
        'BCA' => 'BCA',
        'MCA' => 'MCA',
        'BCA+MCA' => 'BCA+MCA',
        'BBA' => 'BBA',
        'MBA' => 'MBA',
        'BBA+MBA' => 'BBA+MBA',
        'Engineering(B.Tech)' => 'Engineering(B.Tech)',
        'Engineering(B.Tech+M.Tech)' => 'Engineering(B.Tech+M.Tech)',
        'Other' => 'Other'
    ];

    return $data;
}

function wordsToNumber($data)
    {
      // Replace all number words with an equivalent numeric value
      $data = strtr(
          $data,
          array(
              'zero' => '0',
              'a' => '1',
              'one' => '1',
              'two' => '2',
              'three' => '3',
              'four' => '4',
              'five' => '5',
              'six' => '6',
              'seven' => '7',
              'eight' => '8',
              'nine' => '9',
              'ten' => '10',
              'eleven' => '11',
              'twelve' => '12',
              'thirteen' => '13',
              'fourteen' => '14',
              'fifteen' => '15',
              'sixteen' => '16',
              'seventeen' => '17',
              'eighteen' => '18',
              'nineteen' => '19',
              'twenty' => '20',
              'thirty' => '30',
              'forty' => '40',
              'fourty' => '40', // common misspelling
              'fifty' => '50',
              'sixty' => '60',
              'seventy' => '70',
              'eighty' => '80',
              'ninety' => '90',
              'hundred' => '100',
              'thousand' => '1000',
              'million' => '1000000',
              'billion' => '1000000000',
              'and' => '',
          )
      );

      // Coerce all tokens to numbers
      $parts = array_map(
          function ($val) {
            return floatval($val);
          },
          preg_split('/[\s-]+/', $data)
      );

      $stack = new \SplStack(); //Current work stack
      $sum = 0; // Running total
      $last = null;

      foreach ($parts as $part) {
        if (!$stack->isEmpty()) {
          // We're part way through a phrase
          if ($stack->top() > $part) {
            // Decreasing step, e.g. from hundreds to ones
            if ($last >= 1000) {
              // If we drop from more than 1000 then we've finished the phrase
              $sum += $stack->pop();
              // This is the first element of a new phrase
              $stack->push($part);
            } else {
              // Drop down from less than 1000, just addition
              // e.g. "seventy one" -> "70 1" -> "70 + 1"
              $stack->push($stack->pop() + $part);
            }
          } else {
            // Increasing step, e.g ones to hundreds
            $stack->push($stack->pop() * $part);
          }
        } else {
          // This is the first element of a new phrase
          $stack->push($part);
        }

        // Store the last processed part
        $last = $part;
      }

      return $sum + $stack->pop();
    }
/************************** Sonal Functions end *******************************/


/************************** dhruv Functions ***********************************/
/************************************** Get Content of language *****************************/
function getcontentof($languageid, $contentid)
{

    $return = '';
    $content = \App\LanguageText    ::where([['language_id', $languageid], ['content_id', $contentid]])->first();
    if (!empty($content)) {
        $return = $content->text;
    }
    return $return;
}
function Getlanguages()
{
    $branchs = \App\Language::where([['activated', '1'], ['status', 'active']])->orwhere('id', 1)->get();
    return $branchs;
}
/************************** dhruv Functions end ***********************************/
function timeAgo($time_ago)
{
  $time_ago = strtotime($time_ago);
  $cur_time = time();
  $time_elapsed = $cur_time - $time_ago;
  $seconds = $time_elapsed ;
  $minutes = round($time_elapsed / 60 );
  $hours = round($time_elapsed / 3600);
  $days = round($time_elapsed / 86400 );
  $weeks = round($time_elapsed / 604800);
  $months = round($time_elapsed / 2600640 );
  $years = round($time_elapsed / 31207680 );
// Seconds
    if($seconds <= 60){
    return "just now";
    }
//Minutes
    else if($minutes <=60){
    if($minutes==1){
    return "one minute ago";
    }
    else{
    return "$minutes minutes ago";
    }
    }
//Hours
    else if($hours <=24){
    if($hours==1){
    return "an hour ago";
    }else{
    return "$hours hrs ago";
    }
    }
//Days
    else if($days <= 7){
    if($days==1){
    return "yesterday";
    }else{
    return date('d M Y',$time_ago);
    }
    }

    else{
  return date('d M Y',$time_ago);
}
}