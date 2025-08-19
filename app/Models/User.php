<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // Assuming you have a role column for user roles
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function sentRequests()
    {
        return $this->hasMany(Friendship::class, 'user_id');
    }

    public function receivedRequests()
    {
        return $this->hasMany(Friendship::class, 'friend_id');
    }

    public function friends()
    {
        return $this->belongsToMany(User::class, 'friendships', 'user_id', 'friend_id')
                    ->wherePivot('status', 'accepted');
    }

    public function pendingFriends()
    {
        return $this->belongsToMany(User::class, 'friendships', 'user_id', 'friend_id')
                    ->wherePivot('status', 'pending');
    }

    // User model (User.php)
    public function itineraries()
    {
        return $this->hasMany(Itinerary::class);
    }
    public function sharedItineraries()
    {
        return $this->belongsToMany(Itinerary::class, 'shared_itineraries')->withTimestamps();
    }


    public function posts() { return $this->hasMany(\App\Models\Post::class); }
    public function likes() { return $this->hasMany(\App\Models\Like::class); }
    public function comments() { return $this->hasMany(\App\Models\Comment::class); }
    public function sentRecommendations() { return $this->hasMany(\App\Models\Recommendation::class, 'sender_id'); }
    public function receivedRecommendations() { return $this->hasMany(\App\Models\Recommendation::class, 'receiver_id'); }

}