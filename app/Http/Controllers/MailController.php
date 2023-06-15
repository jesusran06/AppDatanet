<?php

namespace App\Http\Controllers;

use App\Mail\WelcomeMail;
use Illuminate\Http\Request;
use App\Models\ServiceRequest;
use Illuminate\Support\Facades\Mail;


class MailController extends Controller
{
    public function send_mails(){
        $sendMail = Mail::to("pedromoreno0702@gmail.com")->send(new WelcomeMail("Pedro José Moreno"));
        /*$senders = ServiceRequest::where('approved', 1)->get();
        foreach ($senders as $s) {
            $sendMail = Mail::to($s->email)->send(new WelcomeMail($s->social_razon));
        }*/
        //
        //return $sendMail;
        //dd($senders);
    }
}
