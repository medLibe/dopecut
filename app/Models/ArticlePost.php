<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ArticlePost extends Model
{
    use HasFactory;

    protected $fillable = [
        'image_headline',
        'title',
        'author',
        'content',
        'content_headline',
        'slug',
        'created_by',
        'updated_by',
        'is_active',
    ];

    function getAllArticle()
    {
        $data = DB::table("article_posts")->where('is_active', 1)->get();

        return $data;
    }

    function getRandomArticle()
    {
        $data = DB::table('article_posts')->where('is_active', 1)
                                          ->inRandomOrder()
                                          ->limit(4)
                                          ->get();

        return $data;
    }

    function getOtherArticle($slug)
    {
        $data = DB::table('article_posts')->where('slug', '!=', $slug)
                                          ->where('is_active', 1)
                                          ->inRandomOrder()
                                          ->limit(5)
                                          ->get();

        return $data;
    }
}
