<?php

namespace App;

use App\Film;
use App\User;
use Illuminate\Database\Eloquent\Model;

class FilmClickHistory extends Model
{
    protected $table = 'film_click_histories';
    protected $fillable = [
        'user_id',
        'film_id',
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
