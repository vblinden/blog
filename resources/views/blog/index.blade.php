<x-layouts.blog :seo="$seo">
    <main class="space-y-14">
        <section class="max-w-3xl">
            <p class="lede">
                Hey friends, my name is Vincent van der Linden and you can find me online as
                <a href="https://github.com/vblinden" target="_blank" rel="noreferrer">@vblinden</a>.
                I am currently working at
                <a href="https://team.blue" target="_blank" rel="noreferrer">team.blue</a>
                as a senior software engineer. This is my little corner of the web for stuff I&apos;ve found important, handy, or just wanted to save.
                Hope you find something interesting! The opinions expressed herein are my own personal opinions and do not represent my employer&apos;s view in any way.
            </p>
        </section>

        <section>
            <h2 class="section-title">Posts.</h2>

            <ul class="post-list">
                @foreach ($posts as $post)
                    <li>
                        <a href="{{ route('posts.show', $post['slug']) }}">
                            {{ $post['title'] }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </section>

        <section>
            <h2 class="section-title">Projects.</h2>

            <dl class="project-list max-w-3xl">
                @foreach ($projects as $project)
                    <dt>
                        <a href="{{ $project['url'] }}" target="_blank" rel="noreferrer">
                            {{ $project['name'] }}
                        </a>
                    </dt>
                    <dd>{!! $project['description'] !!}</dd>
                @endforeach
            </dl>
        </section>
    </main>
</x-layouts.blog>
