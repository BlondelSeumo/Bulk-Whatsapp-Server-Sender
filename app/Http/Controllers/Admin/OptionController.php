<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Option;
use Cache;
class OptionController extends Controller
{
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $key
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $key)
    {
        $option= Option::where('key',$key)->first();
        if (empty($option)) {
            $option = new Option;
            $option->key = $key;
        }
        $option->value = isset($request->is_array) ? json_encode($request->data) : $request->data;
        $option->save();

        Cache::forget($option->key);

        return response()->json([
                'message' => __("Settings Updated Successfully..!!"),
            ]);

    }

}
