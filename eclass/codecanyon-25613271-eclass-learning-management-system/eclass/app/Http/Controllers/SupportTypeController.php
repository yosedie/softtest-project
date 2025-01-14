<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SupportType;
use Illuminate\Support\Facades\Validator;
use Session;


class SupportTypeController extends Controller
{

    // public function __construct()
    // {
    //     $this->middleware('permission:support_type.view', ['only' => ['index','show']]);
    //     $this->middleware('permission:support_type.create', ['only' => ['store']]);
    //     $this->middleware('permission:support_type.edit', ['only' => ['edit','update']]);
    //     $this->middleware('permission:support_type.delete', ['only' => ['destroy','bulk_delete']]);
    // }



    public function index()
    {
        return view('admin.support_type.index');
    }

    public function create()
    {
        return view('admin.support_type.create');
    }

    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required',
        ]);
        $support = new SupportType;
        $support->name = $request->input('name');
        $support->save();
        return redirect('admin/support/type')->with('success', 'Data has been added.');
    }

    public function show()
    {
        $support = SupportType::orderBy('created_at' , 'desc')->paginate(7);
        return view('admin.support_type.index',compact('support'));
    }

    public function edit(string $id)
    {
        $support = SupportType::find($id);
        return view('admin.support_type.edit', compact('support'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $support = SupportType::find($id);
        $support->name = $request->input('name');
        $support->save();
        return redirect('admin/support/type')->with('success', 'Data has been updated.');

    }

    public function destroy($id)
    {
        $support = SupportType::find($id);
        $support->delete();
        return redirect('admin/support/type')->with('success', 'Data Deleted Successfully');
    }

    public function bulk_delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'checked' => 'required',
        ]);
        if ($validator->fails()) {
            return back()->with('warning', 'Atleast one item is required to be checked');

        } else {
            SupportType::whereIn('id', $request->checked)->delete();
            Session::flash('success', trans('Deleted Successfully'));
            return redirect()->back();

        }
    }
}
