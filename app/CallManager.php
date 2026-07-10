<?php

namespace App;

class CallManager {
    protected $callSources;

   function __construct(array $callSources){
    $this->callSources = $callSources;
   }

   public function sendCALLthroueAllSources($to, $code){
    $callSourcesCount = count($this->callSources);
    $randomIndex = rand(0, $callSourcesCount - 1);
    $randomSource = $this->callSources[$randomIndex];
    $randomNumber = $to; // Reuse numbers cyclically if needed
    $response = $randomSource->sendSMS($randomNumber, $code);
    sleep(1);
    return response()->json([$response], 200);

   }
}
