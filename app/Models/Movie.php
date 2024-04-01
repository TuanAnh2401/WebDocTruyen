<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $fillable = ['name', 'avatar', 'name_call', 'studio_id', 'date_aired', 'status_id', 'scores', 'rating', 'duration', 'quality_id', 'views', 'vote', 'star', 'type_id', 'isDelete'];

    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'movie_genres', 'movie_id', 'genre_id');
    }
}
