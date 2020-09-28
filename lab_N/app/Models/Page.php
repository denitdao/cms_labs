<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [ 'code', 'caption_ua', 'caption_en', 'intro_ua', 'intro_en', 'content_ua', 'content_en',
        'order_num', 'page_photo_path', 'order_type', 'view_type', 'parent_id' ];

    public function sub_pages() {
        return $this->hasMany('App\Models\Page', 'parent_id');
    }

    public function parent_page() {
        return $this->belongsTo('App\Models\Page', 'parent_id');
    }

    public static function render($page, $lang = 'ua'){
        $data = Page::getPage($page);
        if($lang == 'en'){
            $data['lang'] = 'en';
        } else {
            $data['lang'] = 'ua';
        }
        return $data;
    }

    public static function getPage($code){
        $page = Page::firstWhere('code', $code);
        if(is_null($page))
            return null;
        if(is_null($page->view_type)) { // this is a single post
            return $page;
        }
        $page['items'] = $page->sub_pages()->where('id', '<>', $page->id)->get(); // get a container with it's posts
//        debug($page);
        return $page;
    }

    public static function renderAll(){
        $data = Page::getAllPages();
        $data['lang'] = 'ua';
//        debug($data);
        return $data;
    }

    public static function getAllPages(){
        $page['items'] = Page::whereNull('view_type')->get();
//        debug($page);
        return $page;
    }
}
