<?php

namespace App\Actions;

use Illuminate\Http\Request;
use App\Models\Post;
use Str;
use Artisan;
use App\Traits\Uploader;
class Blog
{
     use Uploader;

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */ 
    public function create(Request $request){
                  
            $post = new Post();
            $post->title = $request->title;;
            $post->slug = Str::slug($request->title);
            $post->type = 'blog';
            $post->featured = isset($request->featured) ? 1 : 0;
            $post->status = isset($request->status) ? 1 : 0;
            $post->lang = $request->language ?? 'en';
            $post->save();

            if (!empty($request->categories)) {
                $post->categories()->sync($request->categories);
            }

            $preview=  $this->saveFile($request,'preview');

            $post->meta()->create([
                'key'   => 'preview',
                'value' => $preview
            ]);

            $post->meta()->create([
                'key'   => 'short_description',
                'value' => $request->short_description
            ]);

            $post->meta()->create([
                'key'   => 'main_description',
                'value' => $request->main_description
            ]);
            
            $seo['title'] = $request->meta_title;
            $seo['description'] = $request->meta_description;
            $seo['tags'] = $request->meta_tags;

            if ($request->hasFile('meta_image')) {
                $metaPreview=  $this->saveFile($request,'meta_image');
                $seo['image'] = $metaPreview;
            }

            $post->meta()->create([
                'key'   => 'seo',
                'value' => json_encode($seo)
            ]);
    
            Artisan::call('cache:clear');  
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){
                
            $post = Post::where('type','blog')->with('preview','seo')->findOrFail($id);
          
            $post->title = $request->title;;
            $post->slug = Str::slug($request->title);
            $post->type = 'blog';
            $post->featured = isset($request->featured) ? 1 : 0;
            $post->status = isset($request->status) ? 1 : 0;
            $post->lang = $request->language ?? 'en';
            $post->save();

            
            $post->categories()->sync($request->categories ?? []);

            if ($request->hasFile('preview')) {
               
                $preview=  $this->saveFile($request,'preview');

                $this->removeFile($post->preview->value ?? '');

                if ($post->meta()->where('key', 'preview')->exists()){
                    $post->preview()->update([
                        'key' => 'preview',
                        'value' => $preview
                    ]);
                }
                else{
                    $post->preview()->create([
                        'key'   => 'preview',
                        'value' => $preview
                    ]);
                }   
                
            }

            if ($post->meta()->where('key', 'short_description')->exists()){
                $post->shortDescription()->update([
                    'key' => 'short_description',
                    'value' => $request->short_description
                ]);
            }
            else{
                $post->shortDescription()->create([
                    'key'   => 'short_description',
                    'value' => $request->short_description
                ]);
            } 

            if ($post->meta()->where('key', 'main_description')->exists()){
                $post->longDescription()->update([
                    'key' => 'main_description',
                    'value' => $request->main_description
                ]);
            }
            else{
                $post->longDescription()->create([
                    'key'   => 'main_description',
                    'value' => $request->main_description
                ]);
            } 
            

            

            
            
            $seo['title'] = $request->meta_title;
            $seo['description'] = $request->meta_description;
            $seo['tags'] = $request->meta_tags;


            if ($request->hasFile('meta_image')) {
                $metaPreview=  $this->saveFile($request,'meta_image');

                $metaSeo=json_decode($post->seo->value ?? '');
                if (isset($metaSeo->image)) {
                    if (!empty($metaSeo->image)) {
                       $this->removeFile($metaSeo->image);
                    }
                }
                
                $seo['image'] = $metaPreview;
            }

            if ($post->meta()->where('key', 'seo')->exists()){
                $post->seo()->update([
                    'key' => 'seo',
                    'value' => json_encode($seo)
                ]);
            }
            else{
                $post->seo()->create([
                    'key'   => 'seo',
                    'value' => json_encode($seo)
                ]);
            } 
            
    
            Artisan::call('cache:clear');  
    }
}