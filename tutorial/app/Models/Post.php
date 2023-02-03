<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Post extends Model
{

    public static function find($slug) {

        if ( !file_exists($path = resource_path("posts/my-{$slug}-post.html")) ) {
            throw new ModelNotFoundException('not found post');
        }
        
        return cache()->remember("posts.{$slug}", 1200, fn() => file_get_contents($path) );
    }
}
