<?php

namespace App\Models; // Ensure correct namespace

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Movie;
class CtMovie extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ct_movie';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'movie_id',
        'episode_id',
        'link',
        'isBlock', // Adjusted to camel case (isBlock instead of isBlock)
        'isDelete', // Adjusted to camel case (isDelete instead of isDelete)
    ];

    /**
     * Get the movie record associated with the ct_movie.
     */
    public function movie()
    {
        return $this->belongsTo(Movie::class, 'movie_id'); // Specify the foreign key column name
    }

    /**
     * Get the episode record associated with the ct_movie.
     */
    public function episode()
    {
        return $this->belongsTo(Episode::class, 'episode_id'); // Specify the foreign key column name
    }
}
