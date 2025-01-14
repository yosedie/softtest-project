<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PlayerSetting;
use Spatie\Permission\Models\Role;

class PlayerSettingController extends Controller
{
  public function __construct()
  {
      $this->middleware('permission:player-settings.manage', ['only' => ['get','update']]);
  }
    public function get()
    {
    	$ps = PlayerSetting::first();
    	return view('admin.playersetting.edit',compact('ps'));
    }

    public function update(Request $request)
    {

      $request->validate([
          'logo' => 'mimes:png,jpg,jpeg,webm'
      ]);

      $ps = PlayerSetting::first();

      $input = $request->all();

        if(isset($ps))
        {
            $ps->cpy_text = $request->cpy_text;
            $ps->subtitle_font_size = $request->subtitle_font_size;
            $ps->subtitle_color = $request->subtitle_color;
            $ps->skin = $request->skin;
      

            if(isset($request->logo_enable))
              {
                $ps->logo_enable = 1;
              }
              else
              {
                $ps->logo_enable = 0;
              }

              if(isset($request->share_enable))
              {
                $ps->share_enable = 1;
              }
              else
              {
                $ps->share_enable = 0;
              }
              if(isset($request->embedded_enable))
              {
                $ps->embedded_enable = 1;
              }
              else
              {
                $ps->embedded_enable = 0;
              }
              if(isset($request->autoplay))
              {
                $ps->autoplay = 1;
              }
              else
              {
                $ps->autoplay = 0;
              } 
              if(isset($request->loop_video))
              {
                $ps->loop_video = 1;
              }
              else
              {
                $ps->loop_video = 0;
              }

              if(isset($request->chrome_cast))
              {
                $ps->chrome_cast = 1;
              }
              else
              {
                $ps->chrome_cast = 0;
              }

              if(isset($request->download))
              {
                $ps->download = 1;
              }
              else
              {
                $ps->download = 0;
              }


              if($file = $request->file('logo'))
              {

                 $name = 'logo.png';

                  if($ps->logo !="")
                  {
                    $content = @file_get_contents(public_path().'/content/minimal_skin_dark/'.$ps->logo);

                      if($content) {
                        unlink(public_path().'/content/minimal_skin_dark/'.$ps->logo);
                      }
                  }

                  $file->move('content/minimal_skin_dark', $name);
                  
                  $ps->logo = $name;

                }
            
            $ps->save();
        }
        else
        {
              $ps->cpy_text = $request->cpy_text;
              $ps->subtitle_font_size = $request->subtitle_font_size;
              $ps->subtitle_color = $request->subtitle_color;
            
              if ($file = $request->file('logo'))
                {

                  $name = 'logo.png';

                  $optimizeImage = Image::make($file);
                  $optimizePath = public_path().'/content/minimal_skin_dark/';
                  $image = time().$file->getClientOriginalName();
                  $optimizeImage->save($optimizePath.$image, 72);
                  $input['logo'] = $name;

                }
            

            $ps = PlayerSetting::create($input);
          
            $ps->save();
        }
    	
    	 return back()->with('success',trans('flash.UpdatedSuccessfully'));
    }
}
