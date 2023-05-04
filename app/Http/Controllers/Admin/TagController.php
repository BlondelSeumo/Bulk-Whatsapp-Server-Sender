<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Category;

class TagController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:blog-tags');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags = Category::whereType('tags')->withCount('postcategories')->latest()->paginate(10);
        $totalTags = Category::whereType('tags')->count();
        $activeTags = Category::whereType('tags')->where('status',1)->count();
        $inActiveTags = Category::whereType('tags')->where('status',0)->count();
        $languages = get_option('languages',true);
        return view('admin.tag.index', compact('tags','totalTags','activeTags','inActiveTags','languages'));
    }

    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $request->validate([
            'title' => ['required', 'min:2', 'max:100'],
            'language' => ['required']
        ]);

        Category::create([
            'title' => $request->title,
            'type' => 'tags',
            'slug' => Str::slug($request->title),
            'status' => $request->status,
            'lang' => $request->language,
        ]);

        return response()->json([
            'message' => __('Tag created successfully.'),
            'redirect' => route('admin.tag.index')
        ]);
    }

   

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => ['required', 'min:2', 'max:100'],
            'language' => ['required']
        ]);

        $tag = Category::findOrFail($id);

        $tag->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'status' => $request->status,
            'lang' => $request->language,
        ]);

        return response()->json([
            'message' => __('Tag updated successfully.'),
            'redirect' => route('admin.tag.index')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tag = Category::findOrFail($id);
        $tag->delete();

        return response()->json([
            'message' => __('Tag deleted successfully.'),
            'redirect' => route('admin.tag.index')
        ]);
    }
}
