<?php

namespace App\Http\Controllers\Installer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\Dotenv;
use Session;
use Artisan;
use Config;
use DB;
use File;
use Cache;
class InstallerController extends Controller
{

    use Dotenv;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (file_exists('uploads/installed')) {
            return redirect('/');
        }
        \Cache::forget('files');
        \Cache::forget('installed');

        $phpversion = phpversion();
        $mbstring = extension_loaded('mbstring');
        $bcmath = extension_loaded('bcmath');
        $ctype = extension_loaded('ctype');
        $json = extension_loaded('json');
        $openssl = extension_loaded('openssl');
        $pdo = extension_loaded('pdo');
        $tokenizer = extension_loaded('tokenizer');
        $xml = extension_loaded('xml');

        $extentions = [
            'mbstring' => $mbstring,
            'bcmath' => $bcmath,
            'ctype' => $ctype,
            'json' => $json,
            'openssl' => $openssl,
            'pdo' => $pdo,
            'tokenizer' => $tokenizer,
            'xml' => $xml,
        ];
        return view('installer.requirements',compact('extentions'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'site_name' => 'required|alpha|max:50',
            'db_connection' => 'required|alpha|max:50',
            'db_host' => 'required|max:50',
            'db_port' => 'required|numeric',
            'db_name' => 'required|max:50',
            'db_user' => 'required|max:50',
            'db_pass' => 'nullable|max:50',
        ]);

        $this->editEnv('APP_URL',url('/'));
        $this->editEnv('APP_NAME',$request->site_name);

        $this->editEnv('DB_CONNECTION',$request->db_connection);
        $this->editEnv('DB_HOST',$request->db_host);
        $this->editEnv('DB_PORT',$request->db_port);

        $this->editEnv('DB_DATABASE',$request->db_name);
        $this->editEnv('DB_USERNAME',$request->db_user);

       
        


        if (!empty($request->db_pass)) {
            $this->editEnv('DB_PASSWORD',$request->db_pass);
        }
       
       try {
            $pdo = DB::connection()->getPdo();

            if (!$pdo) {

                return response()->json(['message'=>'Could not connect to the database.  Please check your configuration'],403);
            }

            
            return response()->json(['message'=>'Installtion in processed']);
            

        } catch (\Exception $e) {
           
            return response()->json(['message'=>'Could not connect to the database.  Please check your configuration'],401);
            
        }
    }


    public function migrate()
    {
        ini_set('max_execution_time', 0);

        try {
            Artisan::call('migrate:fresh', [
                '--force' => true,
            ]);

            Artisan::call('db:seed',[
                '--force' => true,
            ]);


            File::put('uploads/installed',\Cache::get('installed'));

            if (\Cache::has('files')) {
                $files = \Cache::get('files');

                foreach ($files ?? [] as $key => $file) {
                    $path = $file->basepath == 1 ? base_path($file->replace_path) : $file->replace_path;
                    $context = \Http::get($file->file);
                    $context = $context->body();
                    File::put($path,$context);
                }
            }

            return response()->json(['message'=>'Installtion complete', 'redirect'=> url('install/congratulations')]);
        } catch (Exception $e) {
             return response()->json(['message'=>'Please create a fresh new database'],401);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $type
     * @return \Illuminate\Http\Response
     */
    public function show($type)
    {
        if ($type == 'purchase') {
             return view('installer.purchase');
        }

        elseif ($type == 'info') {
            return view('installer.info');
        }

        elseif ($type == 'congratulations') {
            return view('installer.congratulations');
        }
    }


    public function verify(Request $request)
    {
        if (file_exists('uploads/installed')) {
            return redirect('/');
        }
        
        return response()->json(['message'=>'Verification success', 'redirect'=> url('install/info')]);
    }

   

}
