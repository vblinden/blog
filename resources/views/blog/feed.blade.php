{!! '<'.'?xml version="1.0" encoding="UTF-8"?>' !!}
<feed xmlns="http://www.w3.org/2005/Atom">
    <title>{{ config('blog.site_name') }}</title>
    <subtitle>{{ config('blog.home_description') }}</subtitle>
    <link href="{{ route('feed') }}" rel="self" type="application/atom+xml" />
    <link href="{{ url('/') }}" rel="alternate" type="text/html" />
    <id>{{ url('/') }}</id>
    <updated>{{ $updatedAt }}</updated>
    <author>
        <name>{{ config('blog.author') }}</name>
        <uri>{{ url('/') }}</uri>
        @if (config('blog.social.email'))
            <email>{{ config('blog.social.email') }}</email>
        @endif
    </author>
    @foreach ($posts as $post)
        <entry>
            <title>{{ $post->title }}</title>
            <link href="{{ $post->url() }}" rel="alternate" type="text/html" />
            <id>{{ $post->url() }}</id>
            @if ($post->publishedAtIso8601)
                <published>{{ $post->publishedAtIso8601 }}</published>
                <updated>{{ $post->publishedAtIso8601 }}</updated>
            @endif
            <summary>{{ $post->description }}</summary>
        </entry>
    @endforeach
</feed>
