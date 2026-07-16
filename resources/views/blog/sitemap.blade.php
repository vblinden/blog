<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>{{ url('/') }}</loc>
        @if ($posts->first()?->publishedAtIso8601)
            <lastmod>{{ $posts->first()->publishedAtIso8601 }}</lastmod>
        @endif
        <changefreq>weekly</changefreq>
        <priority>1.0</priority>
    </url>
    <url>
        <loc>{{ route('posts') }}</loc>
        @if ($posts->first()?->publishedAtIso8601)
            <lastmod>{{ $posts->first()->publishedAtIso8601 }}</lastmod>
        @endif
        <changefreq>weekly</changefreq>
        <priority>0.9</priority>
    </url>
    <url>
        <loc>{{ route('feed') }}</loc>
        <changefreq>weekly</changefreq>
        <priority>0.3</priority>
    </url>
    @foreach ($posts as $post)
        <url>
            <loc>{{ $post->url() }}</loc>
            @if ($post->publishedAtIso8601)
                <lastmod>{{ $post->publishedAtIso8601 }}</lastmod>
            @endif
            <changefreq>monthly</changefreq>
            <priority>0.8</priority>
        </url>
    @endforeach
</urlset>
