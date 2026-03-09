---
title: Fixing the "net::ERR_CONTENT_DECODING_FAILED" error
date: February 11, 2025
---

This error arises when the HTTP request headers indicate gzip encoding, but the content itself isn't actually
compressed. This typically happens when working with some older Laravel projects that have misconfigurations.
It's usually linked to the `zlib.output_compression` setting in your `php.ini` configuration
file.

When this setting is enabled, set to `On`, for projects that aren't expecting it, it can lead to decoding
issues, resulting in the `net::ERR_CONTENT_DECODING_FAILED` error in your browser.

The solution is very easy, you just have to change one setting in your php.ini.

```bash
#zlib.output_compression = Off
zlib.output_compression = On
```

Restart your PHP processes and you are good to go!
