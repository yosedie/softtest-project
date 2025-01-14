<?php

namespace App\Http\Controllers;

use App\RefundPolicy;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;


class RefundPolicyController extends Controller
{
    public function __construct()
    {
    
        $this->middleware('permission:refund-policy.view', ['only' => ['index']]);
        $this->middleware('permission:refund-policy.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:refund-policy.edit', ['only' => ['edit', 'update','status']]);
        $this->middleware('permission:refund-policy.delete', ['only' => ['destroy', 'bulk_delete']]);
    
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $return = RefundPolicy::get();
        return view('admin.return_policy.index',compact('return'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.return_policy.insert');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this -> validate($request,[
            'name'=>'required',
            'days'=>'required',
            'detail'=>'required',
        ]);

        $input = $request->all();
        $input['status'] = isset($request->status)  ? 1 : 0;
        
        $data = RefundPolicy::create($input);

        Session::flash('success',trans('flash.AddedSuccessfully'));
        return redirect('refundpolicy');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\RefundPolicy  $refundPolicy
     * @return \Illuminate\Http\Response
     */
    public function show(RefundPolicy $refundPolicy)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RefundPolicy  $refundPolicy
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $return = RefundPolicy::where('id', $id)->first();
        return view('admin.return_policy.edit',compact('return'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RefundPolicy  $refundPolicy
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // return $request;

        $data = $this->validate($request,[
            'name' => 'required',
            'detail' => 'required',
            'days' => 'required',
        ]);

        
        $data = RefundPolicy::findorfail($id);
        
        $input = $request->all();
        $input['status'] = isset($request->status)  ? 1 : 0;
        $data->update($input);

       
        Session::flash('success',trans('flash.UpdatedSuccessfully'));
        return redirect('refundpolicy');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RefundPolicy  $refundPolicy
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        RefundPolicy::where('id', $id)->delete();
        return redirect('refundpolicy');
    }
    public function bulk_delete(Request $request)
    {
     
        $validator = Validator::make($request->all(), [
            'checked' => 'required',
        ]);

        if ($validator->fails()) {

            return back()->with('warning', 'Atleast one item is required to be checked');
           
        }
        else{
            RefundPolicy::whereIn('id',$request->checked)->delete();
            
            Session::flash('success',trans('Deleted Successfully'));
            return redirect()->back();
            
        }
          
   }

    public function status(Request $request)
    {
        $user = RefundPolicy::find($request->id);
        $user->status = $request->status;
        $user->save();
        return response()->json($request->all());
    }
}
