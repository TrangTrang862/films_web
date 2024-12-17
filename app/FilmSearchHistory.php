<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class FilmSearchHistory extends Model
{
    protected $table = 'film_search_histories';
    protected $fillable = [
        'user_id',
        'key_search',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function film()
    {
        return $this->belongsTo(Film::class);
    }
}
