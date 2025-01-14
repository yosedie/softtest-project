<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Yajra\DataTables\Facades\DataTables;
use App\Currency;
use DB;
use Spatie\Permission\Models\Role;

class CurrencyExchangeController extends Controller
{
    public function __construct()
    {
    
        $this->middleware('permission:currency.view', ['only' => ['index','show']]);
        $this->middleware('permission:currency.create', ['only' => ['create', 'store', 'saveSetting']]);
        $this->middleware('permission:currency.edit', ['only' => ['edit', ' auto_update_currency','update']]);
        $this->middleware('permission:currency.delete', ['only' => ['destroy']]);
    
    }
    public function saveSetting(Request $request){
        $env_keys_save = \DotenvEditor::setKeys([
            'OPEN_EXCHANGE_RATE_KEY' => $request->OPEN_EXCHANGE_RATE_KEY
        ]);

        $env_keys_save->save();


        return back()->with('added','Exchange key has been updated !');
    }




    public function index()
    {
        $currency = DB::table('currencies')->get();

        if(request()->ajax()){
            // $currency = currency()->getCurrencies();
           return DataTables::of($currency)
            ->addIndexColumn()
            ->addColumn('name',function($row){
                return $row->name;
            })
            ->addColumn('code',function($row){
                return $row->code;
            })
            ->addColumn('symbol',function($row){
                return $row->symbol;
            })
            ->addColumn('exchange_rate',function($row){
                return $row->exchange_rate;
            })
            ->editColumn('created_at',function($row){
                return $row->created_at;
            })
            ->editColumn('position',function($row){
                if($row->position == 'l'){
                    $position = "Left side";
                }elseif($row->position == 'r'){
                    $position = "Right side";
                }else{
                    $position = "other side";
                }
                return $position;
            })
            ->editColumn('action','admin.currency.manage.action')
            ->editColumn('update','admin.currency.manage.update')
            ->editColumn('default','admin.currency.manage.default')
            ->rawColumns(['action', 'update', 'default','position'])
            ->make(true);
        }
        
        return view('admin.currency.manage.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('currency::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //return $request;
        $request->validate([
            'code' => 'required|string|max:3'
        ]);

        Artisan::call('currency:manage add '.$request->code);

        Artisan::call('currency:update -o');

        return back()->with('success','Currency added !');

    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('currency::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('currency::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $code)
    {
        try {
            Artisan::call('currency:manage', ['action' => 'update', 'currency' => $code]);
            Artisan::call('currency:update -o');

            if (isset($request->default)) {

                $remove_def =  Currency::where('code','!=',$code)->update(['default' => 0]);

                $remove_def =  Currency::where('code','=',$code)->update(['default' => 1]);

            }
            $currency = Currency::where('code', $code)->first();
            $currency->update([
               'position' => $request->position
                ]);

            return back();
          
        } catch (\Exception $e) {

            return back()->with($e->getMessage());
        }

        return back();
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($code)
    {
        $currency = DB::table('currencies')->where('code', $code)->first();

        if($currency->default == 1)
        {
            return back()->with('delete','You can\'t delete default currency!');
        }

        currency()->delete($code);
        return back()->with('deleted','Currency deleted !');

    }

    public function auto_update_currency(Request $request)
    {
        if ($request->ajax()) {

            try {
                Artisan::call('currency:update -o');
              
                return response()->json(['msg' => 'Currency Rate Auto Update Successfully ! !']);
              
            } catch (\Exception $e) {
                return response()->json(['msg' => $e->getMessage()]);
            }

        }

    }

}
