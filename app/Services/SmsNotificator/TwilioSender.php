<?php

namespace App\Services\SmsNotificator;

use Twilio\Exceptions\ConfigurationException;
use Twilio\Exceptions\TwilioException;
use Twilio\Rest\Client;

class TwilioSender implements SmsNotificatorInterface
{

    /**
     * @param $number
     * @param $content
     * @return Client
     * @throws ConfigurationException
     * @throws TwilioException
     */
    public function sendVerifyCode($number, $content): Client
    {
        $client = new Client(env('TWILIO_SID'), env('TWILIO_TOCKEN'));
        $client->messages->create(
            '+'.$number,
            array(
                'from' => env('TWILIO_NUMBER'),
                'body' => $content
            )
        );
        return $client;
    }
}
