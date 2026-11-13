<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Support\PromoVideos;
use Illuminate\Http\JsonResponse;

class PromoVideoController extends Controller
{
    public function show(): JsonResponse
    {
        return response()
            ->json(PromoVideos::random())
            ->header('Cache-Control', 'no-store');
    }
}
