<?php

namespace App\Http\Controllers\Admin;

use App\Models\Gateway;
use App\Models\Currency;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class GatewayController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:gateways'); 
    }

    public function index()
    {
        $gateways = Gateway::get();
        $active_gateway = Gateway::where('status',1)->count();
        $totalGateways = count($gateways);
        $inactive_gateway = $totalGateways-$active_gateway;
        return view('admin.gateway.index', compact('gateways','active_gateway','totalGateways','inactive_gateway'));
    }

    public function create()
    {
        return view('admin.gateway.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'       => 'required|unique:gateways,name',
            'comment'    => 'max:1000',
            'logo'       => 'nullable|image|max:1024',
            'charge'     => 'required',
            'currency'   => 'required',
            'min_amount' => ['required', 'numeric', 'min:0'],
            'max_amount' => ['required', 'numeric', 'min:0', 'gte:min_amount'],
        ]);

        $gateway = new Gateway();

        if ($request->hasFile('logo')) {

            $image = $request->file('logo');
            $path = 'uploads/' . strtolower(env('APP_NAME')) . date('/y/m/');
            $name = uniqid() . date('dmy') . time() . "." . strtolower($image->getClientOriginalExtension());
            Storage::disk(env('STORAGE_TYPE'))->put($path . $name, file_get_contents(Request()->file('logo')));
            $file_url = Storage::disk(env('STORAGE_TYPE'))->url($path . $name);
            $gateway->logo = $file_url;
        }

        $gateway->currency = $request->currency;
        $gateway->name = $request->name;
        $gateway->charge = $request->charge;
        $gateway->multiply = $request->multiply ?? 0;
        $gateway->namespace = 'App\Lib\CustomGateway';
        $gateway->is_auto = 0;
        $gateway->image_accept = $request->image_accept;
        $gateway->status = $request->status;
        $gateway->comment = $request->comment;
        $gateway->save();

        return response()->json([
            'redirect' => route('admin.gateways.index'),
            'message'  => __('Gateway created successfully.')
        ]);
    }

    public function edit($id)
    {
        $gateway = Gateway::findOrFail($id);
        return view('admin.gateway.edit', compact('gateway'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:gateways,name,' . $id,
            'logo' => 'nullable|image|max:100',
            'charge' => 'required',
            'namespace' => 'nullable',
            'currency' => 'required',
            'min_amount' => ['required', 'numeric', 'min:0'],
            'max_amount' => ['required', 'numeric', 'min:0', 'gte:min_amount'],
        ]);

        $gateway = Gateway::findOrFail($id);

        if ($gateway->is_auto == 0) {
            $request->validate([
                'comment' => 'required',
            ]);
        } else {
            $gateway->data = $request->data ? json_encode($request->data) : '';
        }
        if ($request->hasFile('logo')) {
            if (!empty($gateway->logo)) {
                $file = $gateway->logo;
                $arr = explode('uploads', $file);
                if (count($arr ?? []) != 0) {
                    if (isset($arr[1])) {
                        Storage::delete('uploads' . $arr[1]);
                    }
                }
            }

            $image = $request->file('logo');
            $path = 'uploads/' . strtolower(env('APP_NAME')) . date('/y/m/');
            $name = uniqid() . date('dmy') . time() . "." . strtolower($image->extension());

            Storage::put($path . $name, file_get_contents(Request()->file('logo')));

            $file_url = Storage::url($path . $name);
            $gateway->logo = $file_url;
        }

        $gateway->comment    = $request->comment;
        $gateway->name       = $request->name;
        $gateway->charge     = $request->charge;
        $gateway->multiply = $request->multiply ?? 0;
        $gateway->currency   = $request->currency;
        $gateway->test_mode  = $request->test_mode ?? 0;
        $gateway->status     = $request->status;
        $gateway->min_amount = $request->min_amount;
        $gateway->max_amount = $request->max_amount;        
        $gateway->save();

        return response()->json([
            'redirect' => route('admin.gateways.index'),
            'message'  => __('Gateway updated successfully.')
        ]);
    }
}
