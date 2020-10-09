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
        $data = Page::renderAdmin();
        $data['code'] = 'page/create';
        return view('index_page', $data);
    }

    /**
     * Show the form for creating a new resource.
     * GET
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create() {
        return view('create_page', ['lang' => 'ua', 'code' => 'page/create']);
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

        $validator = $this->validateToCreate($request->all());

        if ($validator->fails()) {
            $data = [
                'message' => $validator->errors()->all(),
                'code' => 'error'
            ];
        } else {
            Page::addPage($request->all());
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
        return view('edit_page', Page::render($id));
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

        $validator = $this->validateToUpdate($request->all());

        if ($validator->fails()) {
            $data = [
                'message' => $validator->errors()->all(),
                'code' => 'error'
            ];
        } else {
            Page::updatePage($request->all(), $id);
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
        Page::deletePage($id);
        return redirect()->route('page.index');
    }

//    METHODS FOR VALIDATION

    private function validateToCreate($input) {
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
            'view_type' => 'bail|required|in:list,tiles'
//            'page_photo' => 'bail|nullable|image|mimes:jpeg,png,jpg,gif|max:4096'
        ]);
    }

    private function validateToUpdate($input) {
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
            'view_type' => 'bail|required|in:list,tiles'
//            'page_photo' => 'bail|nullable|image|mimes:jpeg,png,jpg,gif|max:4096'
        ]);
    }
}
