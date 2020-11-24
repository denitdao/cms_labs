<?php

namespace App\Http\Controllers;

use App;
use App\Models\Page;

class PageController extends Controller
{
    public function show($page, $lang = 'ua') {
        $data = Page::render($page, $lang);
        return view($data->view_type ?? 'post', $data);
    }
}
