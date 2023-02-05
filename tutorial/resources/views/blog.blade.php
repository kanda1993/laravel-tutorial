<x-layout>
    @foreach ($posts as $post)
        <div class="{{ $loop->even ? 'foobar' : '' }}">
            <h1>
                <a href="/posts/{{ $post->slug }}">
                    <?= $post->title ?>
                </a>
            </h1>
            {!! $post->body !!}
        </div>
    @endforeach
</x-layout>


