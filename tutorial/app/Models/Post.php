<?php

namespace App\Models;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\File;
use Spatie\YamlFrontMatter\YamlFrontMatter;

class Post 
{

    public string $title;
    public int $slug;
    public string $body;

    public function __construct(string $title, int $slug, string $body)
    {
        $this->title = $title;
        $this->slug = $slug;
        $this->body = $body;
    }

    public static function all() {

        return cache()->remember('post.all', 1,  function(){
            return collect(File::files(resource_path("posts/")))
            ->map(fn ($file) => YamlFrontMatter::parseFile($file))
            ->map(fn ($document) => new Post(
                    $document->title,
                    $document->slug,
                    $document->body()
                )
            )
            ->sortBy('slug');
        });
    }

    public static function find($slug) {
        $post = static::all()->firstWhere('slug', $slug);
        return $post;
    }

    public static function findOrFail($slug) {
        $post = static::find($slug);

        if(! $post){
            throw new ModelNotFoundException('not found post');
        }

        return $post;
    }
}
