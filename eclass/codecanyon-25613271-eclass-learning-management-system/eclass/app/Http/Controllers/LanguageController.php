<?php

namespace App\Http\Controllers;

use App\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Session;
use Spatie\Permission\Models\Role;


class LanguageController extends Controller
{
    public function __construct()
    {
    
        $this->middleware('permission:site-settings.language.view', ['only' => ['index','showlang']]);
        $this->middleware('permission:site-settings.language.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:site-settings.language.edit', ['only' => ['edit','update']]);
        $this->middleware('permission:site-settings.language.delete', ['only' => ['destroy','bulk_delete']]);
    
    }

   	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $languages = Language::all();
        return view('admin.language.index', compact('languages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.language.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'local' => 'required|unique:languages,local',
            'name' => 'required'
        ]);


        
        $input = $request->all();

        $all_def = Language::where('def','=',1)->get();

        if (isset($request->def)) {

            foreach ($all_def as $value) {
                $remove_def =  Language::where('id','=',$value->id)->update(['def' => 0]);
            }

             $input['def'] = 1;

        }else{
            if($all_def->count()<1)
            {
                return back()->with('delete','Atleast one language need to set default !');
            }

            $input['def'] = 0;
        }


        if (!is_dir(base_path() . '/resources/lang/' . $request->local)) {
            mkdir(base_path() . '/resources/lang/' . $request->local);
            copy(base_path() . '/resources/lang/en/frontstaticword.php', base_path() . '/resources/lang/' . $request->local . '/staticwords.php');
            copy(base_path() . '/resources/lang/en/adminstaticword.php', base_path() . '/resources/lang/' . $request->local . '/adminstaticwords.php');
        }
        if (is_dir(base_path() . '/resources/lang/')) {
            copy(resource_path() . '/lang/en.json', resource_path() . '/lang/' . $request->local . '.json');
        }
        Language::create($input);

