<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    public static function render($page, $lang){
        // find all the necessary data
        if($lang == 'en'){
            $data = Page::getPageEn($page);
            $data['lang'] = 'en';
        } else { // ukrainian
            $data = Page::getPageUa($page);
            $data['lang'] = 'ua';
        }
        return $data;
    }

    public static function getPageUa($code){
        $ua_page = Page::where('code', $code)
            ->select('code', 'caption_ua', 'content_ua', 'page_photo_path', 'created_at')->first();
        return $ua_page;
    }

    public static function getPageEn($code){
        $en_page = Page::where('code', $code)
            ->select('code', 'caption_en', 'content_en', 'page_photo_path', 'created_at')->first();
        return $en_page;
    }

    public static function getIntroUa($code){
        $ua_page = Page::where('code', $code)
            ->select('code', 'caption_ua', 'intro_ua', 'page_photo_path', 'created_at')->first();
        return $ua_page;
    }

    public static function getIntroEn($code){
        $en_page = Page::where('code', $code)
            ->select('code', 'caption_en', 'intro_en', 'page_photo_path', 'created_at')->first();
        return $en_page;
    }
}
