<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>{{ url('/') }}</loc>
    </url>
    @foreach ($posts as $post)
        <url>
            <loc>{{ $post->url() }}</loc>
            @if ($post->publishedAtIso8601)
                <lastmod>{{ $post->publishedAtIso8601 }}</lastmod>
            @endif
        </url>
    @endforeach
</urlset>
