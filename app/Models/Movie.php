<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'avatar',
        'name_call',
        'studio_id',
        'date_aired',
        'status_id',
        'scores',
        'rating',
        'duration',
        'quality_id',
        'views',
        'vote',
        'star',
        'type_id',
        'quantity',
        'isDelete',
    ];

    // Define relationships
    public function studio()
    {
        return $this->belongsTo(Studio::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function quality()
    {
        return $this->belongsTo(Quality::class);
    }
    
    public function type()
    {
        return $this->belongsTo(FilmFormat::class, 'type_id');
    }
    public function episodes()
    {
        return $this->belongsToMany(Episode::class, 'ct_movie', 'movie_id', 'episode_id')->withPivot('link');
    }
    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'movie_genres');
    }
    public function filmformat()
    {
        return $this->belongsTo(FilmFormat::class, 'type_id');
    }
    public function comments()
    {
        return $this->hasMany(Comments::class);
    }public function ctEpisodes()
    {
        return $this->hasMany(CtMovie::class, 'movie_id');
    }
}
