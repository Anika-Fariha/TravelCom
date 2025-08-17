<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    // View notifications (for admin to see all sent notifications)
    public function viewNotifications()
    {
        //latest notification first
        $notifications = Notification::orderByDesc('created_at')->get();
        return view('admin.notifications.index', compact('notifications'));
    }

    // Send notification to all users
    public function sendNotification(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        
        $users = User::all();

        //creating notifications for each user
        
        foreach ($users as $user) {
            Notification::create([
                'title' => $request->title,
                'message' => $request->message,
                'user_id' => $user->id, //notification with each user
            ]);
        }
        

        return redirect()->route('admin.notifications.index')->with('success', 'Notifications sent successfully!');
    }
    
    public function userNotifications()
    {
        //notifications on the user side
        $notifications = Notification::where('user_id', auth()->id())  
                                    ->orderByDesc('created_at')        
                                    ->get();   // retrieving notifications

        return view('user.notifications.index', compact('notifications'));
    }
}
