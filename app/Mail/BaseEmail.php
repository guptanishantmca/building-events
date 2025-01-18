<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class BaseEmail extends Mailable
{
    public function __construct()
    {
        $this->from(config('mail.from.address'), config('mail.from.name'));
    }
}
