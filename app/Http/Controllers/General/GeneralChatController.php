<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GeneralChatController extends Controller
{
    public function index()
    {
        return view('general.pages.chat.index', [
            'title' => 'Live Chat',
        ]);
    }
}
