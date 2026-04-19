---
title: Fixing timeout when firing lots of requests with Laravel Valet
date: February 11, 2025
---

Laravel Valet is a fantastic tool for quickly spinning up local development environments. It's fast, easy to
use, and generally "just works". However, if you've ever run into a situation where you're making a large number
of concurrent requests (think AJAX calls on page load, or a complex application with lots of background
processes), you might have encountered a frustrating issue: requests hanging, seemingly at random. You refresh
the page, and sometimes things work, sometimes they don't. The culprit? The default PHP-FPM worker configuration
of Valet.

This issue comes to light when you exceed the default number of PHP-FPM workers available to handle
incoming requests. Valet uses PHP-FPM, and by default, it's configured with a relatively small number of worker
processes. When you bombard your application with a flurry of requests, all the workers get busy, and any
subsequent requests get stuck waiting for a worker to become free. This results in those hanging requests, often
leading to a frustrating developer experience.

The solution is very easy. We just need to increase the number of PHP-FPM workers available to handle incoming
requests.

Go to your PHP-FPM configuration file, which is located at:
`/opt/homebrew/etc/php/8.4/php-fpm.d/valet-fpm.conf` and update the following values:

```yaml
# Default configuration:
#pm = dynamic
#pm.max_children = 5
#pm.start_servers = 2
#pm.min_spare_servers = 1
#pm.max_spare_servers = 3

# New configuration:
pm = dynamic
pm.max_children = 200
pm.start_servers = 20
pm.min_spare_servers = 10
pm.max_spare_servers = 20
pm.process_idle_timeout = 10s
pm.max_requests = 500
```

Just run `valet restart` afterwards and you are good to go!
