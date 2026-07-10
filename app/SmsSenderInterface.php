<?php

namespace App;

interface SmsSenderInterface {
    public function sendSMS($to, $code);
}
