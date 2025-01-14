<?php

namespace App\Http\Controllers;

use App\ManualPayment;
use Illuminate\Http\Request;
use File;
use Image;
use Session;
use App\Order;
use Redirect,Response;
use App\Cart;
use Auth;
use DB;
use App\Currency;
use App\Wishlist;
use Mail;
use App\Mail\SendOrderMail;
use App\Notifications\UserEnroll;
use App\Course;
use App\User;
use Notification;
use Carbon\Carbon;
use App\InstructorSetting;
use App\PendingPayout;
use App\Mail\AdminMailOnOrder;
use TwilioMsg;
use App\Setting;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class ManualPaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:payment-setting.manual-payment.view', ['only' => ['index','show']]);
        $this->middleware('permission:payment-setting.manual-payment.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:payment-setting.manual-payment.edit', ['only' => ['update','status']]);
        $this->middleware('permission:payment-setting.manual-payment.delete', ['only' => ['destroy', 'bulk_delete']]);
    
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payments = ManualPayment::orderBy('id', 'DESC')->get();
        return view('admin.manual_payment.index', compact('payments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.manual_payment.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->validate($request,[
            'image' => 'mimes:jpg,jpeg,png,bmp,tiff,webp,bmp',
            'detail' => 'required|max:5000',
            'name' => 'required|string|max:50|unique:manual_payment,name',

        ]);


        $input = $request->all();

        if($file = $request->file('image')) 
        {

            $path = 'images/manualpayment/';

            if(!file_exists(public_path().'/'.$path)) {
                
                $path = 'images/manualpayment/';
                File::makeDirectory(public_path().'/'.$path,0777,true);
            }

            $optimizeImage = Image::make($file);
            $optimizePath = public_path().'/images/manualpayment/';
            $image = time().$file->getClientOriginalName();
            $optimizeImage->save($optimizePath.$image, 72);

            $input['image'] = $image;
          
        }

        

        $input['status'] = isset($request->status)  ? 1 : 0;
       

        $data = ManualPayment::create($input);


        
        $data->save();

        Session::flash('success',trans('flash.AddedSuccessfully'));
        return redirect('manualpayment');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ManualPayment  $manualPayment
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $payment = ManualPayment::find($id);
        return view('admin.manual_payment.edit',compact('payment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ManualPayment  $manualPayment
     * @return \Illuminate\Http\Response
     */
    public function edit(ManualPayment $manualPayment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ManualPayment  $manualPayment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $payment = ManualPayment::findorfail($id);

        $request->validate([
            'name' => 'required|string|max:50|unique:manual_payment,name,' . $payment->id,
            'detail' => 'required|max:5000',
            'image' => 'mimes:jpg,jpeg,png,bmp,tiff,webp,bmp',
        ]);

        $input = $request->all();

        if($file = $request->file('image'))
        {
            if($payment->image != null) {
                $content = @file_get_contents(public_path().'/images/manualpayment/'.$payment->image);
                if ($content) {
                  unlink(public_path().'/images/manualpayment/'.$payment->image);
                }
            }

            $optimizeImage = Image::make($file);
            $optimizePath = public_path().'/images/manualpayment/';
            $image = time().$file->getClientOriginalName();
            $optimizeImage->save($optimizePath.$image, 72);

            $input['image'] = $image;
        }

        $input['status'] = isset($request->status)  ? 1 : 0;

       

        $payment->update($input);

        Session::flash('success',trans('flash.UpdatedSuccessfully'));
        return redirect('manualpayment'); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ManualPayment  $manualPayment
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $payment = ManualPayment::find($id);

        if ($payment->image != null)
        {
                
            $image_file = @file_get_contents(public_path().'/images/manualpayment/'.$payment->image);

            if($image_file)
            {
                unlink(public_path().'/images/manualpayment/'.$payment->image);
            }
        }
        
        $value = $payment->delete();

        if($value)
        {
            session()->flash('delete',trans('flash.DeletedSuccessfully'));
            return redirect('manualpayment');
        }
    }


    public function checkout(Request $request)
    {

        if($file = $request->file('proof'))
        {
            $name = time().$file->getClientOriginalName();
            $file->move('images/order', $name);
            $input['proof'] = $name;
        }


        $txn_id = str_random(8);

        $payment_method = $request->payment_name;

        $file = $name;

        $payment_status = '0';

        $checkout = new OrderStoreController;

        return $checkout->orderstore($txn_id, $payment_method, NULL, $file, $payment_status);


    }
    
    public function status(Request $request)
    {

        $user = ManualPayment::find($request->id);
        $user->status = $request->status;
        $user->save();
        return response()->json($request->all());
        
        
    }

     // This function performs bulk delete action
     public function bulk_delete(Request $request)
     {
         $validator = Validator::make($request->all(), ['checked' => 'required']);
         if ($validator->fails()) {
         return back()->with('error',trans('Please select field to be deleted.'));
         }
         ManualPayment::whereIn('id',$request->checked)->delete();
        Session::flash('delete', trans('Selected item has been deleted successfully !'));
        return redirect('manualpayment');
           
     }

    
}
