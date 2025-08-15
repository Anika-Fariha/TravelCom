<?php

namespace App\Http\Controllers;

use App\Models\User; 
use App\Models\Itinerary;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\GroupTrip;

class AdminController extends Controller
{
    // function for displaying the admin dashboard
    public function dashboard()
    {
        return view('admin.dashboard'); 
    }
    // Displaying the list of users
    public function index()
    {

        $users = User::all(); // Getting users from  database

        return view('admin.users.index', compact('users'));
    }

    //form to add a new user
    public function create()
    {
        return view('admin.users.create');
    }

    // Storing a new user in the database
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        //new user data
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password); 
        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'User created successfully!');
    }

    //deleting a user from database
    public function destroy($id)
    {
        //finding the user by ID
        $user = User::findOrFail($id);

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully!');
    }
    

    public function viewItineraries()
{
    // Fetching all itineraries with user data 
    $itineraries = Itinerary::with('user')->get();

    return view('admin.itineraries.index', compact('itineraries'));
}

    public function showItinerary($id)
    {
         
        $itinerary = Itinerary::with('user')->findOrFail($id); // Fetching a single itinerary with its details

        return view('admin.itineraries.show', compact('itinerary'));
    }

    public function viewGroupTrips()
{
    // Fetch all group trips created by any user 
    $groupTrips = GroupTrip::with('user') 
                        ->orderBy('created_at', 'desc') // latest created trips first
                        ->get();


    return view('admin.group_trips.index', compact('groupTrips'));
}


    public function viewNotifications()
{
    //fetching distinct notifications based on title and message
    $notifications = Notification::select('title', 'message', 'created_at')
        ->distinct() //only unique notifications
        ->orderByDesc('created_at')  // Order by the latest notification
        ->get();


    return view('admin.notifications.index', compact('notifications'));
}


   

}


