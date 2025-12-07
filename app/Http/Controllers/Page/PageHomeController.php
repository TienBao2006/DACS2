<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PageHomeController extends Controller
{
    public function PageHome()
    {
        return view('pagehome.pagehome');
    }
}
