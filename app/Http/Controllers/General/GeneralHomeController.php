<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GeneralHomeController extends Controller
{
    public function index()
    {
        return view('general.pages.home.index', [
            'title' => 'Servis Laptop & Komputer Terpercaya',
        ]);
    }
}
