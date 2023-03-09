<?php

namespace App\Services\SmsNotificator;

interface SmsNotificatorInterface
{

    public function sendVerifyCode($number, $content);

}
