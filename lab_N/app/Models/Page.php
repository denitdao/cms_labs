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

    public static function renderAdmin($code){
        $data = Page::firstWhere('code', $code);
        $data['containers'] = Page::getAllContainers($code);
        $data['items'] = Page::getAllPosts($code);
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
        switch($page->order_type){
            case 'order_num_asc':{
                $page['items'] = $page->sub_pages()->where('id', '<>', $page->id)->orderBy('order_num', 'asc')->get(); // get a container with it's posts
                break;
            }
            case 'date_desc':{
                $page['items'] = $page->sub_pages()->where('id', '<>', $page->id)->orderBy('created_at', 'desc')->get(); // get a container with it's posts
                break;
            }
            default:
                $page['items'] = $page->sub_pages()->where('id', '<>', $page->id)->get(); // get a container with it's posts
        }
        return $page;
    }

    public static function getAllPages(){
        return Page::all();
    }

    public static function getAllContainers($code = null){
        if(is_null($code))
            $page = Page::whereNotNull('view_type')->get();
        else {
            $parent = Page::firstWhere('code', $code);
            switch($parent->order_type){
                case 'order_num_asc':{
                    $page = $parent->sub_pages()->whereNotNull('view_type')->orderBy('order_num', 'asc')->get();
                    break;
                }
                case 'date_desc':{
                    $page = $parent->sub_pages()->whereNotNull('view_type')->orderBy('created_at', 'desc')->get();
                    break;
                }
                default:
                    $page = $parent->sub_pages()->whereNotNull('view_type')->get();
            }
        }
        return $page;
    }

    public static function getAllPosts($code = null){
        if(is_null($code))
            $page = Page::whereNull('view_type')->get();
        else {
            $parent = Page::firstWhere('code', $code);
            switch($parent->order_type){
                case 'order_num_asc':{
                    $page = $parent->sub_pages()->whereNull('view_type')->orderBy('order_num', 'asc')->get();
                    break;
                }
                case 'date_desc':{
                    $page = $parent->sub_pages()->whereNull('view_type')->orderBy('created_at', 'desc')->get();
                    break;
                }
                default:
                    $page = $parent->sub_pages()->whereNull('view_type')->get();
            }
        }
        return $page;
    }

//    METHODS FOR DB MANIPULATING

    public static function addPage($array){
        $container = Page::firstWhere('code', $array['parent_code']);
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
        if ($array['page_type'] == 'container'){
            $page->view_type = $array['view_type'];
            $page->order_type = $array['order_type'];
        }
        debug('saved page');
        $page->save();
    }

    public static function updatePage($array, $current_code) {
        $page = Page::firstWhere('code', $current_code);
        $page->update([
            'code' => $array['code'],
            'caption_ua' => $array['caption_ua'],
            'caption_en' => $array['caption_en'],
            'intro_ua' => $array['intro_ua'],
            'intro_en' => $array['intro_en'],
            'content_ua' => $array['content_ua'],
            'content_en' => $array['content_en'],
            'order_num' => $array['order_num'],
            'parent_id' => Page::firstWhere('code', $array['parent_code'])->id
        ]);
        if (isset($array['page_photo'])) {
            if(isset($page->page_photo_path))
                Page::deleteImage($page->page_photo_path);
            $name = Page::saveImage("$page->id-".time(), $array['page_photo']);
            $page->update(['page_photo_path' => $name]);
        }
        if ($array['page_type'] == 'container'){
            $page->update(['view_type' => $array['view_type']]);
            $page->update(['order_type' => $array['order_type']]);
        } else {
            $page->update(['view_type' => null]);
            $page->update(['order_type' => null]);
        }
        debug('updated page');
    }

    public static function deletePage($code){
        Page::firstWhere('code', $code)->delete();
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
