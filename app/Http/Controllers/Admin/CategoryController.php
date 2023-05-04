<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:blogs-category');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::whereType('blog_category')->latest()->paginate(10);
        $totalCategories = Category::whereType('blog_category')->count();
        $activeCategories = Category::whereType('blog_category')->where('status',1)->count();
        $inActiveCategories = Category::whereType('blog_category')->where('status',0)->count();
        $languages = get_option('languages',true);

        return view('admin.category.index', compact('categories','totalCategories','activeCategories','inActiveCategories','languages'));
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
            'language' => ['required'],
            
        ]);

        Category::create([
            'title' => $request->title,
            'status' => $request->status,
            'lang' => $request->language,
            'type' => 'blog_category',
            'slug' => Str::slug($request->title),
        ]);

        return response()->json([
            'message' => __('Category created successfully.'),
            'redirect' => route('admin.category.index')
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
            'language' => ['required'],
        ]);

        $category = Category::findOrFail($id);

        $category->update([
           'title' => $request->title,
           'status' => $request->status,
           'slug' => Str::slug($request->title),
           'lang' => $request->language,
        ]);

        return response()->json([
            'message' => __('Category updated successfully.'),
            'redirect' => route('admin.category.index')
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
        $category = Category::findOrFail($id);
        $category->delete();

        return response()->json([
            'message' => __('Category deleted successfully.'),
            'redirect' => route('admin.category.index')
        ]);
    }
}
