<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\File;
use Spatie\YamlFrontMatter\YamlFrontMatter;

class Post
{

    public $title;
    public $body;
    public $date;
    public $excerpt;
    public $slug;

    public function __construct($title, $body, $date, $excerpt, $slug)
    {
        $this->title = $title;
        $this->body = $body;
        $this->date = $date;
        $this->excerpt = $excerpt;
        $this->slug = $slug;
    }

    public static function all()
    {
        // return cache()->rememberForever('posts.all', function () {
            return collect(File::files(resource_path("posts")))
                ->map(fn ($file) => YamlFrontMatter::parseFile($file))
                ->map(fn ($document) => new Post(
                    $document->title,
                    $document->body(),
                    $document->date,
                    $document->excerpt,
                    $document->slug
                ))
                ->sortByDesc('date');
        // });
    }

    public static function find($slug)
    {
        return static::all()->firstWhere('slug', $slug);
    }

    public static function findOrFail($slug)
    {
        $post = static::find($slug);

        if (! $post) {
            throw new ModelNotFoundException();
        }

        return $post;
    }
}
