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
    public function episodes()
    {
        return $this->belongsToMany(Episode::class, 'ct_movie', 'movie_id', 'episode_id')->withPivot('link');
    }
    public function studio()
    {
        return $this->belongsTo(Studio::class, 'studio_id');
    }
    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }
    public function quality()
    {
        return $this->belongsTo(Quality::class, 'quality_id');
    }
    public function filmformat()
    {
        return $this->belongsTo(FilmFormat::class, 'type_id');
    }
    public function comments()
    {
        return $this->hasMany(Comments::class);
    }

    
}
