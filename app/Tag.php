<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['name'];

    public function posts()
    {
        return $this->morphByMany(Post::class, 'taggable');
    }

    public function portfolios()
    {
        return $this->morphByMany(Portfolio::class, 'taggable');
    }

}
