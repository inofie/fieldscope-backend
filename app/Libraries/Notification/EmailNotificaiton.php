<?php

namespace App\Libraries\Notification;
use App\Models\MailTemplate;

class EmailNotificaiton
{
    public function __construct($template_identifier,$sender_email,$mail_params)
    {
        $this->sendMail($template_identifier,$sender_email,$mail_params);
    }

    private function sendMail($template_identifier,$sender_email,$params)
    {
        $template = MailTemplate::getByIdentifier($template_identifier);
        $mail_subject = $template->subject;
        $mail_body = $template->body;
        $mail_wildcards = explode(',', $template->wildcards);
        $to = trim($sender_email);
        $from = trim($template->from);
        if(empty($from))
            $from = Setting::getByKey('send_email')->value;

        $mail_wildcard_values = [];
        foreach($mail_wildcards as $value) {
            $value = str_replace(['[',']'],'', $value);
            $mail_wildcard_values[] = $params[$value];
        }
        $mail_body = str_replace($mail_wildcards, $mail_wildcard_values, $mail_body);
        $headers = "From: $from" . "\r\n" ;
        //$headers .= "CC: $cc";
        try {
            //$from = env('MAIL_USERNAME');
            Mail::send('emails.default_template', ['content' => $mail_body], function ($m) use ($to, $from, $mail_subject) {
                $m->from($from, env('APP_NAME'));
                $m->to($to)->subject($mail_subject);
            });
        }catch (\Exception $e){
            print $e->getMessage();
            exit;
        }
        return true;
    }
}