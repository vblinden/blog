<x-layout>
    <div class="my-8">
        <p class="text-justify">
            Hey friends, my name is Vincent van der Linden and you can find me online as <x-link dot
                href="https://github.com/vblinden" target="_blank">@vblinden</x-link> I am currently working at <x-link
                href="https://team.blue" target="_blank">team.blue</x-link> as a senior software engineer.
            This is my little corner of the web for stuff I've found important, handy, or just wanted to save. Hope you
            find something interesting! The opinions expressed herein are my own personal opinions and do not represent
            my employer’s view in any way.
        </p>
    </div>

    <section class="mb-8">
        <h2 class="font-bold font-display mb-3 text-2xl">Posts.</h2>
        <ul class="list-inside list-disc ml-6">
            <li>
                <x-link href="/posts/technically-proficient-managers">
                    Technically proficient managers
                </x-link>
            </li>
            <li>
                <x-link href="/posts/do-not-write-your-own-css-framework">
                    Do not write your own CSS framework
                </x-link>
            </li>
            <li>
                <x-link href="/posts/fixing-timeout-when-firing-lots-of-requests-with-laravel-valet">
                    Fixing timeout when firing lots of requests with Laravel Valet
                </x-link>
            </li>
            <li>
                <x-link href="/posts/fixing-net-err-content-decoding-failed-error">
                    Fixing the "net::ERR_CONTENT_DECODING_FAILED" error
                </x-link>
            </li>
            <li>
                <x-link href="/posts/trusting-the-laravel-valet-cert">
                    Trusting the Laravel Valet cert
                </x-link>
            </li>
            <li>
                <x-link href="/posts/where-are-the-product-people">
                    Where are the product people?
                </x-link>
            </li>
            <li>
                <x-link href="/posts/starship-mission-to-mars">
                    Starship Mission to Mars
                </x-link>
            </li>
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
                <x-link href="https://sendwich.dev" target="_blank">sendwich.dev</x-link>
            </dt>
            <dd class="text-justify">
                It's a lean, developer-first transactional email service that delivers the 
                essentials without the bloat, gimmicks, or hidden pricing tricks.
            </dd>

            <dt class="mt-3 fw-normal">
                <x-link href="https://www.checkeroni.com" target="_blank">checkeroni.com</x-link>
            </dt>
            <dd class="text-justify">
                Minimal, simple and inexpensive 24/7 uptime monitoring
                service. Create an account, add an url, and it will check it every
                couple of minutes. When the url is down, it will notify you via
                email, SMS or by pinging a webhook.
            </dd>

            <dt class="mt-3 fw-normal">
                <x-link href="https://whatswrong.dev" target="_blank">whatswrong.dev</x-link>
            </dt>
            <dd class="text-justify">
                Great tool to help you find out what's wrong with your website. Application 
                exception tracking service for Laravel. A sort of Sentry light.
            </dd>

            <dt class="mt-3 fw-normal">
                <x-link href="https://feedbackwidget.dev" target="_blank">feedbackwidget.dev</x-link>
            </dt>
            <dd>
                Gain unparalleled insights and fuel your growth with our intuitive feedback widget! Easily gather user
                feedback directly from your website using our simple, customizable forms. No coding required. For
                ultimate flexibility, our API access lets you tailor feedback collection to your unique workflows.
            </dd>

            <!-- <dt class="mt-3 fw-normal"> -->
            <!--     <x-link href="https://bin.vblinden.dev" target="_blank">bin.vblinden.dev</x-link> -->
            <!-- </dt> -->
            <!-- <dd> -->
            <!--     Bin is an online content-hosting service where users can store -->
            <!--     plain text publicly or privately for a specific duration. Client -->
            <!--     side encryption is optional. -->
            <!-- </dd> -->

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
            <dd class="text-justify">
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
            <dd class="text-justify">
                Small and for fun soundboard of the legendary words spoken by
                <x-link href="https://www.hanselman.com" target="_blank">Scott Hanselman</x-link>
                during a .NET conference back in the day.
            </dd>
        </dl>
    </section>

    <section class="mb-8">
        <h2 class="text-2xl font-bold font-display mb-3">Contact.</h2>
        <p>
            You can reach me at <span class="lowercase">blog [at] vblinden.dev</span>.
        </p>
    </section>
</x-layout>
