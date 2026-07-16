@extends('layouts.app')

@section('content')
    <main>
        <h1 class="page-title">Posts</h1>

        <div class="prose-block">
            <ul class="link-list">
                @foreach ($posts as $post)
                    <li>
                        <a href="{{ $post->url() }}">{{ $post->title }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </main>
@endsection
