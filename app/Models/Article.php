<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Article extends Model
{
    use HasFactory;
    use Searchable;

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function rating()
    {
        return $this->hasMany(Rating::class);
    }
        public function comment()
    {
        return $this->hasMany(Comment::class);
    }


    public function searchableAs()
    {
        return 'articles_index';
    }

}
