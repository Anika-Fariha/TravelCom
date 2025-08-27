<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'destination',
        'content',
        'image_data',
        'image_name'
    ];

    public function user() 
    {
        return $this->belongsTo(User::class);
    }

    public function likes() 
    {
        return $this->hasMany(Like::class);
    }

    public function comments() 
    {
        return $this->hasMany(Comment::class);
    }

    public function isLikedBy(?User $user): bool
    {
        if (!$user) return false;
        return $this->likes()->where('user_id', $user->id)->exists();
    }

    // Accessor to get image as a data URL for Blade
    public function getImageUrlAttribute()
    {
        if (!$this->image_data) return null;

        // Determine MIME type from filename
        $ext = pathinfo($this->image_name ?? '', PATHINFO_EXTENSION);

        $mime = match(strtolower($ext)) {
            'jpg', 'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            'webp' => 'image/webp',
            default => 'application/octet-stream',
        };

        $base64 = base64_encode($this->image_data);
        return "data:$mime;base64,$base64";
    }
}
