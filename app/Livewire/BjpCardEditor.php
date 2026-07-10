<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Intervention\Image\Laravel\Facades\Image;

class BjpCardEditor extends Component
{
    public $fburl = 'https://facebook.com/zuck';
    public $pp_x = 50;
    public $pp_y = 80;
    public $pp_w = 250;
    public $pp_h = 250;
    public $id_x = 250;
    public $id_y = 200;
    public $id_size = 18;
    public $date_x = 250;
    public $date_y = 240;
    public $date_size = 18;

    public $previewImage = null;
    public $error = null;
    public $generated = false;

    protected $rules = [
        'fburl' => 'required|string',
        'pp_x' => 'required|integer|min:0',
        'pp_y' => 'required|integer|min:0',
        'pp_w' => 'required|integer|min:10|max:1000',
        'pp_h' => 'required|integer|min:10|max:1000',
        'id_x' => 'required|integer|min:0',
        'id_y' => 'required|integer|min:0',
        'id_size' => 'required|integer|min:6|max:200',
        'date_x' => 'required|integer|min:0',
        'date_y' => 'required|integer|min:0',
        'date_size' => 'required|integer|min:6|max:200',
    ];

    public function generatePreview()
    {
        $this->validate();

        $templatePath = storage_path('app/public/id_card_base/bjp_id_card.png');
        if (!file_exists($templatePath)) {
            $this->error = 'Card template not found at ' . $templatePath;
            return;
        }

        try {
            $id = $this->resolveFBId($this->fburl);

            $profilePicUrl = 'https://graph.fb.me/' . $id . '/picture?type=large&access_token=257931075544071%7Ca19fbd5886d2081430fe02ba9e10ca7d';

            $card = Image::read($templatePath);

            $picResponse = Http::timeout(5)->get($profilePicUrl);
            if ($picResponse->successful()) {
                $profilePic = Image::read($picResponse->body());
                $profilePic->resize((int)$this->pp_w, (int)$this->pp_h);
                $card->place($profilePic, 'top-left', (int)$this->pp_x, (int)$this->pp_y);
            }

            $fontPath = 'C:/Windows/Fonts/arialbd.ttf';
            $today = Carbon::now()->format('d/m/Y');

            $card->text($id, (int)$this->id_x, (int)$this->id_y, function ($font) {
                $font->file('C:/Windows/Fonts/arialbd.ttf');
                $font->size((int)$this->id_size);
                $font->color('#000000');
                $font->align('left');
                $font->valign('top');
            });

            $card->text($today, (int)$this->date_x, (int)$this->date_y, function ($font) {
                $font->file('C:/Windows/Fonts/arialbd.ttf');
                $font->size((int)$this->date_size);
                $font->color('#000000');
                $font->align('left');
                $font->valign('top');
            });

            $outputDir = storage_path('app/public/bjp_cards');
            if (!is_dir($outputDir)) {
                mkdir($outputDir, 0755, true);
            }

            $filename = 'preview_' . time() . '_' . uniqid() . '.png';
            $card->save($outputDir . '/' . $filename, quality: 60);

            $this->previewImage = Storage::disk('public')->url('bjp_cards/' . $filename);
            $this->error = null;
            $this->generated = true;

        } catch (\Exception $e) {
            $this->error = $e->getMessage();
        }
    }

    public function resetDefaults()
    {
        $this->fburl = 'https://facebook.com/zuck';
        $this->pp_x = 50;
        $this->pp_y = 80;
        $this->pp_w = 250;
        $this->pp_h = 250;
        $this->id_x = 250;
        $this->id_y = 200;
        $this->id_size = 18;
        $this->date_x = 250;
        $this->date_y = 240;
        $this->date_size = 18;
        $this->previewImage = null;
        $this->error = null;
        $this->generated = false;
    }

    private function resolveFBId($fburl)
    {
        if (preg_match('/^\d+$/', $fburl)) {
            return $fburl;
        }

        $host = parse_url($fburl, PHP_URL_HOST);
        if (!$host || !str_contains($host, 'facebook.com')) {
            $fburl = 'https://facebook.com/' . ltrim($fburl, '/');
            $host = 'facebook.com';
        }

        $path = parse_url($fburl, PHP_URL_PATH);
        $query = parse_url($fburl, PHP_URL_QUERY);
        $pathWithQuery = ltrim($path, '/');
        if ($query) {
            $pathWithQuery .= '?' . $query;
        }

        $data = [
            "route_urls[0]" => $pathWithQuery,
            "__user" => 0,
            "__a" => 1,
            "__comet_req" => 15,
            "lsd" => "AdRK3FtvE-Na9eIB4EB_PnSaGnk"
        ];

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://www.facebook.com/ajax/bulk-route-definitions/',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => http_build_query($data),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/x-www-form-urlencoded',
                'Cookie: datr=5zZHavZlF7LwRJeOA7nOf7jK; sb=5zZHahyZZxUCBhTb37Zy4lQb',
                "User-Agent: Mozilla/5.0 (platform; rv:geckoversion) Gecko/geckotrail Firefox/firefoxversion"
            ],
        ]);

        $response = curl_exec($curl);
        curl_close($curl);

        $source = html_entity_decode($response);
        if (preg_match('/userID":"(\d+)/', $source, $match)) {
            return $match[1];
        }
        if (preg_match('/pageID\S:\S(\d+)/', $source, $actor)) {
            return $actor[1];
        }

        return '123456789';
    }

    public function render()
    {
        return view('livewire.bjp-card-editor');
    }
}
