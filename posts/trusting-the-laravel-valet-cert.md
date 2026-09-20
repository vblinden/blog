---
title: Trusting the Laravel Valet cert
date: August 16, 2024
description: "When local PHP processes refuse HTTPS connections between Valet sites, it's because OpenSSL doesn't trust Valet's self-signed CA. How to append the certificate to Homebrew's cert.pem so site-to-site requests work."
---

If your local PHP processes don't trust the Laravel Valet certificate when communicating between sites, you need to add the certificate to Homebrew's `cacert.pem` file used by OpenSSL. These instructions are for macOS.

First get the Laravel Valet certificate.

```bash
cat ~/.config/valet/CA/LaravelValetCASelfSigned.pem | pbcopy
```

Then add it to the bottom of the local Homebrew cert (which is being used by OpenSSL).

```bash
vim /opt/homebrew/etc/ca-certificates/cert.pem
```

Restart the services with `valet restart` and you should be good to go. Hope it helps!
