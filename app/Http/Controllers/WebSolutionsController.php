<?php

namespace App\Http\Controllers;

use App\Models\DemoLead;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class WebSolutionsController extends Controller
{
    public function index(): View
    {
        return view('web-solutions', [
            'projects' => $this->projects(),
        ]);
    }

    public function store(Request $request): JsonResponse|RedirectResponse
    {
        if ($request->filled('website')) {
            return $this->success($request, 'Thanks! Your message has been received.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:190'],
            'phone' => ['nullable', 'string', 'max:40'],
            'company' => ['nullable', 'string', 'max:190'],
            'project_type' => ['nullable', 'string', 'max:80'],
            'budget' => ['nullable', 'string', 'max:80'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        $lead = DemoLead::create([
            ...$validated,
            'source' => 'web-solutions',
            'status' => 'new',
            'ip_address' => $request->ip(),
            'user_agent' => Str::limit((string) $request->userAgent(), 1000),
        ]);

        $message = 'Thanks, '.$lead->name.'! Your project enquiry has been received. I will get back to you within 24 hours.';

        if ($request->expectsJson()) {
            return response()->json([
                'message' => $message,
                'id' => $lead->id,
            ], 201);
        }

        return redirect()
            ->to(route('web-solutions').'#contact-form')
            ->with('lead_success', $message);
    }

    private function success(Request $request, string $message): JsonResponse|RedirectResponse
    {
        if ($request->expectsJson()) {
            return response()->json(['message' => $message]);
        }

        return redirect()->to(route('web-solutions').'#contact-form')->with('lead_success', $message);
    }

    private function projects(): array
    {
        return [
            [
                'name' => 'GymSaaS',
                'type' => 'SaaS platform',
                'description' => 'Multi-tenant gym management SaaS with Razorpay subscriptions, linked accounts, invoicing, and automated 100% owner transfers.',
                'tags' => ['Laravel 11', 'Razorpay', 'MySQL'],
                'url' => 'https://github.com/Riyaz7364/gymsaas',
                'link_label' => 'View repository',
            ],
            [
                'name' => 'GrowNext',
                'type' => 'HR & attendance app',
                'description' => 'Flutter employee onboarding and attendance app with a native bridge inside an existing company website.',
                'tags' => ['Flutter', 'Firebase', 'WebView'],
                'url' => 'https://github.com/Riyaz7364/GrowNext-app',
                'link_label' => 'View repository',
            ],
            [
                'name' => 'Chatter',
                'type' => 'Realtime chat app',
                'description' => 'One-to-one chat app with Firebase Auth, Firestore messaging, media sharing, and push notifications.',
                'tags' => ['Flutter', 'Firebase', 'GetX'],
                'url' => 'https://github.com/Riyaz7364/chatter',
                'link_label' => 'View repository',
            ],
            [
                'name' => 'UniMeal',
                'type' => 'AI diet planner',
                'description' => 'AI-powered diet planning app with personalized plans, multi-language support, and cached API content.',
                'tags' => ['Flutter', 'AI', 'GetX'],
                'url' => 'https://github.com/Riyaz7364/ai-diet-plan',
                'link_label' => 'View repository',
            ],
            [
                'name' => 'Puzzle Block',
                'type' => 'Mobile game',
                'description' => 'A 10x10 block puzzle game with drag-and-drop pieces, smooth animations, and endless replay value.',
                'tags' => ['Flutter', 'GetX', 'Game'],
                'url' => 'https://github.com/Riyaz7364/puzzle-block-game-flutter',
                'link_label' => 'View repository',
                'secondary_url' => 'https://play.google.com/store/apps/details?id=com.blockpuzzle.govasila',
                'secondary_label' => 'Google Play',
            ],
            [
                'name' => 'Temp Mail',
                'type' => 'Android utility',
                'description' => 'Disposable email app for Android with a temporary inbox, one-tap address copy, and quick inbox refresh.',
                'tags' => ['Android', 'Email', 'Privacy'],
                'url' => 'https://play.google.com/store/apps/details?id=com.tempmail.autolikerlive',
                'link_label' => 'Google Play',
            ],
            [
                'name' => 'RajeLiker',
                'type' => 'Social media app',
                'description' => 'Official RajeLiker Android app for Facebook auto likes and social growth tools.',
                'tags' => ['Android', 'Facebook', 'Social'],
                'url' => 'https://play.google.com/store/apps/details?id=com.rajeliker',
                'link_label' => 'Google Play',
            ],
            [
                'name' => 'Starlight Travels',
                'type' => 'Travel agency website',
                'description' => 'Corporate and premium travel agency site for a Canada-based team trusted since 1984.',
                'tags' => ['Website', 'Travel', 'Corporate'],
                'url' => 'https://starlighttravels.ca/',
                'link_label' => 'Visit website',
            ],
            [
                'name' => 'ReelSwipe',
                'type' => 'Streaming website',
                'description' => 'Short-drama streaming site for watching free short dramas online.',
                'tags' => ['Website', 'Streaming', 'Entertainment'],
                'url' => 'https://reelswipe.xyz/',
                'link_label' => 'Visit website',
            ],
            [
                'name' => 'NetFares',
                'type' => 'B2B travel platform',
                'description' => 'Wholesale airfare website for travel agents in Canada.',
                'tags' => ['Website', 'Travel', 'B2B'],
                'url' => 'https://netfares.ca/',
                'link_label' => 'Visit website',
            ],
            [
                'name' => 'Crime India Live',
                'type' => 'News portal',
                'description' => 'News publishing site covering breaking news, current affairs, and trending stories.',
                'tags' => ['Website', 'News', 'Publishing'],
                'url' => 'https://crimeindialive.com/',
                'link_label' => 'Visit website',
            ],
            [
                'name' => 'Fourine',
                'type' => 'Manufacturing website',
                'description' => 'T-shirt manufacturing site in Delhi serving clothing brands with custom production.',
                'tags' => ['Website', 'Manufacturing', 'B2B'],
                'url' => 'https://fourine.com/',
                'link_label' => 'Visit website',
            ],
        ];
    }
}
