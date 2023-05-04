<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use Carbon\Carbon;
use App\Traits\Seo;
class BlogController extends Controller
{
    use Seo;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $blogs = Post::where('type','blog')->where('lang',app()->getLocale());
                if (!empty($request->search)) {
                    $blogs = $blogs->where('title','LIKE','%'.$request->search.'%');
                }
                if (!empty($request->date)) {
                    $date = Carbon::parse($request->date);
                    $blogs = $blogs->whereDate('created_at', $date);
                }
        $blogs = $blogs->with('shortDescription','preview')->where('status',1)->latest()->paginate(4);

        $recent_blogs = Post::where('type','blog')->where('lang',app()->getLocale())->with('shortDescription','preview')->where('status',1)->latest()->take(4)->get();

        $categories = Category::where('type','blog_category')->whereHas('postcategories')->where('lang',app()->getLocale())->get();

        $tags = Category::where('type','tags')->whereHas('postcategories')->where('lang',app()->getLocale())->get();

        $this->metadata('seo_blog');

        return view('frontend.blog.list',compact('blogs','request','recent_blogs','categories','tags'));
    }



   public function category(Request $request, $slug,$id)
   {
       $category = Category::where('type','blog_category')->where('status',1)->findorFail($id);

       $blogs = Post::where('type','blog')->where('lang',app()->getLocale());
                if (!empty($request->search)) {
                    $blogs = $blogs->where('title','LIKE','%'.$request->search.'%');
                }
        $blogs = $blogs->with('shortDescription','preview')->whereHas('postcategories',function($query) use ($id){
            return $query->where('category_id',$id);
        })->where('status',1)->latest()->paginate(4);

        $recent_blogs = Post::where('type','blog')->where('lang',app()->getLocale())->with('shortDescription','preview')->where('status',1)->latest()->take(4)->get();

        $categories = Category::where('type','blog_category')->where('status',1)->whereHas('postcategories')->where('lang',app()->getLocale())->get();
        $tags = Category::where('type','tags')->where('status',1)->whereHas('postcategories')->where('lang',app()->getLocale())->get();

        $meta['title'] = $category->title ?? '';
        
        $this->pageMetaData($meta);

        return view('frontend.blog.list',compact('blogs','request','recent_blogs','categories','tags'));
   }

    public function tag(Request $request, $slug,$id)
   {
        $category = Category::where('type','tags')->where('status',1)->findorFail($id);

       $blogs = Post::where('type','blog')->where('lang',app()->getLocale());
                if (!empty($request->search)) {
                    $blogs = $blogs->where('title','LIKE','%'.$request->search.'%');
                }
        $blogs = $blogs->with('shortDescription','preview')->whereHas('postcategories',function($query) use ($id){
            return $query->where('category_id',$id);
        })->where('status',1)->latest()->paginate(4);

        $recent_blogs = Post::where('type','blog')->where('lang',app()->getLocale())->with('shortDescription','preview')->where('status',1)->latest()->take(4)->get();

        $categories = Category::where('type','blog_category')->whereHas('postcategories')->where('status',1)->where('lang',app()->getLocale())->get();
        $tags = Category::where('type','tags')->whereHas('postcategories')->where('status',1)->where('lang',app()->getLocale())->get();

        $meta['title'] = $category->title ?? '';
        
        $this->pageMetaData($meta);

        return view('frontend.blog.list',compact('blogs','request','recent_blogs','categories','tags'));
   }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $blog = Post::where('type','blog')->with('shortDescription','longDescription','tags','preview','seo')->where('status',1)->where('slug',$slug)->first();
        abort_if(empty($blog),404);

        $categories = Category::where('type','blog_category')->whereHas('postcategories')->withCount('postcategories')->where('status',1)->where('lang',app()->getLocale())->get();

        $tags = Category::where('type','tags')->whereHas('postcategories')->where('status',1)->where('lang',app()->getLocale())->get();

        $recent_blogs = Post::where('type','blog')->where('lang',app()->getLocale())->with('shortDescription','preview')->where('status',1)->latest()->take(4)->get();

        $seo = json_decode($blog->seo->value ?? '');

        $meta['title'] = $seo->title ?? '';
        $meta['description'] = $seo->description ?? '';
        $meta['tags'] = $seo->tags ?? '';
        $meta['preview'] = $seo->image ?? '';

        $this->pageMetaData($meta);

        return view('frontend.blog.show',compact('blog','categories','tags','recent_blogs'));
    }

   
}
