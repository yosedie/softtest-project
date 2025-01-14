<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Notification;
use App\Notifications\OfferPushNotifications;
use Session;
use DotenvEditor;
use Spatie\Permission\Models\Role;


class OneSignalNotificationController extends Controller
{
    public function __construct()
    {
		$this->middleware('permission:push-notification.manage', ['only' => ['index','updateKeys','push']]);
    }
    public function index()
    {
        return view('admin.push_notification.index');
    }

    public function push(Request $request)
    {

        ini_set('max_excecution_time', -1);

        ini_set('memory_limit', -1);

        $request->validate([
            'subject' => 'required|string',
            'message' => 'required'
        ]);

        if(env('ONESIGNAL_APP_ID') =='' && env('ONESIGNAL_REST_API_KEY') == ''){

            \Session::flash('success', 'Please update onesignal keys in settings !');
            return back()->withInput();
        }

        try {

            $usergroup = User::query();

            $data = [
                'subject' => $request->subject,
                'body' => $request->message,
                'target_url' => $request->target_url ?? null,
                'icon' => $request->icon ?? null,
                'image' => $request->image ?? null,
                'buttonChecked' => $request->show_button ? "yes" : "no",
                'button_text' => $request->btn_text ?? null,
                'button_url' => $request->btn_url ?? null,
            ];

            if ($request->user_group == 'all_users') {

                $users = $usergroup->select('id')->where('role', '=', 'user')->get();

            } elseif ($request->user_group == 'all_instructors') {

                $users = $usergroup->select('id')->where('role', '=', 'instructors')->get();

            } elseif ($request->user_group == 'all_admins') {

                $users = $usergroup->select('id')->where('role', '=', 'admin')->get();

            } else {
                // all users
                $users = $usergroup->select('id')->get();
            }

            $users = $usergroup->select('id')->get();

            Notification::send($users, new OfferPushNotifications($data));

            \Session::flash('success', 'Notification pushed successfully !');
            return back();

        } catch (\Exception $e) {


             \Session::flash('delete', $e->getMessage());
            return back()->withInput();

        }

    }

    public function updateKeys(Request $request){

        $request->validate([
            'ONESIGNAL_APP_ID' => 'required|string',
            'ONESIGNAL_REST_API_KEY' => 'required|string'
        ],[
            'ONESIGNAL_APP_ID.required' => 'OneSignal app id is required',
            'ONESIGNAL_REST_API_KEY.required' => 'Onesignal rest api key is required'
        ]);


        $env_update = DotenvEditor::setKeys([
            'ONESIGNAL_APP_ID' => $request->ONESIGNAL_APP_ID,
            'ONESIGNAL_REST_API_KEY' => $request->ONESIGNAL_REST_API_KEY
        ]);

        $env_update->save();
        

        \Session::flash('success', 'Keys updated successfully !');
        return back();
    }


}
