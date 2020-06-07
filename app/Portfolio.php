<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    protected $fillable = [
        'user_id', 'title', 'body'
    ];

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

}
