<?php
namespace App\Utilities;

use Illuminate\Support\Facades\Mail;

class MailSender{
    public function sendMail($to,$subject,$user,$token){
        $to_name = '';
        $to_email = $to;
        $data = (compact(['user','token']));
        Mail::send('emails.mail', $data, function($message) use ($to_name,$subject, $to_email) {
        $message->to($to_email, $to_name)
        ->subject($subject);
        $message->from('gest.formations@stage.pfa','Gestionnaire des Formations');

        });
    }
}
