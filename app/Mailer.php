<?php

namespace App;

use SimpleMail;

class Mailer
{
    public static function sendRegisterDataVerification(array $dataVerification, $email, $username)
    {
        $linkVerification = 'http://' . $_SERVER['HTTP_HOST'] . '/verification?selector=' . $dataVerification['selector'] . '&token=' . $dataVerification['token'];

        SimpleMail::make()
            ->setTo($email, $username)
            ->setSubject('Verification account')
            ->setMessage('If you are registering an account, please click the verification link ' . $linkVerification)
            ->send();
    }

}