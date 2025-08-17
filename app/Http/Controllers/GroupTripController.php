<?php

namespace App\Http\Controllers;

use App\Models\GroupTrip;
use App\Models\GroupTripInvitation;
use App\Models\User;
use App\Models\City\City;
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
                ->where('status', 'confirmed');
        })->get();

        return view('group_trips.index', compact('groupTrips', 'invitations', 'acceptedGroupTrips'));
    }

    public function create()
    {
        // Fetch all cities from the database
        $cities = City::all();
        // Get the logged-in user's friends
        $friends = auth()->user()->friends;
        return view('group_trips.create', compact('cities', 'friends'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'destination' => 'required|exists:cities,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'description' => 'nullable|string',
            'friends' => 'nullable|array',
            'friends.*' => 'exists:users,id',
        ]);

        // Create the group trip
        $groupTrip = GroupTrip::create([
            'user_id' => auth()->id(),
            'created_by' => auth()->id(),
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
                    'status' => 'pending',
                ]);
            }
        }

        return redirect()->route('group_trips.index')->with('success', 'Group trip created and invitations sent!');
    }

    public function edit($id)
    {
        $groupTrip = GroupTrip::findOrFail($id);
        $cities = City::all();
        $friends = auth()->user()->friends;
        return view('group_trips.edit', compact('groupTrip', 'cities', 'friends'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'destination' => 'required|exists:cities,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'description' => 'nullable|string',
            'friends' => 'nullable|array',
            'friends.*' => 'exists:users,id',
        ]);

        $groupTrip = GroupTrip::findOrFail($id);
        $groupTrip->update([
            'name' => $request->name,
            'destination' => $request->destination,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'description' => $request->description,
        ]);

        // Update invitations for friends (optional)
        if ($request->has('friends')) {
            // First, clear old invitations
            $groupTrip->invitations()->delete();

            // Then add new invitations
            foreach ($request->friends as $friendId) {
                GroupTripInvitation::create([
                    'group_trip_id' => $groupTrip->id,
                    'friend_id' => $friendId,
                    'status' => 'pending',
                ]);
            }
        }

        return redirect()->route('group_trips.index')->with('success', 'Group trip updated successfully!');
    }

    public function destroy($id)
    {
        $groupTrip = GroupTrip::findOrFail($id);

        // Delete associated invitations before deleting the group trip
        $groupTrip->invitations()->delete();

        $groupTrip->delete();

        return redirect()->route('group_trips.index')->with('success', 'Group trip and its invitations deleted successfully.');
    }

    public function show($id)
    {
        $groupTrip = GroupTrip::with('invitations')->findOrFail($id);
        return view('group_trips.show', compact('groupTrip'));
    }

    public function sendInvitations(Request $request, $groupTripId)
    {
        $groupTrip = GroupTrip::findOrFail($groupTripId);
        $friends = $request->input('friends');

        foreach ($friends as $friendId) {
            GroupTripInvitation::create([
                'group_trip_id' => $groupTrip->id,
                'friend_id' => $friendId,
                'status' => 'pending',
            ]);
        }

        return redirect()->route('group_trips.index')->with('success', 'Invitations sent successfully!');
    }

    public function acceptInvitation($invitationId)
    {
        $invitation = GroupTripInvitation::findOrFail($invitationId);
        $invitation->status = 'confirmed';
        $invitation->save();

        return redirect()->route('group_trips.index')->with('success', 'Invitation accepted!');
    }

    public function rejectInvitation($invitationId)
    {
        $invitation = GroupTripInvitation::findOrFail($invitationId);
        $invitation->status = 'declined';
        $invitation->save();

        return redirect()->route('group_trips.index')->with('success', 'Invitation declined!');
    }
}
