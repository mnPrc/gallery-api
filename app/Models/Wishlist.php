<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'gallery_id',
        'image_id',
    ];

    public function user() 
    {
        return $this->belongsTo(User::class);
    }
    
    public function gallery() 
    {
        return $this->belongsTo(Gallery::class);
    }

}
