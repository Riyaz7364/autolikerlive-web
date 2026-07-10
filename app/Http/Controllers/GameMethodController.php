<?php

namespace App\Http\Controllers;

use App\Models\GameSession;

class GameMethodController extends Controller
{
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

    // backward-compatible aliases for old method names
    public function fbUserName(GameSession $session): string { return $this->getName($session); }
    public function fbUserId(GameSession $session): string { return $this->getID($session); }
    public function fbProfilePicUrl(GameSession $session): string { return $this->getProfilePic($session); }
    public function manualName(GameSession $session): string { return $this->getName($session); }
    public function manualUniqueId(GameSession $session): string { return $this->getID($session); }
    public function userId(GameSession $session): string { return $this->getID($session); }
}
