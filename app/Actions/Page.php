<?php

namespace App\Actions;
use Illuminate\Http\Request;
use App\Models\Post;
use Str;
class Page
{

   /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */ 
    public function create(Request $request){
                  
        // Page Data Store
        $page = new Post();
        $page->title = $request->title;
        $page->slug = Str::slug($request->title);
        $page->type = 'page';
        $page->status = $request->status ? 1 : 0;
        $page->save();

        // page Meta data store

        $page->meta()->create([
            'post_id' => $page->id,
            'key'     => 'description',
            'value'   => $request->description,
        ]);

        $seo['title']            = $request->meta_title;
        $seo['description'] = $request->meta_description;
        $seo['tags']        = $request->meta_tags;

        $page->meta()->create([
            'post_id' => $page->id,
            'key'     => 'seo',
            'value'   => json_encode($seo),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){
    
        $page = Post::where('type','page')->findOrFail($id);
        $page->title = $request->title;
        $page->slug = Str::slug($request->title);
        $page->type = 'page';
        $page->status = $request->status ? 1 : 0;
        $page->save();

        // page Meta data update
        if ($page->meta()->where('key', 'description')->exists()){
            $page->description()->update([
                'post_id' => $page->id,
                'key' => 'description',
                'value' => $request->description
            ]);
        }
        else{
            $page->description()->create([
                'post_id' => $page->id,
                'key'   => 'description',
                'value' => $request->description
            ]);
        } 


        $seo['title']            = $request->meta_title;
        $seo['description']      = $request->meta_description;
        $seo['tags']             = $request->meta_tags;

        if ($page->meta()->where('key', 'seo')->exists()){
            $page->seo()->update([
                'post_id' => $page->id,
                'key' => 'seo',
                'value' => json_encode($seo)
            ]);
        }
        else{
            $page->seo()->create([
                'post_id' => $page->id,
                'key'   => 'seo',
                'value' =>json_encode($seo)
            ]);
        } 
            
    }
}