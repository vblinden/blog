<x-layout title='Fixing the "net::ERR_CONTENT_DECODING_FAILED" error' torchlight>
    <x-header title='Fixing the "net::ERR_CONTENT_DECODING_FAILED" error' date="February 11, 2025" reading-time="2" />

    <p class="mb-4">
        This error arises when the HTTP request headers indicate gzip encoding, but the content itself isn't actually
        compressed. This typically happens when working with some older Laravel projects that have misconfigurations.
        It's usually linked to the zlib.output_compression setting in your <i>php.ini</i> configuration
        file.
        When this setting is enabled, set to "On", for projects that aren't expecting it, it can lead to decoding
        issues, resulting in the <i>net::ERR_CONTENT_DECODING_FAILED</i> error in your browser.
    </p>

    <p class="mb-4">
        The solution is very easy, you just have to change one setting in your php.ini.
    </p>

    <pre class="mb-4"><x-torchlight-code language="shell">
#zlib.output_compression = Off
zlib.output_compression = On
    </x-torchlight-code></pre>

    <p>
        Just run <i>valet restart</i> afterwards and you are good to go!
    </p>
</x-layout>
