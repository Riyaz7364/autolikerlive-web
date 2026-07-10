<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
class TradingController extends Controller
{

    protected $telegram_api_url;

    public function __construct()
    {
        $this->telegram_api_url = "https://api.telegram.org/bot6583017816:AAFnYbme09E8Y8C5_wnQNYpqJ-5XTUBtdg4/";
    }

    public function webhook(Request $request)
    {
        $update = $request->all();
        // return ($update);
        if (isset($update['message']) || isset($update['edited_message'])) {
            $this->handleMessage($update['message'] ?? $update['edited_message']);
        }

        // Get the request data
        $data = $request->all();

        // Convert the data to JSON or another format if needed
        $jsonData = json_encode($data);

        // Save the request data to storage
        Storage::disk('local')->put('requests/saveTrade_' . time() . '.json', $jsonData);
        return response('OK', 200);
    }


    public function checkOpenTrade(){
       return $trades = $this->checkTrade("21139708", "open");
        $rows = $trades['rows'];
        $openTrades = [];
        foreach ($rows as $row) {

            $date = date("".$row['date']." ".$row['openTime']."");
            $id = strtotime($date);
            $openTrades[] = [
                "id"       => $id,
                "openTime" => $row['openTime'],
                "action"   => $row['icon'],
                "symbol"   => $row['symbol'],
                "volume"   => $row['volume'],

            ];
        }

        return response()->json($openTrades);
    }

    private function checkTrade($user_id, $type){
        $api = "https://www.octafx.com/copy-trade/master/$user_id/history/$type/0/";
        return $response = Http::get($api);

        return $response->json();

    }

    protected function sendMessage($chat_id, $text)
    {
        $client = new Client();
        $client->post($this->telegram_api_url . 'sendMessage', [
            'json' => [
                'chat_id' => $chat_id,
                'text' => $text,
            ]
        ]);
    }
}
