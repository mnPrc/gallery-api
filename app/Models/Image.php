<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $fillable = ['imageUrl', 'gallery_id'];

    public function gallery()
    {
        return $this->belongsTo(Gallery::class);
    }
}
