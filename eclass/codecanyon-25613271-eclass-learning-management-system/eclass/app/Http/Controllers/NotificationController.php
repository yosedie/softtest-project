<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function markAsRead($id)
    {
    	$notification = Auth()->User()->unreadNotifications->where('id', $id)->markAsRead();
        return back();
    }

    public function delete()
    {
        
        $notifications = Auth()->User()->notifications()->get();

        foreach($notifications as $notification) {

            $notification->delete();
            
        }

        return back();
    }
}
