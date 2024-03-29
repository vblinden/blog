<x-layout title="Retrieve submodules with Git" torchlight>
    <x-header title="Retrieve submodules with Git" date="August 29, 2019" reading-time="1" />

    <p class="mb-4">
        Yesterday I had a really hard time with pulling in a submodule from an
        old git repository I had lying around. I thought a quick Google with
        DuckDuckGo would solve all my problems, but alas. There was a lot of
        outdated information that simply didn't work with the Git version I
        had installed on my computer (or maybe I just applied it incorrectly).
    </p>

    <p class="mb-4">
        Finally I found an
        <x-link href="https://stackoverflow.com/a/44692935" target="_blank">answer</x-link>
        on StackOverflow that didn't quite work, but send me in the right
        direction. Eventually I gave up the DuckDuckGoing and did what I
        should have done in the first place: Look at the
        <x-link href="https://git-scm.com/docs/git-submodule" target="_blank">Git documentation</x-link>
        for the submodule command.
    </p>

    <p class="mb-4">
        The command I ran (from the root of my git folder) that worked for me
        after I cloned my repository was:
    </p>

    <pre class="mb-4"><x-torchlight-code language="shell">
        git submodule update --init --recursive
    </x-torchlight-code></pre>

    <p>
        An important lesson learned: If there is documentation available, consult that
        first.
    </p>
</x-layout>
