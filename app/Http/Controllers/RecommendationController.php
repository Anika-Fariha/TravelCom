<?php

namespace App\Http\Controllers;

use App\Models\Recommendation;
use App\Models\Itinerary;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecommendationController extends Controller
{
    public function __construct() 
    {
        $this->middleware('auth');
    }

    // Show the form to send a recommendation
    public function create()
    {
        // Fetch current user's itineraries
        $itineraries = Itinerary::where('user_id', Auth::id())
            ->orderBy('destination', 'asc')
            ->get(['id', 'destination', 'start_date', 'end_date', 'budget']); // Fetch additional fields

        // Fetch all users (except the logged-in user) for the receiver selection
        $users = User::where('id', '!=', Auth::id())->get(['id', 'name']);

        // Fetch recommendations sent to current user
        $inbox = Recommendation::where('receiver_id', Auth::id())
            ->with(['sender', 'itinerary'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('recommendations.create', compact('itineraries', 'users', 'inbox'));
    }

    // Store the recommendation
    public function store(Request $request)
    {
        $data = $request->validate([
            'receiver_id' => ['required','exists:users,id'],
            'itinerary_id' => ['required','exists:itineraries,id'],
            'message' => ['nullable','string','max:255'],
        ]);
        $data['sender_id'] = Auth::id();

        // Make sure user owns the itinerary they are sharing
        abort_unless(Itinerary::where('id', $data['itinerary_id'])->where('user_id', Auth::id())->exists(), 403);

        Recommendation::create($data);
        return redirect()->route('recommendations.index')->with('success', 'Recommendation sent.');
    }

    // Inbox: What people sent to me
    public function index()
    {
        $inbox = Recommendation::with(['sender', 'itinerary'])
            ->where('receiver_id', Auth::id())
            ->latest()
            ->paginate(10);
        return view('recommendations.index', compact('inbox'));
    }

    // Mark recommendation as read
    public function markAsRead(Recommendation $recommendation)
    {
        abort_unless($recommendation->receiver_id === Auth::id(), 403);
        $recommendation->update(['status' => 'read']);
        return back()->with('success', 'Marked as read.');
    }
}
