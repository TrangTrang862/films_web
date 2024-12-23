<?php

namespace App;


trait rateable
{
    public function rate($user, $rating)
    {
        $result = $this->ratings()->updateOrCreate(
            ['user_id' => $user->id, 'film_id' => $this->id],
            ['rating' => $rating]
        );
        $responce = array("status" => TRUE, "avg" => $this->ratings->avg('rating') ?? 0, "count" => $this->ratings->count() . ' Reviews');
        return $responce;
    }
}