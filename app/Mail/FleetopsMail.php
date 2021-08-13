<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FleetopsMail extends Mailable
{
    use Queueable, SerializesModels;

    private $name = "";
    private $usertype = "";
    private $username = "";
    private $password = "";
    public function __construct($name,$usertype,$username,$password)
    {
    	$this->name = $name;
    	$this->usertype = $usertype;
    	$this->username = $username;
    	$this->password = $password;
    }

    public function build()
    {
        $from_email = env('MAIL_USERNAME');
        $url = env('APP_URL');
        $details = array();
        $details['name'] = $this->name;
        $details['usertype'] = $this->usertype;
        $details['username'] = $this->username;
        $details['password'] = $this->password;
        $details['url'] = $url;
        return $this->from($from_email)->subject("FleetOps : Account Login Information")->view('email.credentials',compact('details'));
    }
}