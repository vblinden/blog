<x-layouts.blog :seo="$seo">
    <article class="max-w-3xl">
        <header class="article-header">
            @if ($post['date'] !== '')
                <time class="article-date">{{ $post['date'] }}</time>
            @endif

            <h1 class="article-title">{{ $post['title'] }}</h1>

            <p class="article-meta">{{ $post['reading_time'] }} min read</p>
        </header>

        <div class="markdown">
            {!! $post['html'] !!}
        </div>

        <footer class="article-footer">
            <a href="{{ route('home') }}">Back to home</a>
        </footer>
    </article>
</x-layouts.blog>
