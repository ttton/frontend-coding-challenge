<?php

require_once 'MailHelper.php';

$mailer = new MailHelper();
$mailer->sendMail([
    'mail_to' => "ff8ba62de6@emailtests.com",
    'mail_subject' => 'EDM Mail Test - Stan coding challenge',
    'template_file_path' => "campaign/edm/index.html"
], 'mail.conf.ini');
