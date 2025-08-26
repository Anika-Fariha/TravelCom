<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FriendshipController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ItineraryController;
use App\Http\Controllers\GroupTripController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\RecommendationController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Travelling
Route::get('travelling/about/{id}', [App\Http\Controllers\Travelling\TravellingController::class, 'about'])->name('travelling.about');

// Friendships
Route::get('/friends', [FriendshipController::class, 'viewFriends'])->name('friends.index');
Route::post('/friends/{friend_id}/send-request', [FriendshipController::class, 'sendRequest'])->name('friends.sendRequest');
Route::get('/friends/pending', [FriendshipController::class, 'viewPendingRequests'])->name('friends.pending');
Route::post('/friends/{friendship_id}/accept', [FriendshipController::class, 'acceptRequest'])->name('friends.accept');
Route::post('/friends/{friendship_id}/reject', [FriendshipController::class, 'rejectRequest'])->name('friends.reject');
Route::post('/friends/{friend_id}/undo', [FriendshipController::class, 'undoRequest'])->name('friends.undo');
Route::get('/friends/search', [FriendshipController::class, 'searchFriends'])->name('friends.search');

// Messages
Route::post('/messages/{receiver_id}', [MessageController::class, 'sendMessage'])->name('messages.send');
Route::get('/messages/{receiver_id}', [MessageController::class, 'fetchMessages'])->name('messages.fetch');

// Itineraries
Route::middleware('auth')->group(function () {
    Route::get('/itineraries', [ItineraryController::class, 'index'])->name('itineraries.index');
    Route::get('/itineraries/create', [ItineraryController::class, 'create'])->name('itineraries.create');
    Route::post('/itineraries', [ItineraryController::class, 'store'])->name('itineraries.store');
    Route::get('/itineraries/{id}/edit', [ItineraryController::class, 'edit'])->name('itineraries.edit');
    Route::put('/itineraries/{id}', [ItineraryController::class, 'update'])->name('itineraries.update');
    Route::delete('/itineraries/{id}', [ItineraryController::class, 'destroy'])->name('itineraries.destroy');
    Route::get('/itineraries/{id}', [ItineraryController::class, 'show'])->name('itineraries.show');

    // Share itineraries
    Route::post('/itineraries/{itinerary_id}/share-email/{friend_id}', [ItineraryController::class, 'shareWithEmail'])->name('itineraries.shareEmail');
    Route::post('/itineraries/{itinerary_id}/share', [ItineraryController::class, 'shareWithFriend'])->name('itineraries.share');
    Route::get('/test-email', [ItineraryController::class, 'testEmail']);
});

// Group Trips
Route::prefix('group-trips')->group(function () {
    Route::get('index', [GroupTripController::class, 'index'])->name('group_trips.index');
    Route::get('create', [GroupTripController::class, 'create'])->name('group_trips.create');
    Route::post('store', [GroupTripController::class, 'store'])->name('group_trips.store');
    Route::get('{id}', [GroupTripController::class, 'show'])->name('group_trips.show');
    Route::get('{id}/edit', [GroupTripController::class, 'edit'])->name('group_trips.edit');
    Route::put('{id}', [GroupTripController::class, 'update'])->name('group_trips.update');
    Route::delete('{id}', [GroupTripController::class, 'destroy'])->name('group_trips.destroy');
    Route::get('{id}/send-invitations', [GroupTripController::class, 'sendInvitations'])->name('group_trips.sendInvitations');
    Route::get('invitations', [GroupTripController::class, 'viewInvitations'])->name('group_trips.viewInvitations');
    Route::post('invitations/{id}/accept', [GroupTripController::class, 'acceptInvitation'])->name('group_trips.acceptInvitation');
    Route::post('invitations/{id}/reject', [GroupTripController::class, 'rejectInvitation'])->name('group_trips.rejectInvitation');
});

// Admin routes
Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Users
    Route::get('/users', [AdminController::class, 'index'])->name('admin.users.index');
    Route::get('/users/create', [AdminController::class, 'create'])->name('admin.users.create');
    Route::post('/users', [AdminController::class, 'store'])->name('admin.users.store');
    Route::delete('/users/{id}', [AdminController::class, 'destroy'])->name('admin.users.destroy');

    // Itineraries
    Route::get('/itineraries', [AdminController::class, 'viewItineraries'])->name('admin.itineraries.index');
    Route::get('/itineraries/{id}', [AdminController::class, 'showItinerary'])->name('admin.itineraries.show');

    // Group trips
    Route::get('/group-trips', [AdminController::class, 'viewGroupTrips'])->name('admin.group_trips.index');

    // Notifications
    Route::get('/notifications', [AdminController::class, 'viewNotifications'])->name('admin.notifications.index');
    Route::get('/send-notification', [NotificationController::class, 'viewNotifications'])->name('admin.notifications.view');
    Route::post('/send-notification', [NotificationController::class, 'sendNotification'])->name('admin.sendNotification');
});

// User notifications
Route::middleware('auth')->get('/notifications', [NotificationController::class, 'userNotifications'])->name('user.notifications');

// Posts, Likes, Comments, Activity, Recommendations
Route::middleware(['auth'])->group(function () {
    // Posts
    Route::get('/posts', [PostController::class,'index'])->name('posts.index');
    Route::post('/posts', [PostController::class,'store'])->name('posts.store');
    Route::delete('/posts/{post}', [PostController::class,'destroy'])->name('posts.destroy');

    // Likes
    Route::post('/posts/{post}/like', [LikeController::class,'toggle'])->name('posts.like');

    // Comments
    Route::post('/posts/{post}/comments', [CommentController::class,'store'])->name('posts.comments.store');
    Route::delete('/comments/{comment}', [CommentController::class,'destroy'])->name('comments.destroy');

    // Activity
    Route::get('/activity/liked', [ActivityController::class,'likedPosts'])->name('activity.liked');
    Route::get('/activity/commented', [ActivityController::class,'commentedPosts'])->name('activity.commented');

    // Recommendations
    Route::get('/recommendations/create', [RecommendationController::class,'create'])->name('recommendations.create');
    Route::post('/recommendations', [RecommendationController::class,'store'])->name('recommendations.store');
    Route::get('/recommendations', [RecommendationController::class,'index'])->name('recommendations.index');
    Route::patch('/recommendations/{recommendation}/read', [RecommendationController::class,'markAsRead'])->name('recommendations.read');
});
