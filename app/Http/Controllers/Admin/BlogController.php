<?php

namespace App\Http\Controllers\Admin;

use Throwable;
use App\Models\Post;
use Illuminate\Support\str;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Postmeta;
use Illuminate\Support\Facades\Artisan;
use App\Traits\Uploader;
use App\Http\Requests\BlogRequest;
use App\Actions\Blog;

class BlogController extends Controller
{
     use Uploader;

    public function __construct()
    {
        $this->middleware('permission:blogs');
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $posts = Post::query();
        if (!empty($request->search)) {
            $posts = $posts->where('title', 'LIKE', '%' . $request->search . '%');
        }
        $posts = $posts->with('preview')
            ->where('type', 'blog')
            ->latest()
            ->paginate(20);

        $type = $request->type ?? '';    

        $totalPosts= Post::query()->where('type','blog')->count();
        $totalActivePosts= Post::query()->where('type','blog')->where('status',1)->count();
        $totalInActivePosts= Post::query()->where('type','blog')->where('status',0)->count();
       
        return view('admin.blogs.index', compact('posts','totalPosts','totalActivePosts','totalInActivePosts','request'));
    } 

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tags = Category::whereType('tags')->pluck('title', 'id');
        $categories = Category::whereType('blog_category')->where('status',1)->pluck('title', 'id');
        $languages = get_option('languages',true);

        return view('admin.blogs.create', compact('tags', 'categories','languages'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BlogRequest $request, Blog $blog)
    {
        $validated = $request->validated();

        DB::beginTransaction();
        try {
            
             $blog = $blog->create($request);

            DB::commit();

            return response()->json([
                'message' => __("Blog Created Successfully"),
                'redirect' => route('admin.blog.index')
            ]);
        } catch (Throwable $th) {
            DB::rollback();

            return response()->json([
                'message' => $th->getMessage()
            ], 500);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $info=Post::where('type','blog')->with('postcategories','preview','seo','shortDescription','longDescription','seo')->findOrFail($id);
        $tags = Category::whereType('tags')->pluck('title', 'id');
        $categories = Category::whereType('blog_category')->pluck('title', 'id');

        $cats=[];
        foreach ($info->postcategories as $key => $cat) {
           array_push($cats, $cat->category_id);
        }
        

        $seo=json_decode($info->seo->value ?? '');
        $languages = get_option('languages',true);

        return view('admin.blogs.edit', compact('info','tags','categories','cats','seo','languages'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BlogRequest $request,$id, Blog $blog)
    {
      
        $validated = $request->validated();

        DB::beginTransaction();
        try {
             
             $blog = $blog->update($request,$id);

           DB::commit();

            return response()->json([
                'message' => __("Blog Updated Successfully"),
                'redirect' => route('admin.blog.index')
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
    public function destroy(Post $blog)
    {
        if (!empty($blog->preview)) {
            $this->removeFile($blog->preview->value);
        }
        if (!empty($blog->seo)) {
            $seo=json_decode($blog->seo->value);
            if (!empty($seo->image ?? '')) {
                 $this->removeFile($seo->image);
            }
        }
        
        $blog->delete();

        Artisan::call('cache:clear');

        return response()->json([
            'message' => __("Blog Deleted Successfully"),
            'redirect' => route('admin.blog.index')
        ]);
    }

    public function massDestroy(Request $request){
        $request->validate([
            'id' => ['required', 'array']
        ]);

        Post::whereIn('id', $request->input('id'))->delete();

        return response()->json([
            'message' => __('Blog Posts Deleted Successfully'),
            'redirect' => route('admin.blog.index')
        ]);

    }
}
