<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Postmeta;
use App\Http\Requests\PageRequest;
use App\Actions\Page;
use DB;
use Auth;
use Cache;
class PageController extends Controller
{
    public function __construct()
    {
          $this->middleware('permission:custom-page'); 
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pages = Post::where('type', 'page')->orderBy('id','desc')->paginate(20);
        $totalActivePosts=Post::where('type', 'page')->where('status',1)->count();
        $totalInActivePosts=Post::where('type', 'page')->where('status',0)->count();
        $totalPosts=Post::where('type', 'page')->count();

        return view('admin.page.index', compact('pages','totalActivePosts','totalInActivePosts','totalPosts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       return view('admin.page.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PageRequest $request, Page $page)
    {
        $validated = $request->validated();

        DB::beginTransaction();
        try {
            
             $page = $page->create($request);

            DB::commit();

        } catch (Throwable $th) {
            DB::rollback();

            return response()->json([
                'message' => $th->getMessage()
            ], 500);
        }

        return response()->json([
                'message' => __("Page Created Successfully"),
                'redirect' => route('admin.page.index')
            ]);
    }

   

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $info = Post::with('description','seo')->findOrFail($id);
        $seo=json_decode($info->seo->value ?? '');

        return view('admin.page.edit', compact('info','seo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PageRequest $request,$id, Page $page)
    {
        $validated = $request->validated();
       

        DB::beginTransaction();
        try {
             
            $page = $page->update($request,$id);

            DB::commit();

            return response()->json([
                'message' => __("Page Updated Successfully"),
                'redirect' => route('admin.page.index')
            ]);
        } catch (Throwable $th) {
            DB::rollback();

            return response()->json([
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $page)
    {
        $page->delete();
        Cache::forget('page_' . $page->slug);

        return response()->json([
            'message' => __("Page Deleted Successfully"),
            'redirect' => route('admin.page.index')
        ]);
    }
}
