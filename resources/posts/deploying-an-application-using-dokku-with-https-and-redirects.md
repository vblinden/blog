---
title: Deploying an application using Dokku (with HTTPS and redirects)
date: May 5, 2020
---

If you are creating a web application, you have to deploy it at some point. Most of the time I choose a service or provider that manages the server for me and I just have to deploy the application. Think about <x-link href="https://www.heroku.com/" target="_blank" comma>Heroku</x-link> <x-link href="https://www.fortrabbit.com/" target="_blank" comma>Fortrabbit</x-link> <x-link href="https://cloud.google.com/" target="_blank" comma>Google Cloud</x-link> <x-link href="https://azure.microsoft.com/en-us/" target="_blank">Microsoft Azure</x-link> or <x-link href="https://aws.amazon.com/" target="_blank" dot>AWS</x-link>

These services are great and work really well, however they can really add up in cost when you want to scale up an application or have multiple little applications running.

This is why I recently purchased a Virtual Private Server (VPS), they are a lot cheaper (cheap as in $2.50 a month!) than the providers mentioned above. This is of course if you are not taking in account that these providers also offer a free tier for some of their services (mostly you can have one single application at most though).

The only downside to this is that you have to manage the server yourself and that can be a real hassle if you don't have much experience and knowledge about managing a server. Luckily there are a lot of tutorials for <x-link href="https://www.digitalocean.com/community/tutorials/initial-server-setup-with-ubuntu-20-04" target="_blank">initial server setup</x-link> out there which you can follow. Don't forget to install the <i>unattended-upgrades</i> package (if you are using Ubuntu), enable a firewall and you will be fine (I am <strong>not</strong> an expert on server management or security, so please don't quote me on this).

Anyway, the real pain is to manage and install every single application and it's dependencies. For example: when you are hosting a PHP application with Nginx as the webserver you have to install PHP, Composer (for package management), Nginx and PHP-FPM. If you have some front-end dependencies like Vue.js with Webpack you also have to install Node.js and maintain those packages.

Luckily for me (and you), we have <x-link href="https://www.docker.com/" target="_blank">Docker</x-link> these days which makes it much easier to manage all these stuff because each application will have it's own <i>Dockerfile</i> or <i>docker-compose.yml</i> file which will handle everything that is needed to run the application correctly. This is a much better approach already, except now we aren't managing dependencies directly but we are managing containers. Worrying about what will happen when a container will fall over, will it restart correctly, what happens if my database container fails, etc.

This is where <x-link href="https://github.com/dokku/dokku" target="_blank">Dokku</x-link> gets in the picture. Dokku describes itself as "a Docker powered mini-Heroku", and it really is as easy to use as Heroku. It will take care of all server related stuff, like managing dependencies, using SSL with Let's Encrypt, redirects of domains etc. But at the same time it will allow us to define our own <i>Dockerfile</i> which will give us more room to customize the way our application is handled by Dokku.

I always use the following commands to get Dokku up and running with an application using the <x-link href="https://github.com/dokku/dokku/blob/master/docs/deployment/methods/buildpacks.md" target="_blank">Buildpacks</x-link> that Dokku supports at the moment.

To install Dokku on your server, you should follow the <x-link href="http://dokku.viewdocs.io/dokku/getting-started/installation/" target="_blank" dot>official documentation</x-link> They also have a <x-link href="http://dokku.viewdocs.io/dokku/deployment/application-deployment/" target="_blank">great guide</x-link> for deploying your first application.

When Dokku is installed we can create a new app by executing the following commands on your server. This will tell Dokku we want to create a new application with the name <i>appname</i> and assign two domains to it: <i>example.com</i> and <i>www.example.com</i>.

```
dokku apps:create appname
dokku domains:add appname example.com
dokku domains:add appname www.example.com
```

You application should now be reachable at <i>example.com</i> and <i>www.example.com</i> if you have updated your DNS records correctly. Next thing we need to tell Dokku to use SSL. Dokku doesn't support Let's Encrypt certificates out of the box, so we need to install a <x-link href="https://github.com/dokku/dokku-letsencrypt" target="_blank">plugin</x-link> for it. Execute the following commands on your server.

```
# Install the plugin:
sudo dokku plugin:install https://github.com/dokku/dokku-letsencrypt.git

# Tell Let's Encrypt which email to use:
dokku config:set --global DOKKU_LETSENCRYPT_EMAIL={your-email}

# Enable Let's Encrypt for our application:
dokku letsencrypt appname
```

Congratulations your application now uses SSL certificates from Let's Encrypt. The last thing we need to do is to tell Dokku that we want the redirect the <i>example.com</i> domain to the <i>www.example.com</i> domain, so we don't have double content on the internet. We also have to install a <x-link href="https://github.com/dokku/dokku-redirect" target="_blank">plugin</x-link> to make it work.

```
# Install the plugin:
dokku plugin:install https://github.com/dokku/dokku-redirect.git

# Redirect example.com to www.example.com:
dokku redirect:set appname example.com www.example.com
```

That's it! You now have an application running on a server using Let's Encrypt SSL certificates and redirecting the root domain <i>example.com</i> to the subdomain <i>www.example.com</i>.

In a next blog post I will show you how to use a custom <i>Dockerfile</i> and use it with Dokku. If you want to read more about that already, you can check out the <x-link href="https://dokku.viewdocs.io/dokku/deployment/methods/dockerfiles/" target="_blank" dot>Dokku documentation</x-link>
