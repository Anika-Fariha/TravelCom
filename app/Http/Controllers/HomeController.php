<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country\Country;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Ensure the user is authenticated before accessing this controller
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Fetch countries from the database, ordered by ID in descending order
        $countries = Country::orderBy('id', 'desc')->get();

        // Return the 'home' view and pass the countries data to it
        return view('home', compact('countries'));
    }
}
