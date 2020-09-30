<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Page extends Model
{
    use HasFactory;

//    DB SETTINGS

    protected $fillable = [ 'code', 'caption_ua', 'caption_en', 'intro_ua', 'intro_en', 'content_ua', 'content_en',
        'order_num', 'page_photo_path', 'order_type', 'view_type', 'parent_id' ];

    public function sub_pages() {
        return $this->hasMany('App\Models\Page', 'parent_id');
    }

    public function parent_page() {
        return $this->belongsTo('App\Models\Page', 'parent_id');
    }

//    METHODS FOR PAGE RENDERING

    public static function render($page, $lang = 'ua'){
        $data = Page::getPage($page);
        if($lang == 'en'){
            $data['lang'] = 'en';
        } else {
            $data['lang'] = 'ua';
        }
        return $data;
    }

    public static function renderAll(){
        $data['items'] = Page::getAllPosts(); // could use getAllPages()
        $data['lang'] = 'ua';
        return $data;
    }

//    METHODS FOR GETTING PAGES DATA

    public static function getPage($code){
        $page = Page::firstWhere('code', $code);
        if(is_null($page))
            return null;
        if(is_null($page->view_type)) { // this is a single post
            return $page;
        }
        $page['items'] = $page->sub_pages()->where('id', '<>', $page->id)->get(); // get a container with it's posts
        return $page;
    }

    public static function getAllPages(){
        $page = Page::all();
        return $page;
    }

    public static function getAllPosts(){
        $page = Page::whereNull('view_type')->get();
        return $page;
    }

//    METHODS FOR DB MANIPULATING

    public static function addPage($array){
        $container = Page::getPage($array['parent_code']);
        $page = $container->sub_pages()->create([
            'code' => $array['code'],
            'caption_ua' => $array['caption_ua'],
            'caption_en' => $array['caption_en'],
            'intro_ua' => $array['intro_ua'],
            'intro_en' => $array['intro_en'],
            'content_ua' => $array['content_ua'],
            'content_en' => $array['content_en'],
            'order_num' => $array['order_num'],
        ]);
        if (isset($array['page_photo'])) {
            $name = Page::saveImage("$page->id-".time(), $array['page_photo']);
            $page->page_photo_path = $name;
        }
        debug('saved page');
        $page->save();
    }

    public static function updatePage($array, $current_code) {
        $page = Page::getPage($current_code);
        $page->update([
            'code' => $array['code'],
            'caption_ua' => $array['caption_ua'],
            'caption_en' => $array['caption_en'],
            'intro_ua' => $array['intro_ua'],
            'intro_en' => $array['intro_en'],
            'content_ua' => $array['content_ua'],
            'content_en' => $array['content_en'],
            'order_num' => $array['order_num'],
            'parent_id' => Page::getPage($array['parent_code'])->id
        ]);
        if (isset($array['page_photo'])) {
            if(isset($page->page_photo_path))
                Page::deleteImage($page->page_photo_path);
            $name = Page::saveImage("$page->id-".time(), $array['page_photo']);
            $page->update(['page_photo_path' => $name]);
        }
        debug('updated page');
    }

    public static function deletePage($code){
        Page::getPage($code)->delete();
    }

    public static function saveImage($name, $base64){
        list($type, $data) = explode(';', $base64);
        list(, $type)      = explode('/', $type);
        list(, $data)      = explode(',', $data);
        $full_name = $name.'.'.strtolower($type);
        debug($type);
        Storage::disk('images')->put($full_name, base64_decode($data));
        return $full_name;
    }

    public static function deleteImage($name){
        Storage::disk('images')->delete($name);
    }
}
