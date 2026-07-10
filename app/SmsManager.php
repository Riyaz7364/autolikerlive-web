<?php

namespace App;

class SmsManager {
    protected $smsSources;

   function __construct(array $smsSources){
    $this->smsSources = $smsSources;
   }

   public function sendSMSthroueAllSources($to, $code){
    $smsSourcesCount = count($this->smsSources[$code]);
    $randomIndex = rand(0, $smsSourcesCount - 1);
    $randomSource = $this->smsSources[$code][$randomIndex];
    $randomNumber = $to; // Reuse numbers cyclically if needed
    $response = $randomSource->sendSMS($randomNumber, $code);
    return response()->json([$response], 200);
   }
}
