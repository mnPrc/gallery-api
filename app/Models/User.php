<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'money',
        'email',
        'password'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return[];
    }

    public function galleries() {
        return $this->hasMany(Gallery::class);
    }
    
    public function wishlist() {
        return $this->belongsTo(Wishlist::class);
    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }

    public function likedComments(){
        return $this->belongsToMany(Comment::class, 'liked_comments', 'user_id', 'comment_id');
    }

    public function dislikedComments(){
        return $this->belongsToMany(Comment::class, 'disliked_comments', 'user_id', 'comment_id');
    }

    public function hasLikedComment(Comment $comment){
        return $this->likedComments()->where('comment_id', $comment->id)->exists();
    }

    public function hasDislikedComment(Comment $comment){
        return $this->dislikedComments()->where('comment_id', $comment->id)->exists();
    }

}
