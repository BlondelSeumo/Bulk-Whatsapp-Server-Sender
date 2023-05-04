<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Storage;
use App\Models\User;
use Hash;
use Str;
class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function settings()
    {
        return view('user.profile.settings');
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function authKey()
    {
       return view('user.profile.auth-key');
    }

   
     /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $type
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $type)
    {
        $user=User::findorFail(Auth::id());

        if ($type == 'password') {
            $validatedData = $request->validate([
                'password'      => ['required', 'string', 'min:8', 'max:100', 'confirmed'],
                'oldpassword' => ['required', 'string'],
            ]);

            $check=Hash::check($request->oldpassword,auth()->user()->password);
            if ($check==true) {
              $user->password= Hash::make($request->password);
            }
            else{
               return response()->json([
                    'message' => __('Old password is wrong'),
                ], 403);
            }

            $message = __('Password Updated Successfully');    
        }

        elseif ($type == 'auth-key') {
            $user->authkey = $this->generateAuthKey();
            $user->save();

            return response()->json([
                'redirect' => url('user/auth-key'),
                'message' => __('Auth Key ReGenerated successfully.')
            ]);
        }

        else{
            $validatedData = $request->validate([
                'email'     => 'required|email|unique:users,email,'.Auth::id(),
                'phone'     => 'required|numeric|unique:users,phone,'.Auth::id(),
                'name'      => ['required', 'string','max:100'],
                'address'   => ['required', 'string','max:150'],
                'avatar'    => ['image','max:1024'],
            ]);

            $user->name=$request->name;
            $user->email=$request->email; 
            $user->phone=$request->phone;
            $user->address=$request->address;
            

            if ($request->hasFile('avatar')) {
                $file = $request->file('avatar');
                $ext = $file->extension();
                $filename = now()->timestamp.'.'.$ext;

                $path = 'uploads/' . \Auth::id() . date('/y') . '/' . date('m') . '/';
                $filePath = $path.$filename;
                Storage::put($filePath, file_get_contents($file));
                if ($user->avatar != null) {
                    $fileArr=explode('uploads', $user->avatar);
                    if (isset($fileArr[1])) {
                      $oldavatar='uploads'.$fileArr[1];
                      if (Storage::exists($oldavatar)) {
                        Storage::delete($oldavatar);
                      }
                  }
                }
                $user->avatar = Storage::url($filePath);
            }

            $message = __('General Settings Updated Successfully');    
        }

        $user->save();

        return response()->json($message,200); 
        

    }


    public function generateAuthKey()
    {
        $rend = Str::random(50);
        $check = User::where('authkey', $rend)->first();

        if($check == true){
            $rend = $this->generateAuthKey();
        }
        return $rend;
    }

}
