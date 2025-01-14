<?php 
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\User;
use Session;


class DeleteAccountController extends Controller
{
    public function store(Request $request)
{
    $request->validate([
        'deleteReason' => 'required|string',
    ]);

    $id = Auth::user()->id;
    $user = User::find($id);

    if (!$user) {
        return redirect()->back()->withErrors(['message' => 'User not found']);
    }

    $user->delete_request = 1;
    $user->delete_reason = $request->deleteReason;
    $user->save();

    return redirect()->back()->with('message', 'Delete request submitted successfully');
}



    public function useraccountdelete()
    {
    $users = User::where('delete_request', 1)->get();
    return view('admin.user.requests', compact('users'));
    }


    public function delete($id)
    {
       User::where('id',$id)->delete();
        Session::flash('delete', trans('Deleted Successfully'));
        return redirect('admin/user-requests');
    }

     // This function performs bulk delete action
   public function bulk_delete(Request $request)
   {
       $validator = Validator::make($request->all(), [
                'checked' => 'required',
            ]);
            if ($validator->fails()) {
                return back()->with('warning', 'Atleast one item is required to be checked');
            }
            else{
                User::whereIn('id',$request->checked)->delete();
                Session::flash('success',trans('Deleted Successfully'));
                return redirect()->back();
                
            }  
    }
}


