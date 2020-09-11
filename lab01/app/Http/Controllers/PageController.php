<?php

namespace App\Http\Controllers;

use App;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function show($page, $lang = 'ua') {
        $data = App\Models\Page::render($page, $lang);
        $data['path'] = "/page/$data->code";
        return view('post', $data);
    }
}
