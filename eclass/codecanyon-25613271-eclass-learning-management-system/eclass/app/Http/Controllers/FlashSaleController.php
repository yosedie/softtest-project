<?php

namespace App\Http\Controllers;

use App\AddSubVariant;
use App\Flashsale;
use App\Course;
use App\setting;

use Illuminate\Http\Request;
use Image;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;


class FlashSaleController extends Controller
{
    public function __construct()
    {
    
        $this->middleware('permission:flash-deals.view', ['only' => ['index','view','list']]);
        $this->middleware('permission:flash-deals.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:flash-deals.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:flash-deals.delete', ['only' => ['destroy']]);
    
    }
    public function index()
    {
        if(request()->ajax()){

            $deals = Flashsale::select('id','title','start_date','end_date','background_image','position');

            return DataTables::of($deals)
            ->addIndexColumn()
            ->addColumn('background_image', function ($row)
            {
                $image = '<img style="object-fit:scale-down;" width="100px" src="' . url("/images/flashdeals/" . $row->background_image) . '"/>';
                return $image;
            })
            ->editColumn('action', 'admin.flashsale.action')
            ->rawColumns(['background_image', 'action'])
            ->make(true);

        }
        return view('admin.flashsale.index');
    }

    public function create()
    {
        return view('admin.flashsale.create');
    }

    public function edit($id)
    {
        $deal = Flashsale::findorfail($id);
        return view('admin.flashsale.edit',compact('deal'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'title' => 'required|string',
            'background_image' => 'required',
            'background_image' => 'mimes:jpg,jpeg,png,gif,webp',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);
        
        DB::beginTransaction();

        $newdeal = new Flashsale();

        $input = $request->all();

        if (!is_dir(public_path() . '/images/flashdeals')) {
            mkdir(public_path() . '/images/flashdeals');
        }

        if($request->hasFile('background_image')){

            $image = $request->file('background_image');
            $input['background_image'] = 'flashdeal_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images/flashdeals');
            $img = Image::make($image->path());

            $img->save($destinationPath . '/' . $input['background_image']);

        }

        $input['detail'] = clean($request->detail);

        $input['start_date'] = date('Y-m-d H:i:s',strtotime($request->start_date));
        $input['end_date'] = date('Y-m-d H:i:s',strtotime($request->end_date));
        $input['status'] = $request->status ? 1 : 0;
    
        $newdeal = $newdeal->create($input);

        foreach($request->course as $key => $course){

            $newdeal->saleitems()->create([
                'sale_id'           => $newdeal->id,
                'course_id'        => $request->course_id[$key],
                'discount'          => $request->discount[$key],
                'discount_type'     => $request->discount_type[$key]
            ]);

        }

        DB::commit();

       return redirect()->route('flash-sales.index')->with('added', 'Flashdeal has been created !');

    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);

        DB::beginTransaction();

        $newdeal = Flashsale::findorfail($id);

        $input = $request->all();

        if($request->hasFile('background_image')){

            $request->validate([
                'background_image' => 'required|mimes:jpg,jpeg,png,gif,webp'
            ]);

            $image = $request->file('background_image');
            $input['background_image'] = 'flashdeal_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images/flashdeals');
            $img = Image::make($image->path());

            if ($newdeal->background_image != '' && file_exists(public_path() . '/images/flashdeals/' . $newdeal->background_image)) {
                unlink(public_path() . '/images/flashdeals/' . $newdeal->background_image);
            }
            
            $img->save($destinationPath . '/' . $input['background_image']);

        }

        $input['detail'] = clean($request->detail);
        $input['start_date'] = date('Y-m-d H:i:s',strtotime($request->start_date));
        $input['end_date'] = date('Y-m-d H:i:s',strtotime($request->end_date));
        $input['status'] = $request->status ? 1 : 0;
        $newdeal->update($input);

        $newdeal->saleitems()->delete();

        foreach($request->course as $key => $course){

            $newdeal->saleitems()->create([
                'sale_id'           => $newdeal->id,
                'course_id'        => $request->course_id[$key],
                'discount'          => $request->discount[$key],
                'discount_type'     => $request->discount_type[$key]
            ]);

        }

        DB::commit();

        return back()->with('updated', __('Flashdeal has been updated !'));

    }

    public function destroy($id)
    {

        $newdeal = Flashsale::findorfail($id);
        if ($newdeal->background_image != '' && file_exists(public_path() . '/images/flashdeals/' . $newdeal->background_image)) {
            unlink(public_path() . '/images/flashdeals/' . $newdeal->background_image);
        }
        $newdeal->saleitems()->delete();
        $newdeal->delete();
        return back()->with('deleted', 'Flashdeal has been updated !');

    }

    public function fetch(Request $request){


        if ($request->ajax()) {
            $query = $request->get('term');
            $data = Course::where('title', 'LIKE', '%' . $query . '%')->where('status', '=', 1)->where('type', 1)->get();
            $result = [];
            foreach ($data as $key => $value) {
                $result[] = ['id' => $value->id, 'value' => $value->title ];
            }
            return response()->json($result);
        }
        
        

    }

    public function list(){

        $deals = Flashsale::withCount('saleitems')->whereHas('saleitems')->where('status','1')->whereDate('end_date','>=',now())->paginate(12);

        require_once('price.php');
        $setting = setting::first();
        if($setting->theme == '1'){
        return view('front.deals',compact('deals'));
        }
        return view('theme_2.front.deals',compact('deals'));


    }

    public function view($id,$slug){

        $deal = Flashsale::with('saleitems')
                ->whereHas('saleitems')
                ->where('status','1')
                ->whereDate('end_date','>=',now())
                ->where('id',$id)->firstorfail();

        require_once('price.php');
        $setting = setting::first();
        if($setting->theme == '1'){
        return view('front.viewdeal',compact('deal'));
        }
        return view('theme_2.front.viewdeal',compact('deal'));


    }

    public function sort(Request $request){

        $data= $request->all();
     
        $posts = Flashsale::all();
       
        $pos = $data['id'];
        
        $position =json_encode($data);
     
        foreach ($posts as $key => $item) {
        
            Flashsale::where('id', $item->id)->update(array('position' => $pos[$key]));
        }

        return response()->json(['msg'=>'Updated Successfully', 'success'=>true]);


    }
    public function getDeals(){
        $data = Flashsale::get();
        return response()->json(['data'=> $data, 'success'=>true]);


    }
}
