<?php

namespace App\Http\Controllers;

use App\Models\GameSession;
use App\Services\AiGameService;

use Carbon\Carbon;
use App\Models\Game;
use Illuminate\Support\Facades\Storage;
use App\Models\GameLayer;
use App\Models\GameAiField;
class GameMethodController extends Controller
{
    protected AiGameService $aiGame;

    public function __construct(AiGameService $aiGame)
    {
        $this->aiGame = $aiGame;
    }
    // BS Calendar data: days in each month for BS years 2000-2090
    private static array $bsMonthDays = [
        2000 => [30, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31],
        2001 => [31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        2002 => [31, 31, 32, 32, 31, 30, 30, 29, 30, 29, 30, 30],
        2003 => [31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31],
        2004 => [30, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31],
        2005 => [31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        2006 => [31, 31, 32, 31, 32, 30, 30, 29, 30, 29, 30, 30],
        2007 => [31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31],
        2008 => [31, 31, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31],
        2009 => [31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        2010 => [31, 31, 32, 32, 31, 30, 30, 29, 30, 29, 30, 30],
        2011 => [31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31],
        2012 => [31, 31, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31],
        2013 => [31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        2014 => [31, 31, 32, 31, 32, 30, 30, 29, 30, 29, 30, 30],
        2015 => [31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31],
        2016 => [31, 31, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31],
        2017 => [31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        2018 => [31, 32, 31, 32, 31, 30, 30, 29, 30, 29, 30, 30],
        2019 => [31, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31],
        2020 => [31, 31, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31],
        2021 => [31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        2022 => [31, 32, 31, 32, 31, 30, 30, 29, 30, 29, 30, 30],
        2023 => [31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31],
        2024 => [31, 31, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31],
        2025 => [31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        2026 => [31, 32, 31, 32, 31, 30, 30, 29, 30, 29, 30, 30],
        2027 => [31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31],
        2028 => [31, 31, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31],
        2029 => [31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        2030 => [31, 32, 31, 32, 31, 30, 30, 29, 30, 29, 30, 30],
        2031 => [31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31],
        2032 => [30, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31],
        2033 => [31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        2034 => [31, 31, 32, 31, 32, 30, 30, 29, 30, 29, 30, 30],
        2035 => [31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31],
        2036 => [30, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31],
        2037 => [31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        2038 => [31, 31, 32, 32, 31, 30, 30, 29, 30, 29, 30, 30],
        2039 => [31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31],
        2040 => [31, 31, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31],
        2041 => [31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        2042 => [31, 32, 31, 32, 31, 30, 30, 29, 30, 29, 30, 30],
        2043 => [31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31],
        2044 => [31, 31, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31],
        2045 => [31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        2046 => [31, 32, 31, 32, 31, 30, 30, 29, 30, 29, 30, 30],
        2047 => [31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31],
        2048 => [31, 31, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31],
        2049 => [31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        2050 => [31, 32, 31, 32, 31, 30, 30, 29, 30, 29, 30, 30],
        2051 => [31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31],
        2052 => [31, 31, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31],
        2053 => [31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        2054 => [31, 32, 31, 32, 31, 30, 30, 29, 30, 29, 30, 30],
        2055 => [31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31],
        2056 => [31, 31, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31],
        2057 => [31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        2058 => [31, 32, 31, 32, 31, 30, 30, 29, 30, 29, 30, 30],
        2059 => [31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31],
        2060 => [30, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31],
        2061 => [31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        2062 => [31, 31, 32, 31, 32, 30, 30, 29, 30, 29, 30, 30],
        2063 => [31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31],
        2064 => [30, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31],
        2065 => [31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        2066 => [31, 31, 32, 32, 31, 30, 30, 29, 30, 29, 30, 30],
        2067 => [31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31],
        2068 => [31, 31, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31],
        2069 => [31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        2070 => [31, 32, 31, 32, 31, 30, 30, 29, 30, 29, 30, 30],
        2071 => [31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31],
        2072 => [31, 31, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31],
        2073 => [31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        2074 => [31, 32, 31, 32, 31, 30, 30, 29, 30, 29, 30, 30],
        2075 => [31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31],
        2076 => [31, 31, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31],
        2077 => [31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        2078 => [31, 32, 31, 32, 31, 30, 30, 29, 30, 29, 30, 30],
        2079 => [31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31],
        2080 => [31, 31, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31],
        2081 => [31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        2082 => [31, 32, 31, 32, 31, 30, 30, 29, 30, 29, 30, 30],
        2083 => [31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31],
        2084 => [30, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31],
        2085 => [31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        2086 => [31, 31, 32, 31, 32, 30, 30, 29, 30, 29, 30, 30],
        2087 => [31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31],
        2088 => [30, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31],
        2089 => [31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30],
        2090 => [31, 31, 32, 31, 32, 30, 30, 29, 30, 29, 30, 30],
    ];

    public function getName(GameSession $session): string
    {
        return $session->name ?? $session->username;
    }

    public function getUsername(GameSession $session): string
    {
        return $session->username;
    }

    public function getID(GameSession $session): string
    {
        return $session->id;
    }

    public function getProfilePic(GameSession $session): string
    {
        return $session->profile_pic ?? '';
    }

    public function currentDate(GameSession $session): string
    {
        return now()->format('d/m/Y');
    }

    public function currentTime(GameSession $session): string
    {
        return now()->format('h:i A');
    }

    public function randomQuote(GameSession $session): string
    {
        $quotes = [
            'The best way to predict the future is to create it.',
            'Success is not final, failure is not fatal.',
            'Be the change you wish to see in the world.',
            'Dream big. Work hard. Stay focused.',
            'Every moment is a fresh beginning.',
        ];
        return $quotes[array_rand($quotes)];
    }

    public function uppercaseName(GameSession $session): string
    {
        return strtoupper($session->name);
    }

    public function randomRating(GameSession $session): string
    {
        return rand(70, 100) . '%';
    }

    public function randomNumber(GameSession $session): string
    {
        return (string) rand(1000, 9999);
    }

    public function currentDateBS(GameSession $session): string
    {
        $now = \Carbon\Carbon::now();
        return $this->convertToBS($now->format('Y-m-d'));
    }


    private function convertToBS(string $adDate): string
    {
        $ad = \Carbon\Carbon::parse($adDate);
        $adYear = (int) $ad->format('Y');
        $adMonth = (int) $ad->format('m');
        $adDay = (int) $ad->format('d');

        // Reference: BS 2000-01-01 = AD 1943-04-14
        $bsYear = 2000;
        $bsMonth = 1;
        $bsDay = 1;

        // Convert AD date to total days since 1943-04-14
        $baseAD = \Carbon\Carbon::create(1943, 4, 14);
        $totalDays = (int) $ad->diffInDays($baseAD);

        // Forward: count BS days
        while ($totalDays > 0 && $bsYear <= 2090) {
            $monthDays = self::$bsMonthDays[$bsYear][$bsMonth - 1] ?? 30;
            if ($totalDays >= $monthDays) {
                $totalDays -= $monthDays;
                $bsMonth++;
                if ($bsMonth > 12) {
                    $bsMonth = 1;
                    $bsYear++;
                }
            } else {
                $bsDay += $totalDays;
                $totalDays = 0;
            }
        }

        return sprintf('%02d/%02d/%d', $bsDay, $bsMonth, $bsYear);
    }

    public function getZodiacWithIcon($dob): string | null
    {
        $date = date('m-d', strtotime($dob));

        $zodiacs = [
            ['name' => 'capricorn', 'start' => '12-22', 'end' => '01-19'],
            ['name' => 'aquarius', 'start' => '01-20', 'end' => '02-18'],
            ['name' => 'pisces', 'start' => '02-19', 'end' => '03-20'],
            ['name' => 'aries', 'start' => '03-21', 'end' => '04-19'],
            ['name' => 'taurus', 'start' => '04-20', 'end' => '05-20'],
            ['name' => 'gemini', 'start' => '05-21', 'end' => '06-20'],
            ['name' => 'cancer', 'start' => '06-21', 'end' => '07-22'],
            ['name' => 'leo', 'start' => '07-23', 'end' => '08-22'],
            ['name' => 'virgo', 'start' => '08-23', 'end' => '09-22'],
            ['name' => 'libra', 'start' => '09-23', 'end' => '10-22'],
            ['name' => 'scorpio', 'start' => '10-23', 'end' => '11-21'],
            ['name' => 'sagittarius', 'start' => '11-22', 'end' => '12-21'],
        ];

        foreach ($zodiacs as $zodiac) {

            if ($zodiac['name'] == 'capricorn') {
                if ($date >= '12-22' || $date <= '01-19') {
                    return "https://api.iconify.design/fluent-emoji-flat/{$zodiac['name']}.svg";
                }
            } else {
                if ($date >= $zodiac['start'] && $date <= $zodiac['end']) {
                    return 
                        "https://api.iconify.design/fluent-emoji-flat/{$zodiac['name']}.svg";
                }
            }
        }

        return null;
    }



    // backward-compatible aliases for old method names
    public function fbUserName(GameSession $session): string { return $this->getName($session); }
    public function fbUserId(GameSession $session): string { return $this->getID($session); }
    public function fbProfilePicUrl(GameSession $session): string { return $this->getProfilePic($session); }
    public function manualName(GameSession $session): string { return $this->getName($session); }
    public function manualUniqueId(GameSession $session): string { return $this->getID($session); }
    public function userId(GameSession $session): string { return $this->getID($session); }
}