        Session::flash('success', trans('flash.AddedSuccessfully'));
        return redirect('admin/lang');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $language = Language::findOrFail($id);
        return view('admin.language.edit', compact('language'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $language = Language::findOrFail($id);

        $all_def = Language::where('def','=',1)->get();


        $this->validate($request, [
            'local' => 'required|unique:languages,local,'.$id,
            'name' => 'required',
        ]);
      


        $input = $request->all();

        if (isset($request->def)) {

            

            foreach ($all_def as $value) {
                $remove_def =  Language::where('id','=',$value->id)->update(['def' => 0]);
            }

             $input['def'] = 1;

        }else{

            if($all_def->count()<1)
            {
                return back()->with('delete','Atleast one language need to set default !');
            }

            $input['def'] = 0;
        }

        
        $language->update($input);
        
        Session::flash('success', trans('flash.UpdatedSuccessfully'));
        return redirect('admin/lang');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $language = Language::findOrFail($id);
        if($language->def ==1){
             return back()->with('delete', trans('flash.CannotDeleteDefaultLanguage'));
            
        }else{

             $language->delete();
            return back()->with('delete', trans('flash.DeletedSuccessfully'));
        }
        
    }

    // This function performs bulk delete action
   public function bulk_delete(Request $request)
   {
    
          $validator = Validator::make($request->all(), ['checked' => 'required']);
          if ($validator->fails()) {
           return back()->with('error',trans('Please select field to be deleted.'));
          }
          Language::whereIn('id',$request->checked)->delete();
          Session::flash('delete', trans('Selected item has been deleted successfully !'));
          return redirect('admin/lang');
         
  }


    public function showlang() 
    {
        $languages = Language::all();
        return view('admin.language.show', compact('languages'));
    }

    public function frontstaticword($local)
    {
         //return $local;
        $findlang = Language::where('local', '=', $local)->first();

        if (isset($findlang))
        {

            if (file_exists(resource_path() .'/lang/' . $findlang->local . '/frontstaticword.php'))
            {
                $file = file_get_contents(resource_path() ."/lang/$findlang->local/frontstaticword.php");
                return view('admin.language.frontstatic.frontstatic', compact('findlang', 'file'));
            }
            else
            {

                if (is_dir(resource_path() .'/lang/' . $findlang->local))
                {
                    copy(resource_path() . "/lang/en/frontstaticword.php", resource_path().'/lang/' . $findlang->local . '/frontstaticword.php');

                    
                    $file = file_get_contents(resource_path(). "/lang/$findlang->local/frontstaticword.php");
                    return view('admin.language.frontstatic.frontstatic', compact('findlang', 'file'));
                }
                else
                {
                    mkdir(resource_path() .'/lang/' . $findlang->local);
                    copy(resource_path() ."/lang/en/frontstaticword.php", resource_path() .'/lang/' . $findlang->local . '/frontstaticword.php');
                    $file = file_get_contents(resource_path() ."/lang/$findlang->local/frontstaticword.php");
                    return view('admin.language.frontstatic.frontstatic', compact('findlang', 'file'));
                }

            }

        }
        else
        {
            return back()
                ->with('delete', trans('flash.NotFound'));
        }
    }

    public function frontupdate(Request $request, $local)
    {
        $findlang = Language::where('local', '=', $local)->first();
        if (isset($findlang))
        {

            $transfile = $request->transfile;
            file_put_contents(resource_path() .'/lang/' . $findlang->local . '/frontstaticword.php', $transfile . PHP_EOL);
            return back()->with('updated', trans('flash.UpdatedSuccessfully'));

        }
        else
        {
            return back()
                ->with('delete', trans('flash.NotFound'));
        }
    }


    public function adminstaticword($local)
    {
        $findlang = Language::where('local', '=', $local)->first();

        if (isset($findlang))
        {

            if (file_exists(resource_path() .'/lang/' . $findlang->local . '/adminstaticword.php'))
            {
                $file = file_get_contents(resource_path() ."/lang/$findlang->local/adminstaticword.php");
                return view('admin.language.adminstatic.adminstatic', compact('findlang', 'file'));
            }
            else
            {

                if (is_dir(resource_path() .'/lang/' . $findlang->local))
                {
                    copy(resource_path() ."/lang/en/adminstaticword.php", resource_path() .'/lang/' . $findlang->local . '/adminstaticword.php');
                    $file = file_get_contents(resource_path() ."/lang/$findlang->local/adminstaticword.php");
                    return view('admin.language.adminstatic.adminstatic', compact('findlang', 'file'));
                }
                else
                {
                    mkdir(resource_path() .'/lang/' . $findlang->local);
                    copy(resource_path() ."/lang/en/adminstaticword.php", resource_path() .'/lang/' . $findlang->local . '/adminstaticword.php');
                    $file = file_get_contents(resource_path() ."/lang/$findlang->local/adminstaticword.php");
                    return view('admin.language.adminstatic.adminstatic', compact('findlang', 'file'));
                }

            }

        }
        else
        {
            return back()
                ->with('delete', trans('flash.NotFound'));
        }
    }

    public function adminupdate(Request $request, $local)
    {
        // return 'x';
        $findlang = Language::where('local', '=', $local)->first();
        if (isset($findlang))
        {

            $transfile = $request->transfile;
            file_put_contents(resource_path() .'/lang/' . $findlang->local . '/adminstaticword.php', $transfile . PHP_EOL);
            return back()->with('updated', trans('flash.UpdatedSuccessfully'));

        }
        else
        {
            return back()
                ->with('delete', trans('flash.NotFound'));
        }
    }



    public function flashmsgword($local)
    {
        $findlang = Language::where('local', '=', $local)->first();

        if (isset($findlang))
        {

            if (file_exists(resource_path() .'/lang/' . $findlang->local . '/flash.php'))
            {
                $file = file_get_contents(resource_path() ."/lang/$findlang->local/flash.php");
                return view('admin.language.flashmsg.flashmsg', compact('findlang', 'file'));
            }
            else
            {

                if (is_dir(resource_path() .'/lang/' . $findlang->local))
                {
                    copy(resource_path() ."/lang/en/flash.php", resource_path() .'/lang/' . $findlang->local . '/flash.php');
                    $file = file_get_contents(resource_path() ."/lang/$findlang->local/flash.php");
                    return view('admin.language.flashmsg.flashmsg', compact('findlang', 'file'));
                }
                else
                {
                    mkdir(resource_path() .'/lang/' . $findlang->local);
                    copy(resource_path() ."/lang/en/flash.php", resource_path() .'/lang/' . $findlang->local . '/flash.php');
                    $file = file_get_contents(resource_path() ."/lang/$findlang->local/flash.php");
                    return view('admin.language.flashmsg.flashmsg', compact('findlang', 'file'));
                }

            }

        }
        else
        {
            return back()
                ->with('delete', trans('flash.NotFound'));
        }
    }

    public function flashupdate(Request $request, $local)
    {
        $findlang = Language::where('local', '=', $local)->first();
        if (isset($findlang))
        {

            $transfile = $request->transfile;
            file_put_contents(resource_path() .'/lang/' . $findlang->local . '/flash.php', $transfile . PHP_EOL);
            return back()->with('updated', trans('flash.UpdatedSuccessfully'));

        }
        else
        {
            return back()
                ->with('delete', trans('flash.NotFound'));
        }
    }

  
}
