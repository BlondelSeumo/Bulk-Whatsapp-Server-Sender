<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\Uploader;
use App\Models\Post;
use App\Models\Postmeta;
use DB;
use Auth;
use Str;
class TestimonialsController extends Controller
{
    use Uploader;

   public function __construct(){
         $this->middleware('permission:testimonials'); 
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::where('type','testimonial')->with('excerpt','preview')->latest()->paginate(20);
        
        return view('admin.testimonial.index',compact('posts'));
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
            'reviewer_name'    => 'required|max:150',
            'reviewer_position'=> 'required|max:100',
            'star'             => 'required|max:100',
            'comment'          => 'required|max:500',
            'reviewer_avatar'  => 'required|image|max:1024',
        ]);


        DB::beginTransaction();
        try {
            
           $post = new Post;
           $post->title = $request->reviewer_name;
           $post->slug  = $request->reviewer_position;
           $post->type  = 'testimonial';
           $post->lang  = $request->star;
           $post->save();

            $post->excerpt()->create([
                'post_id' => $post->id,
                'key'     => 'excerpt',
                'value'   => $request->comment,
            ]);

            $preview = $this->saveFile($request,'reviewer_avatar');

            $post->preview()->create([
                'post_id' => $post->id,
                'key'     => 'preview',
                'value'   => $preview,
            ]);

            DB::commit();

        } catch (Throwable $th) {
            DB::rollback();

            return response()->json([
                'message' => $th->getMessage()
            ], 500);
        }

        return response()->json([
            'redirect' => route('admin.testimonials.index'),
            'message'  => __('Testimonial created successfully...')
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
            'reviewer_name'    => 'required|max:150',
            'reviewer_position'=> 'required|max:100',
            'star'             => 'required|max:100',
            'comment'          => 'required|max:500',
            'reviewer_avatar'  => 'image|max:1024',
        ]);

       DB::beginTransaction();
        try {
            
           $post =  Post::with('preview')->findorFail($id);
           $post->title = $request->reviewer_name;
           $post->slug  = $request->reviewer_position;
           $post->type  = 'testimonial';
           $post->lang  = $request->star;
           $post->save();

           $post->excerpt()->update([
            'post_id' => $post->id,
            'key' => 'excerpt',
            'value' => $request->comment,
           ]);

           if ($request->hasFile('reviewer_avatar')) {
               $preview = $this->saveFile($request,'reviewer_avatar');

               !empty($post->preview) ? $this->removeFile($post->preview->value) : '';

               $post->preview()->update([
                    'post_id' => $post->id,
                    'key'     => 'preview',
                    'value'   => $preview,
               ]);

           }

            DB::commit();

        } catch (Throwable $th) {
            DB::rollback();

            return response()->json([
                'message' => $th->getMessage()
            ], 500);
        }

        return response()->json([
            'redirect' => route('admin.testimonials.index'),
            'message'  => __('Testimonial updated successfully...')
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
        $post = Post::where('type','testimonial')->with('preview')->findorFail($id);
        
        if (!empty($post->preview)) {
            $this->removeFile($post->preview->value);
        }

        $post->delete();

        return response()->json([
            'redirect' => route('admin.testimonials.index'),
            'message'  => __('Testimonial deleted successfully...')
        ]);
    }
}
