<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use App\Traits\Uploader;
class PartnerController extends Controller
{
     use Uploader;

     public function __construct(){
         $this->middleware('permission:partners'); 
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brands         = Category::whereType('brand')->latest()->paginate(10);
        $totalBrands    = Category::whereType('brand')->count();
        $activeBrands   = Category::whereType('brand')->where('status',1)->count();
        $inActiveBrands = Category::whereType('brand')->where('status',0)->count();
       

        return view('admin.brand.index', compact('brands','totalBrands','activeBrands','inActiveBrands'));
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
            'url' => ['max:100'],
            'image' => ['required','image','max:1024'],
            
        ]);

        $preview = $this->saveFile($request,'image');

        Category::create([
            'title' => $request->url ?? '#',
            'status' => $request->status,
            'type' => 'brand',
            'slug' => $preview,
            'lang'   => $request->type,
        ]);

        return response()->json([
            'message' => __('Partner created successfully.'),
            'redirect' => route('admin.partner.index')
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
            'url' => ['max:100'],
            'image' => ['image','max:1024'],    
        ]);

        $brand = Category::where('type','brand')->findOrFail($id);

        if ($request->hasFile('image')) {
            $preview = $this->saveFile($request,'image');
            if (!empty($brand->slug)) {
                $this->removeFile($brand->slug);
            }
        }
        else{
            $preview = $brand->slug;
        }

        $brand->update([
            'title'  => $request->url ?? '#',
            'status' => $request->status,
            'lang'   => $request->type,
            'type'   => 'brand',
            'slug'   => $preview,
        ]);

        return response()->json([
            'message' => __('Brand updated successfully.'),
            'redirect' => route('admin.partner.index')
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
        $brand = Category::findOrFail($id);
        
        $this->removeFile($brand->slug);

        $brand->delete();

        return response()->json([
            'message' => __('Partner deleted successfully.'),
            'redirect' => route('admin.partner.index')
        ]);
    }
}
