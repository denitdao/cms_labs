<?php

namespace App\Http\Controllers;

use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;
use App\Models\Page;
use Illuminate\Support\Facades\Validator;

class PageResource extends Controller
{
    /**
     * Display a listing of the resource.
     * GET
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index() {
        $data = Page::renderAll();
        $data['code'] = 'page/create';
        return view('index_page', $data);
    }

    /**
     * Show the form for creating a new resource.
     * GET
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create() {
        $data = [
            'lang' => 'ua',
            'code' => 'page/create'
        ];
        return view('create_page', $data);
    }

    /**
     * Store a newly created resource in storage.
     * POST
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request) {
        if (!$request->ajax())
            return response()->json(''); // no input

        $validator = Validator::make($request->all(), [
            'parent_code' => 'bail|required|exists:pages,code',
            'code' => 'bail|required|unique:pages|max:100',
            'caption_ua' => 'bail|required|max:100',
            'caption_en' => 'bail|required|max:100',
            'intro_ua' => 'bail|nullable|max:400',
            'intro_en' => 'bail|nullable|max:400',
            'content_ua' => 'bail|nullable|max:5000',
            'content_en' => 'bail|nullable|max:5000',
            'order_num' => 'bail|nullable|integer'
        ]);

        if ($validator->fails()) {
            debug([$validator->errors()->all()]);
            $data = [
                'message' => $validator->errors()->all(),
                'code' => 'error'
            ];
        } else {
            $container = Page::getPage($request->parent_code);
            $page = $container->sub_pages()->create([
                'code' => $request->code,
                'caption_ua' => $request->caption_ua,
                'caption_en' => $request->caption_en,
                'intro_ua' => $request->intro_ua,
                'intro_en' => $request->intro_en,
                'content_ua' => $request->content_ua,
                'content_en' => $request->content_en,
                'order_num' => $request->order_num
            ]);
    //        debug($page);
            $page->save();
            $data = [
                'message' => 'Page created successfully',
                'code' => $request->code
            ];
        }
        return response()->json($data);
    }

    /**
     * Display the specified resource.
     * GET
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function show($id) {
        return redirect()->route('pages', ['page_code' => $id]);
    }

    /**
     * Show the form for editing the specified resource.
     * GET
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function edit($id) {
        //
        $data = Page::render($id);
        return view('edit_page', $data);
    }

    /**
     * Update the specified resource in storage.
     * PUT
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        if (!$request->ajax())
            return response()->json(''); // no input

        $validator = Validator::make($request->all(), [
            'parent_code' => 'bail|required|exists:pages,code',
            'code' => 'bail|required|exists:pages|max:100',
            'caption_ua' => 'bail|required|max:100',
            'caption_en' => 'bail|required|max:100',
            'intro_ua' => 'bail|nullable|max:400',
            'intro_en' => 'bail|nullable|max:400',
            'content_ua' => 'bail|nullable|max:5000',
            'content_en' => 'bail|nullable|max:5000',
            'order_num' => 'bail|nullable|integer'
        ]);

        if ($validator->fails()) {
            debug([$validator->errors()->all()]);
            $data = [
                'message' => $validator->errors()->all(),
                'code' => 'error'
            ];
        } else {
            $page = Page::getPage($id);
            debug(Page::getPage($request->parent_code)->id);
            $page->update([
                'code' => $request->code,
                'caption_ua' => $request->caption_ua,
                'caption_en' => $request->caption_en,
                'intro_ua' => $request->intro_ua,
                'intro_en' => $request->intro_en,
                'content_ua' => $request->content_ua,
                'content_en' => $request->content_en,
                'order_num' => $request->order_num,
                'parent_id' => Page::getPage($request->parent_code)->id
            ]);
            $data = [
                'message' => 'Page updated successfully',
                'code' => $request->code
            ];
        }
        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     * DELETE
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function destroy($id) {
        Page::getPage($id)->delete();
        return redirect()->route('page.index');
    }
}
