<?php
namespace App\Http\Traits;

use Illuminate\Support\Facades\Validator;

trait ValidationTrait
{
    private function validateToCreate($input) {
        if($input['page_type'] == 'alias')
            return Validator::make($input, [
                'code' => 'bail|required|exists:pages,code',
                'parent_code' => 'bail|required|exists:pages,code',
                'caption_ua' => 'bail|nullable|max:100',
                'caption_en' => 'bail|nullable|max:100',
                'intro_ua' => 'bail|nullable|max:400',
                'intro_en' => 'bail|nullable|max:400',
                'order_num' => 'bail|nullable|integer',
            ]);
        else
            return Validator::make($input, [
                'code' => 'bail|required|unique:pages|max:100',
                'parent_code' => 'bail|required|exists:pages,code',
                'caption_ua' => 'bail|required|max:100',
                'caption_en' => 'bail|required|max:100',
                'intro_ua' => 'bail|nullable|max:400',
                'intro_en' => 'bail|nullable|max:400',
                'content_ua' => 'bail|nullable|max:65534',
                'content_en' => 'bail|nullable|max:65534',
                'order_num' => 'bail|nullable|integer',
                'page_type' => 'bail|required|in:container,publication',
                'view_type' => 'bail|required|in:list,tiles',
                'order_type' => 'bail|required|in:order_num_asc,date_desc'
//            'page_photo' => 'bail|nullable|image|mimes:jpeg,png,jpg,gif|max:4096'
            ]);
    }

    private function validateToUpdate($input) {
        if($input['page_type'] == 'alias')
            return Validator::make($input, [
                'code' => 'bail|required|exists:pages,code',
                'parent_code' => 'bail|required|exists:pages,code',
                'caption_ua' => 'bail|nullable|max:100',
                'caption_en' => 'bail|nullable|max:100',
                'intro_ua' => 'bail|nullable|max:400',
                'intro_en' => 'bail|nullable|max:400',
                'order_num' => 'bail|nullable|integer',
            ]);
        else
            return Validator::make($input, [
                //            'code' => 'bail|required|exists:pages|max:100',
                'parent_code' => 'bail|required|exists:pages,code',
                'caption_ua' => 'bail|required|max:100',
                'caption_en' => 'bail|required|max:100',
                'intro_ua' => 'bail|nullable|max:400',
                'intro_en' => 'bail|nullable|max:400',
                'content_ua' => 'bail|nullable|max:65534',
                'content_en' => 'bail|nullable|max:65534',
                'order_num' => 'bail|nullable|integer',
                'page_type' => 'bail|required|in:container,publication',
                'view_type' => 'bail|required|in:list,tiles',
                'order_type' => 'bail|required|in:order_num_asc,date_desc'
                //            'page_photo' => 'bail|nullable|image|mimes:jpeg,png,jpg,gif|max:4096'
            ]);
    }
}
