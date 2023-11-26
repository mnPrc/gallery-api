<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'user_id'];

    public function images() 
    {
        return $this->hasMany(Image::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->with('user');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
