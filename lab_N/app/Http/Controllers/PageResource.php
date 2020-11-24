<?php

namespace App\Http\Controllers;

use App\Exceptions\NonContainerAdminException;
use App\Http\Traits\ValidationTrait;
use Illuminate\Http\Request;
use App\Models\Page;

class PageResource extends Controller
{
    use ValidationTrait;

    /**
     * Display a listing of the resource.
     * GET
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index() {
        $data = Page::renderAdmin('home'); // render home
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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function show($id) {
        try {
            $data = Page::renderAdmin($id);
        } catch (NonContainerAdminException $e) {
            return redirect()->route('page.edit', $e->getMessage());
        }
        return view('index_page', $data);
    }

    /**
     * Show the form for editing the specified resource.
     * GET
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function edit($id) {
        return view('edit_page', Page::renderEdit($id));
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
            $data = [
                'message' => 'Page updated successfully',
                'code' => Page::updatePage($request->all(), $id),
                'parent' => $request->parent_code
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

}
