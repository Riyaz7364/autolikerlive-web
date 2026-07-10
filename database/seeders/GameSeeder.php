<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\GameLayer;
use Illuminate\Database\Seeder;

class GameSeeder extends Seeder
{
    public function run(): void
    {
        $games = [
            [
                'title' => 'Which Bollywood Star Are You?',
                'slug' => 'which-bollywood-star-are-you',
                'description' => 'Enter your Facebook profile to find out which Bollywood star matches your personality!',
                'og_title' => 'I got {randomBollywoodActor}! Find out which Bollywood star YOU are!',
                'og_description' => 'Take this fun quiz and share your result with friends!',
                'bg_color' => '#1a1a2e',
                'canvas_w' => 600,
                'canvas_h' => 700,
                'status' => 'published',
                'layers' => [
                    ['type' => 'text', 'content' => '🌟 BOLLYWOOD STAR QUIZ 🌟', 'x' => 300, 'y' => 40, 'font_size' => 32, 'font_color' => '#ffc107', 'text_align' => 'center'],
                    ['type' => 'text', 'content' => 'You are...', 'x' => 300, 'y' => 120, 'font_size' => 22, 'font_color' => '#ffffff', 'text_align' => 'center'],
                    ['type' => 'dynamic', 'method_name' => 'uppercaseName', 'x' => 300, 'y' => 180, 'font_size' => 20, 'font_color' => '#aaaaaa', 'text_align' => 'center'],
                    ['type' => 'text', 'content' => '{randomBollywoodActor}', 'x' => 300, 'y' => 260, 'font_size' => 48, 'font_color' => '#e94560', 'text_align' => 'center', 'method_name' => null],
                    ['type' => 'text', 'content' => '🔥 Star Power: {randomRating}', 'x' => 300, 'y' => 350, 'font_size' => 26, 'font_color' => '#ffc107', 'text_align' => 'center'],
                    ['type' => 'text', 'content' => 'Your Personality: {randomTrait}', 'x' => 300, 'y' => 410, 'font_size' => 22, 'font_color' => '#ffffff', 'text_align' => 'center'],
                    ['type' => 'text', 'content' => '🎬 Share this with your friends!', 'x' => 300, 'y' => 500, 'font_size' => 18, 'font_color' => '#888888', 'text_align' => 'center'],
                    ['type' => 'text', 'content' => 'Create your own at autolikerlive.com', 'x' => 300, 'y' => 550, 'font_size' => 14, 'font_color' => '#666666', 'text_align' => 'center'],
                    ['type' => 'text', 'content' => '{currentDate}', 'x' => 300, 'y' => 600, 'font_size' => 14, 'font_color' => '#555555', 'text_align' => 'center'],
                ],
            ],
            [
                'title' => 'My Facebook Superpower',
                'slug' => 'my-facebook-superpower',
                'description' => 'Discover your hidden superpower based on your Facebook profile!',
                'og_title' => 'My superpower is {randomSuperpower}! What\'s yours?',
                'og_description' => 'Find out your Facebook superpower and challenge your friends!',
                'bg_color' => '#0d0d0d',
                'canvas_w' => 600,
                'canvas_h' => 700,
                'status' => 'published',
                'layers' => [
                    ['type' => 'text', 'content' => '⚡ MY FACEBOOK SUPERPOWER ⚡', 'x' => 300, 'y' => 40, 'font_size' => 30, 'font_color' => '#00d2ff', 'text_align' => 'center'],
                    ['type' => 'dynamic', 'method_name' => 'uppercaseName', 'x' => 300, 'y' => 110, 'font_size' => 22, 'font_color' => '#888888', 'text_align' => 'center'],
                    ['type' => 'text', 'content' => 'has the power of...', 'x' => 300, 'y' => 160, 'font_size' => 20, 'font_color' => '#aaaaaa', 'text_align' => 'center'],
                    ['type' => 'text', 'content' => '{randomSuperpower}', 'x' => 300, 'y' => 240, 'font_size' => 46, 'font_color' => '#ff6b6b', 'text_align' => 'center'],
                    ['type' => 'text', 'content' => 'Personality: {randomTrait}', 'x' => 300, 'y' => 320, 'font_size' => 24, 'font_color' => '#ffd93d', 'text_align' => 'center'],
                    ['type' => 'text', 'content' => 'Power Level: {randomRating}', 'x' => 300, 'y' => 380, 'font_size' => 24, 'font_color' => '#6bcb77', 'text_align' => 'center'],
                    ['type' => 'text', 'content' => 'FB Friends: {followerCount}', 'x' => 300, 'y' => 440, 'font_size' => 20, 'font_color' => '#4d96ff', 'text_align' => 'center'],
                    ['type' => 'text', 'content' => '🎯 Tag your friends to find their superpower!', 'x' => 300, 'y' => 530, 'font_size' => 16, 'font_color' => '#888888', 'text_align' => 'center'],
                    ['type' => 'text', 'content' => 'autolikerlive.com', 'x' => 300, 'y' => 600, 'font_size' => 14, 'font_color' => '#555555', 'text_align' => 'center'],
                ],
            ],
            [
                'title' => 'My Facebook Report Card',
                'slug' => 'my-facebook-report-card',
                'description' => 'Get your personalized Facebook report card! See your rating!',
                'og_title' => 'My Facebook score is {randomRating}! Check yours!',
                'og_description' => 'Generate your Facebook report card and share with friends!',
                'bg_color' => '#2d1b69',
                'canvas_w' => 600,
                'canvas_h' => 750,
                'status' => 'published',
                'layers' => [
                    ['type' => 'text', 'content' => '📋 FACEBOOK REPORT CARD 📋', 'x' => 300, 'y' => 40, 'font_size' => 30, 'font_color' => '#ffc107', 'text_align' => 'center'],
                    ['type' => 'text', 'content' => 'Student:', 'x' => 60, 'y' => 120, 'font_size' => 22, 'font_color' => '#ffffff', 'text_align' => 'left'],
                    ['type' => 'dynamic', 'method_name' => 'uppercaseName', 'x' => 200, 'y' => 120, 'font_size' => 24, 'font_color' => '#e94560', 'text_align' => 'left'],
                    ['type' => 'text', 'content' => 'Overall Grade:', 'x' => 60, 'y' => 190, 'font_size' => 22, 'font_color' => '#ffffff', 'text_align' => 'left'],
                    ['type' => 'text', 'content' => '{randomRating}', 'x' => 300, 'y' => 190, 'font_size' => 28, 'font_color' => '#ffc107', 'text_align' => 'left'],
                    ['type' => 'text', 'content' => 'Subject: Personality', 'x' => 60, 'y' => 270, 'font_size' => 20, 'font_color' => '#cccccc', 'text_align' => 'left'],
                    ['type' => 'text', 'content' => '{randomTrait}', 'x' => 60, 'y' => 320, 'font_size' => 24, 'font_color' => '#6bcb77', 'text_align' => 'left'],
                    ['type' => 'text', 'content' => 'Subject: Social Skills', 'x' => 60, 'y' => 390, 'font_size' => 20, 'font_color' => '#cccccc', 'text_align' => 'left'],
                    ['type' => 'text', 'content' => 'Level {randomRating}', 'x' => 60, 'y' => 440, 'font_size' => 24, 'font_color' => '#4d96ff', 'text_align' => 'left'],
                    ['type' => 'text', 'content' => 'Subject: Friends Count', 'x' => 60, 'y' => 510, 'font_size' => 20, 'font_color' => '#cccccc', 'text_align' => 'left'],
                    ['type' => 'text', 'content' => '{followerCount}', 'x' => 60, 'y' => 560, 'font_size' => 24, 'font_color' => '#ff6b6b', 'text_align' => 'left'],
                    ['type' => 'text', 'content' => '📅 {currentDate}', 'x' => 300, 'y' => 650, 'font_size' => 16, 'font_color' => '#666666', 'text_align' => 'center'],
                ],
            ],
            [
                'title' => 'Which Animal Are You?',
                'slug' => 'which-animal-are-you',
                'description' => 'Find out which animal matches your Facebook personality!',
                'og_title' => 'I am a {randomTrait} Animal! What animal are you?',
                'og_description' => 'Take this quiz to discover your spirit animal!',
                'bg_color' => '#1b4332',
                'canvas_w' => 600,
                'canvas_h' => 650,
                'status' => 'published',
                'layers' => [
                    ['type' => 'text', 'content' => '🦁 WHICH ANIMAL ARE YOU? 🦁', 'x' => 300, 'y' => 40, 'font_size' => 28, 'font_color' => '#ffc107', 'text_align' => 'center'],
                    ['type' => 'dynamic', 'method_name' => 'uppercaseName', 'x' => 300, 'y' => 110, 'font_size' => 20, 'font_color' => '#aaaaaa', 'text_align' => 'center'],
                    ['type' => 'text', 'content' => 'is a...', 'x' => 300, 'y' => 160, 'font_size' => 22, 'font_color' => '#ffffff', 'text_align' => 'center'],
                    ['type' => 'text', 'content' => '🦊 {randomTrait} {randomTrait} 🐺', 'x' => 300, 'y' => 250, 'font_size' => 36, 'font_color' => '#e94560', 'text_align' => 'center'],
                    ['type' => 'text', 'content' => 'Spirit Animal Score: {randomRating}', 'x' => 300, 'y' => 340, 'font_size' => 24, 'font_color' => '#ffd93d', 'text_align' => 'center'],
                    ['type' => 'text', 'content' => 'Wild Factor: {randomRating}', 'x' => 300, 'y' => 400, 'font_size' => 22, 'font_color' => '#6bcb77', 'text_align' => 'center'],
                    ['type' => 'text', 'content' => '🐾 Tag your friends to find their animal!', 'x' => 300, 'y' => 500, 'font_size' => 16, 'font_color' => '#888888', 'text_align' => 'center'],
                    ['type' => 'text', 'content' => 'autolikerlive.com', 'x' => 300, 'y' => 560, 'font_size' => 14, 'font_color' => '#555555', 'text_align' => 'center'],
                ],
            ],
            [
                'title' => 'My Facebook Award',
                'slug' => 'my-facebook-award',
                'description' => 'Generate your personalized Facebook award certificate!',
                'og_title' => 'I won the {randomTrait} Award! Claim yours!',
                'og_description' => 'Get your Facebook award certificate and show it off!',
                'bg_color' => '#1a1a2e',
                'canvas_w' => 600,
                'canvas_h' => 700,
                'status' => 'published',
                'layers' => [
                    ['type' => 'text', 'content' => '🏆 FACEBOOK AWARD 🏆', 'x' => 300, 'y' => 40, 'font_size' => 34, 'font_color' => '#ffc107', 'text_align' => 'center'],
                    ['type' => 'text', 'content' => 'Presented to', 'x' => 300, 'y' => 110, 'font_size' => 18, 'font_color' => '#aaaaaa', 'text_align' => 'center'],
                    ['type' => 'dynamic', 'method_name' => 'uppercaseName', 'x' => 300, 'y' => 170, 'font_size' => 40, 'font_color' => '#ffffff', 'text_align' => 'center'],
                    ['type' => 'text', 'content' => 'For being outstandingly', 'x' => 300, 'y' => 240, 'font_size' => 20, 'font_color' => '#cccccc', 'text_align' => 'center'],
                    ['type' => 'text', 'content' => '{randomTrait}', 'x' => 300, 'y' => 310, 'font_size' => 48, 'font_color' => '#e94560', 'text_align' => 'center'],
                    ['type' => 'text', 'content' => '🏅 {randomRating} PERFECT SCORE', 'x' => 300, 'y' => 400, 'font_size' => 24, 'font_color' => '#ffc107', 'text_align' => 'center'],
                    ['type' => 'text', 'content' => 'Awarded on: {currentDate}', 'x' => 300, 'y' => 470, 'font_size' => 18, 'font_color' => '#888888', 'text_align' => 'center'],
                    ['type' => 'text', 'content' => 'Verified by Facebook Community', 'x' => 300, 'y' => 540, 'font_size' => 16, 'font_color' => '#666666', 'text_align' => 'center'],
                    ['type' => 'text', 'content' => 'Create yours at autolikerlive.com', 'x' => 300, 'y' => 610, 'font_size' => 14, 'font_color' => '#555555', 'text_align' => 'center'],
                ],
            ],
        ];

        foreach ($games as $data) {
            $layers = $data['layers'];
            unset($data['layers']);

            $game = Game::create($data);

            foreach ($layers as $order => $layer) {
                $layer['game_id'] = $game->id;
                $layer['sort_order'] = $order;
                $layer['visible'] = true;
                $layer['fail_behavior'] = 'show_fallback';
                $layer['fallback_text'] = 'Hello Facebook User!';
                GameLayer::create($layer);
            }
        }
    }
}
