<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Setting;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use App\Openai;
use Auth;
use Session;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Validator;
use DB;

class ChatgptController extends Controller
{
    public function text(Request $request){
        if (config('app.demolock') == 1) {
            $data['status'] = false;
            $data['msg'] = "Demo lock has been disbaled";
            return response()->json($data); 
        }
        $service = $request->service;
        $language = $request->language;
        $keyword = $request->keyword;
        $settings = Setting::first();
        $decryptedApiSecret = decrypt($settings->api_key);

        $prompt = "Genrate a $service in this $language with specific $keyword";
        $data = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer '.$decryptedApiSecret,
        ])
        ->post("https://api.openai.com/v1/chat/completions", [
            "model" => "gpt-3.5-turbo",
            'messages' => [
                [
                "role" => "user",
                "content" => $prompt
            ]
            ],
            'temperature' => 1.5,
            "max_tokens" => 150,
            "stop" => ["11."],
        ])
        ->json();
        $output = $data['choices'][0]['message']; 
        $newdata           = new Openai();
        $newdata->generate     = 'Text Generate';
        $newdata->user_id   = Auth::id();
        $newdata->prompt   = $prompt;
        $newdata->response = json_encode($output);
        $newdata->save();
        return $this->textoutput($output);
     }
     public function textoutput($output){
        $data = $output;
        $html = view('admin.openai.output', compact('data'))->render();
        return response()->json(compact('html'));
    }
    public function image(Request $request){
        if (config('app.demolock') == 1) {
            $data['status'] = false;
            $data['msg'] = "Demo lock has been disbaled";
            return response()->json($data); 
        }
        $prompt = $request->description;
        $settings = Setting::first();
        $decryptedApiSecret = decrypt($settings->api_key);
        $client = new Client();
        $url = 'https://api.openai.com/v1/images/generations';
        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $decryptedApiSecret,
        ];
        $data = [
            'model' => 'dall-e-3',
            'prompt' => $prompt,
            'n' => (int)$request->image_number_of_images,
            'size' => '1024x1024',
        ];
        $client = new Client();
        try {
        $response = $client->post($url, [
            'headers' => $headers,
            'json' => $data,
        ]);
        $result = json_decode($response->getBody(), true);
        $image_url = $response->getBody();
        $resp = json_decode($image_url);
        $imageUrl = $result['data'][0]['url'];
        foreach ($resp->data as $key => $value) {
        // Save the image to the specified folder within the public directory
        $contents = file_get_contents($imageUrl);
        $nameOfImage = Str::random(12) . '-' . Str::slug($request->prompt) . '.png';
        $imagePath =  public_path('images/openai/' . $nameOfImage);
        file_put_contents($imagePath, $contents);
        // Storage::put($imagePath, $contents);

        // Construct the public URL for the saved image
        $publicImageUrl = asset('/images/openai/' . $nameOfImage);
                $newdata  = new Openai();
                $newdata->generate  = 'Image Generate';
                $newdata->user_id   = Auth::id();
                $newdata->prompt   = $prompt;
                $newdata->response = $publicImageUrl;
                $newdata->save();
                }
        return $this->imagegenerate($imageUrl);
        } catch (\Exception $e) {
            // Handle exceptions (e.g., Guzzle HTTP errors)
            dd($e->getMessage());
        }
        }
        public function imagegenerate($imageUrl){
            $response = view('admin.openai.image', compact('imageUrl'))->render();
            $status = 'True';
            return response()->json(compact('response','status'));
        }
        public function useropenai()
            {
                // Check if the user is authenticated
                if (Auth::check()) {
                    // Check if the user has the 'admin' role
                    if (Auth::user()->role == 'admin') {
                        // Fetch all data for admin
                        $openai = Openai::orderBy('created_at', 'desc')->get();
                    } else {
                        // Fetch data specific to the authenticated user
                        $openai = Openai::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
                    }
                } else {
                    // User is not authenticated, handle accordingly
                    // For example, redirect to login page or display an error message
                    return redirect()->route('login');
                }
                
                // Pass data to the view
                return view('admin.openai.user', compact('openai'));
            }

    public function delete($id)
    {
        DB::table('openais')->where('id',$id)->delete();
        Session::flash('delete', trans('Deleted Successfully'));
        return redirect('user/openai');
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
                Openai::whereIn('id',$request->checked)->delete();
                
                Session::flash('success',trans('Deleted Successfully'));
                return redirect()->back();
                
            }  
    }
}
