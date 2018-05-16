<?php
use App\Domain;
use App\Ticket;
use App\Log;
use App\User;
use App\Plan;

function apostropheS($name) {
    $ext = (substr($name, -1) == 's') ? "'" : "'s";
    return $name . $ext;
}

function gravatar($email, $size=null) {
    if($size == null) {
        $size = 40;
    }
    $grav_url = "http://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) . "?s=" . $size;

    $gravatar = '<img src="'.$grav_url.'" alt="" />';

    return $gravatar;

}

function getDomainName($id)
{
    $domain = Domain::find($id);
    return ($domain) ? str_replace('http://www.','',$domain->domain) : '';
}

function getUserEmail($id)
{
    $user = User::find($id);
    return $user->email;
}

function holler_status($id, $agent_email)
{
    $last_log = Log::where('ticket_id',$id)->orderBy('created_at','desc')->first();
    $status = 'You';
    if($last_log) {
        if($last_log->external_email == $agent_email) {
            $status = 'Them';
        }
    }
    return $status;
}

function trim_gumpf($str)
{
    $param = '<p>//================== Reply above this line ==================//</p>';
    $pos = strpos($str, $param);
    $newStr = substr($str,0,$pos);
    $newStr = strip_tags($newStr);
    $newStr=preg_replace('~On(.*?)wrote:(.*?)$~si', '', $newStr);
    return $newStr;
}

function flash($title = null, $message = null)
{
    $flash = app('App\Http\Flash');

    if (func_num_args() == 0) {
        return $flash;
    }

    return $flash->info($title, $message);
}

function team_member_count()
{
    $members = User::where('team_id',Auth::user()->id)->get();
    $num_members = count($members);
    $plan = Plan::find(Auth::user()->stripe_plan);
    return '('.$num_members.'/'.$plan->num_agents.')';
}

function domain_count()
{
    $domains = Domain::where('user_id',Auth::user()->id)->get();
    $num_domains = count($domains);
    $plan = Plan::find(Auth::user()->stripe_plan);
    return '('.$num_domains.'/'.$plan->num_domains.')';
}

function optimus_primary($primary, $id)
{
    $html = '<a href="#" id="'.$id.'" class="make_primary">Set as primary</a>';
    if($primary == 1)
    {
        $html = '<span class="label label-success">Primary</span>';
    }
    return $html;
}
