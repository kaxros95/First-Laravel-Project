<x-layout>
    
    @foreach ($posts as $post)
    <hr>
    <article>
        <h1>
            <a href="/posts/{{$post->slug}}">
                {{ $post->title; }}
            </a>
        </h1>
        <h3>
            {{ $post->excerpt; }}
        </h3>
    </article>
    <hr>
    @endforeach

</x-layout>