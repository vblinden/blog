<x-layouts.blog :seo="$seo">
    <article class="max-w-3xl">
        <header class="article-header">
            <h1 class="article-title">{{ $post['title'] }}</h1>

            @if ($post['date'] !== '')
                <time class="article-date">{{ $post['date'] }}</time>
            @endif
        </header>

        <div class="markdown">
            {!! $post['html'] !!}
        </div>

        <footer class="article-footer">
            <a href="{{ route('home') }}">Back to home</a>
        </footer>
    </article>
</x-layouts.blog>
