<?php

namespace App\Http\Controllers;

use App\Models\GroupTrip;
use App\Models\GroupTripInvitation;
use App\Models\User;
use App\Models\City\City; // Assuming you have a City model
use Illuminate\Http\Request;

class GroupTripController extends Controller
{

    public function index()
    {
        // Fetch all group trips created by the authenticated user
        $groupTrips = GroupTrip::where('created_by', auth()->id())->get();

        // Get all invitations for the logged-in user
        $invitations = GroupTripInvitation::where('friend_id', auth()->id())
                                            ->where('status', 'pending')
                                            ->get();

        // Fetch all accepted group trips the user has been invited to
        $acceptedGroupTrips = GroupTrip::whereHas('invitations', function ($query) {
            $query->where('friend_id', auth()->id())
                ->where('status', 'confirmed'); // Filter by "confirmed" status
        })->get();

        return view('group_trips.index', compact('groupTrips', 'invitations', 'acceptedGroupTrips'));
    }

    public function create()
    {
        // Fetch all cities from the database
        $cities = City::all(); // Assuming you have a City model and cities table
    
        // Get the logged-in user's friends (assuming 'friends' relationship is defined in the User model)
        $friends = auth()->user()->friends; 
    
        return view('group_trips.create', compact('cities', 'friends'));  // Pass cities and friends to the view
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'destination' => 'required|exists:cities,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'description' => 'nullable|string',
            'friends' => 'nullable|array', // Validate friends as an array
            'friends.*' => 'exists:users,id', // Validate each friend ID exists in the users table
        ]);
    
        // Create the group trip and assign the authenticated user as the creator (created_by)
        $groupTrip = GroupTrip::create([
            'user_id' => auth()->id(), // Assign the authenticated user's ID
            'created_by' => auth()->id(), // Ensure the created_by field is populated
            'name' => $request->name,
            'destination' => $request->destination,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'description' => $request->description,
        ]);
    
        // Add friends to the group trip (inviting them)
        if ($request->has('friends')) {
            foreach ($request->friends as $friendId) {
                GroupTripInvitation::create([
                    'group_trip_id' => $groupTrip->id,
                    'friend_id' => $friendId,
                    'status' => 'pending', // Default status is 'pending'
                ]);
            }
        }
    
        return redirect()->route('group_trips.index')->with('success', 'Group trip created and invitations sent!');
    }

    public function show($id)
    {
        // Find the group trip by ID, and eager load any related data (e.g., invitations, friends)
        $groupTrip = GroupTrip::with('invitations')->findOrFail($id);

        // Return the view and pass the group trip data
        return view('group_trips.show', compact('groupTrip'));
    }

    
    

    // Send invitations to friends
    public function sendInvitations(Request $request, $groupTripId)
    {
        $groupTrip = GroupTrip::findOrFail($groupTripId);
        $friends = $request->input('friends');  // Array of friend ids

        foreach ($friends as $friendId) {
            GroupTripInvitation::create([
                'group_trip_id' => $groupTrip->id,
                'friend_id' => $friendId,
                'status' => 'pending',
            ]);
        }

        return redirect()->route('group_trips.index', $groupTripId)->with('success', 'Invitations sent successfully!');
    }



    // Accept an invitation
    public function acceptInvitation($invitationId)
    {
        // Find the invitation by ID
        $invitation = GroupTripInvitation::findOrFail($invitationId);
    
        // Change the status of the invitation to 'confirmed'
        $invitation->status = 'confirmed';
        $invitation->save();
    
        // Add the user to the group trip (if not already added)
        //$groupTrip = $invitation->groupTrip;
        //$groupTrip->users()->attach(auth()->id());  // Add the current user to the group trip
    
        // Redirect to 'My Trips' or the index page
        return redirect()->route('group_trips.index')->with('success', 'Invitation accepted and added to your trips!');
    }
    

    // Reject an invitation
    public function rejectInvitation($invitationId)
    {
        $invitation = GroupTripInvitation::findOrFail($invitationId);
        $invitation->status = 'declined';
        $invitation->save();

        return redirect()->route('group_trips.index', $invitation->group_trip_id)->with('success', 'Invitation declined!');
    }
}
