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
class TeamController extends Controller
{
    use Uploader;

   public function __construct(){
         $this->middleware('permission:team'); 
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::where('type','team')->with('preview')->latest()->paginate(20);
        $totalPosts =  Post::where('type','team')->count();
        $totalActivePosts =  Post::where('type','team')->where('status',1)->count();
        $totalInActivePosts =  Post::where('type','team')->where('status',0)->count();

        return view('admin.team.index',compact('posts','totalPosts','totalActivePosts','totalInActivePosts'));
    }

     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       return view('admin.team.create');
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
            'member_name'      => 'required|max:150',
            'member_position'  => 'required|max:100',
            'profile_picture'  => 'required|image|max:2000',
            'about'            => 'required|max:1000',
        ]);


        DB::beginTransaction();
        try {
            
           $post = new Post;
           $post->title = $request->member_name;
           $post->slug  = $request->member_position;
           $post->status= $request->status ? 1 : 0;
           $post->type  = 'team';
           $post->save();

            $post->excerpt()->create([
                'post_id' => $post->id,
                'key'     => 'excerpt',
                'value'   => json_encode($request->socials),
            ]);

            $post->description()->create([
                'post_id' => $post->id,
                'key'     => 'description',
                'value'   => $request->about,
            ]);

            $preview = $this->saveFile($request,'profile_picture');

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
            'message'  => __('Team member created successfully...')
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
        $info = Post::with('description','preview','excerpt')->where('type','team')->findOrFail($id);
        $socials=json_decode($info->excerpt->value ?? '');

        return view('admin.team.edit', compact('info','socials'));
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
            'member_name'      => 'required|max:150',
            'member_position'  => 'required|max:100',
            'profile_picture'  => 'image|max:2000',
            'about'            => 'required|max:1000',
        ]);

       DB::beginTransaction();
        try {
            
           $post =  Post::with('preview')->findorFail($id);
           $post->title   = $request->member_name;
           $post->slug    = $request->member_position;
           $post->type    = 'team';
           $post->status  = $request->status ? 1 : 0;
           $post->save();

           $post->excerpt()->update([
            'post_id' => $post->id,
            'key'     => 'excerpt',
            'value'   => json_encode($request->socials),
           ]);

           $post->description()->update([
            'post_id' => $post->id,
            'key'     => 'description',
            'value'   => $request->about,
           ]);


           if ($request->hasFile('profile_picture')) {
               $preview = $this->saveFile($request,'profile_picture');

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
            'redirect' => route('admin.team.index'),
            'message'  => __('Team member updated successfully...')
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
        $post = Post::where('type','team')->with('preview')->findorFail($id);
        
        if (!empty($post->preview)) {
            $this->removeFile($post->preview->value);
        }

        $post->delete();

        return response()->json([
            'redirect' => route('admin.team.index'),
            'message'  => __('Testimonial deleted successfully...')
        ]);
    }
}
