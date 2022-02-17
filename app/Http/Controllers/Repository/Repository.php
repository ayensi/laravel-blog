<?php

namespace App\Http\Controllers\Repository;

use App\Models\Article;

class Repository
{
    public function sortArticlesByRating(){
        return Article::with(['rating'])->withCount(['rating as rating' => function ($query) {
            $query->select(\DB::raw('coalesce(sum(rating), 0)'));
        }])->orderByDesc('rating');
    }
}
