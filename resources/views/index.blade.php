<x-layout>
    <div class="my-8">
        <p class="text-justify">
            Hey friends, my name is Vincent van der Linden and you can find me online as
            <x-link dot href="https://github.com/vblinden" target="_blank">@vblinden</x-link>
            I am currently working at
            <x-link href="https://team.blue" target="_blank">team.blue</x-link>
            as a software engineer. On this website you can find some things that I thought were important or useful
            enough to put online. Please enjoy. The opinions expressed herein are my own personal opinions and do
            not represent my employer’s view in any way.
        </p>
    </div>

    <section class="mb-8">
        <h2 class="font-bold font-display mb-3 text-2xl">Posts.</h2>
        <ul class="list-inside list-disc ml-6">
            <li>
                <x-link href="/posts/implement-rigorously-the-five-step-process">
                    Implement Rigorously: The Five Step Process
                </x-link>
            </li>
            <li>
                <x-link href="/posts/how-to-install-amqp-on-macos">
                    How to install AMQP on macOS
                </x-link>
            </li>
            <li>
                <x-link href="/posts/what-did-you-undesign">
                    What did you undesign?
                </x-link>
            </li>
            <li>
                <x-link href="/posts/deploying-an-application-using-dokku-with-https-and-redirects">
                    Deploying an application using Dokku (with HTTPS and redirects)
                </x-link>
            </li>
            <li>
                <x-link href="/posts/setup-lets-encrypt-with-nginx">
                    Setup Let's Encrypt with Nginx
                </x-link>
            </li>
            <li>
                <x-link href="/posts/retrieve-submodules-with-git">
                    Retrieve submodules with Git
                </x-link>
            </li>
            <li>
                <x-link href="/posts/never-forget-backups">
                    Never. Forget. Backups.
                </x-link>
            </li>
        </ul>
    </section>

    <section class="mb-8">
        <h2 class="font-bold font-display mb-3 text-2xl">Projects.</h2>
        <dl>
            <dt class="fw-normal">
                <x-link href="https://www.checkeroni.com" target="_blank">checkeroni.com</x-link>
            </dt>
            <dd>
                Minimal, simple and inexpensive 24/7 uptime monitoring
                service. Create an account, add an url, and it will check it every
                couple of minutes. When the url is down, it will notify you via
                email, SMS or by pinging a webhook.
            </dd>

            <dt class="mt-3 fw-normal">
                <x-link href="https://www.kritiek.app" target="_blank">kritiek.app</x-link>
            </dt>
            <dd>
                Enhance user engagement, gain valuable insights, and boost your business success with Kritiek – the
                ultimate feedback widget application.
            </dd>

            <dt class="mt-3 fw-normal">
                <x-link href="https://bin.vblinden.dev" target="_blank">bin.vblinden.dev</x-link>
            </dt>
            <dd>
                Bin is an online content-hosting service where users can store
                plain text publicly or privately for a specific duration. Client
                side encryption is optional.
            </dd>

            {{--            <dt class="mt-3 fw-normal"> --}}
            {{--                <x-link href="https://www.drinkmorewater.app" target="_blank">drinkmorewater.app</x-link> --}}
            {{--            </dt> --}}
            {{--            <dd> --}}
            {{--                This app does what is says: Help you drink more water. You can --}}
            {{--                configure the kind of glasses you drink from, the type of --}}
            {{--                beverages you drink and easily keep track of your daily water --}}
            {{--                intake. --}}
            {{--            </dd> --}}

            <dt class="mt-3 fw-normal">
                <x-link href="https://nederboard.nl" target="_blank">nederboard.nl</x-link>
            </dt>
            <dd>
                A soundboard with snippets from all kinds of different meme videos
                in the Netherlands. Including classics like
                <x-link href="https://nederboard.nl/board/helemaalknettah" target="_blank">Helemaal knettah</x-link>
                and
                <x-link href="https://nederboard.nl/board/rustahg" target="_blank">Rustahg</x-link>
                plus a dozen more!
            </dd>

            <dt class="mt-3 fw-normal">
                <x-link href="https://iloveitshipit.com" target="_blank">iloveitshipit.com</x-link>
            </dt>
            <dd>
                Small and for fun soundboard of the legendary words spoken by
                <x-link href="https://www.hanselman.com" target="_blank">Scott Hanselman</x-link>
                during a .NET conference back in the day.
            </dd>
        </dl>
    </section>

    <section class="mb-8">
        <h2 class="text-2xl font-bold font-display mb-3">Contact.</h2>
        <p>
            You can reach me at <span class="lowercase">{{ Str::random(12) }} [at] vblinden.dev</span>.
        </p>
    </section>
</x-layout>
