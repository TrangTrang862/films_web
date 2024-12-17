<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FilmView extends Model
{
    protected $table = 'film_views';

    protected $fillable = ['film_id', 'user_id', 'views_count'];

    public $timestamps = true;
}
