---
title: Trusting the Laravel Valet cert
date: August 16, 2024
---

Sometimes your PHP processes will not trust the Laravel Valet certificate when communicating between sites. This
can be fixed by adding the certificate to the list of trusted certificates in your locally Homebrew
`cacert.pem` file (which is then being used by OpenSSL). Btw, these instructions are for macOS,
but I think it should be similar for other operating systems.

First get the Laravel Valet certificate.

```bash
cat ~/.config/valet/CA/LaravelValetCASelfSigned.pem | pbcopy
```

Then add it to the bottom of the locally Homebrew cert (which is being used by OpenSSL).

```bash
vim /opt/homebrew/etc/ca-certificates/cert.pem
```

Restart the services with `valet restart` and you should be good to go. Hope it helps!
