<x-layout title="How to install AMQP on macOS" torchlight>
    <x-header title="How to install AMQP on macOS" date="October 2, 2020" reading-time="3" />

    <p class="mb-4">
        I recently wanted to install the AMQP extension for PHP version 7.4,
        but ran into some issues on macOS.
    </p>

    <p class="mb-4">
        It should be as easy as running the following commands:
    </p>

    <pre class="mb-4"><x-torchlight-code language="shell">
        brew install rabbitmq-c
        pecl install amqp
    </x-torchlight-code></pre>

    <p class="mb-4">Unfortunately I ran into the following issues:</p>

    <pre class="mb-4"><x-torchlight-code language="text">
        Warning: mkdir(): File exists in System.php on line 294 PHP Warning: mkdir(): File exists in
        /usr/local/Cellar/php/7.4.10/share/php/pear/System.php on line 294 Warning: mkdir(): File exists in
        /usr/local/Cellar/php/7.3.3/share/php/pear/System.php on line 294 ERROR: failed to mkdir
        /usr/local/Cellar/php/7.4.10/pecl/20190812
    </x-torchlight-code></pre>

    <p class="mb-4">
        The command fails because pecl can’t create the directories itself.
        This can be easily fixed by executing the following commands:
    </p>

    <pre class="mb-4"><x-torchlight-code language="shell">
        pecl config-get ext_dir | pbcopy

        mkdir -p $PASTECLIPBOARD
    </x-torchlight-code></pre>

    <p class="mb-4">
        You should also manually export the
        <i>PKG_CONFIG_PATH</i>
        because Homebrew fails to do so.
    </p>

    <pre class="mb-4"><x-torchlight-code language="shell">
        export PKG_CONFIG_PATH="$PKG_CONFIG_PATH:/usr/local/Cellar/rabbitmq-c/0.10.0/lib/pkgconfig"
    </x-torchlight-code></pre>

    <p class="mb-4">
        Now run the two commands again and it should work. I hope this helps
        anybody who also is running into this issue.
    </p>
</x-layout>
