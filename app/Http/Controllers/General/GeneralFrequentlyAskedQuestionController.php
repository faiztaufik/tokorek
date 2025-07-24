<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GeneralFrequentlyAskedQuestionController extends Controller
{
    public function index()
    {
        return view('general.pages.frequently-asked-question.index', [
            'title' => 'Frequently Asked Question',
        ]);
    }
}
