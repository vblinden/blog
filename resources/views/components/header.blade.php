<header class="flex flex-col mb-6">
    <h1 class="mt-6 text-4xl font-bold tracking-tight break-all text-zinc-800 dark:text-zinc-100 sm:text-5xl">
        {{ $title }}
    </h1>
    <time class="order-first flex items-center text-base text-zinc-400 dark:text-zinc-500">
        <strong>Posted on&nbsp;</strong> {{ $date }}
    </time>

    <p class="order-first flex items-center text-base text-zinc-400 dark:text-zinc-500">
        <strong>Reading time&nbsp;</strong> is {{ $readingTime }} minute(s)
    </p>
</header>
