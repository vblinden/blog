<x-layout title="Trusting the Laravel Valet cert">
    <x-header title="Trusting the Laravel Valet cert" date="Augustus 16, 2024" reading-time="1" />

    <p class="mb-4">
        Sometimes/somehow Chrome or Firefox (or any other browser) will not trust the Laravel Valet certificate. This
        can be fixed by adding the certificate to the list of trusted certificates in your locally Homebrew
        <strong>cacert.pem</strong> file (which is then being used by OpenSSL). Btw, these instructions are for macOS,
        but I think it should be similar for other operating systems.
    </p>

    <p class="mb-4">
        First get the Laravel Valet certificate.

        <pre class="mb-4"><x-torchlight-code language="shell">
        cat ~/.config/valet/CA/LaravelValetCASelfSigned.pem | pbcopy
        </x-torchlight-code></pre>
    </p>

    <p class="mb-4">
        Then add it to the bottom of the locally Homebrew cert (which is being used by OpenSSL).

        <pre class="mb-4"><x-torchlight-code language="shell">
        vim /opt/homebrew/etc/ca-certificates/cert.pem
        </x-torchlight-code></pre>
    </p>

    <p class="mb-4">
        Restart the services with <strong>valet restart</strong> and you should be good to go. Hope it helps!
    </p>
</x-layout>
