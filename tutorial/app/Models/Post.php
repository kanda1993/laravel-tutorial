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
        return collect(File::files(resource_path("posts/")))
            ->map(fn ($file) => YamlFrontMatter::parseFile($file))
            ->map(fn ($document) => new Post(
                    $document->title,
                    $document->slug,
                    $document->body()
                )
            );
    }

    public static function find($slug) {

        if ( !file_exists($path = resource_path("posts/my-{$slug}-post.html")) ) {
            throw new ModelNotFoundException('not found post');
        }
        
        return cache()->remember("posts.{$slug}", 1200, fn() => file_get_contents($path) );
    }
}
