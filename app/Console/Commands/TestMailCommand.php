<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestMailCommand extends Command
{
    protected $signature = 'test:mail';

    protected $description = 'Command description';

    public function handle()
    {
        Mail::raw('Text to e-mail', function ($message) {
            $message->from('test@example.com');
            $message->to('test@example.com');
        });
    }
}
