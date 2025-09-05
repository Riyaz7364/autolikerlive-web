<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CopyPagesController extends Controller
{
    public function yolikers()
    {
        return view('copyPages.yolikers');
    }

    public function djliker()
    {
        return view('copyPages.djliker');
    }

    public function machineliker()
    {
        return view('copyPages.machineliker');
    }
}
