import Link from '@/components/Link';
import Header from '@/components/Header';
import Code from '@/components/Code';

export default function Post() {
  return (
    <>
      <Header
        title="Deploying an application using Dokku (with HTTPS and redirects)"
        date="May 5, 2020"
        readingTime="10"
      />

      <p className="mb-4">
        If you are creating a web application, you have to deploy it at some point. Most of the time I choose a service
        or provider that manages the server for me and I just have to deploy the application. Think about
        <Link href="https://www.heroku.com/" target="_blank" space dot>
          Heroku
        </Link>
        ,
        <Link href="https://www.fortrabbit.com/" target="_blank" space dot>
          Fortrabbit
        </Link>
        ,
        <Link href="https://cloud.google.com/" target="_blank" space dot>
          Google Cloud
        </Link>
        ,
        <Link href="https://azure.microsoft.com/en-us/" target="_blank" space>
          Microsoft Azure
        </Link>
        or
        <Link href="https://aws.amazon.com/" target="_blank" space dot>
          AWS
        </Link>
        . These services are great and work really well, however they can really add up in cost when you want to scale
        up an application or have multiple little applications running.
      </p>

      <p className="mb-4">
        This is why I recently purchased a Virtual Private Server (VPS), they are a lot cheaper (cheap as in $2.50 a
        month!) then the providers mentioned above. This is of course if you are not taking in account that these
        providers also offer a free tier for some of their services (mostly you can have one single application at most
        though).
      </p>

      <p className="mb-4">
        The only downside to this is that you have to manage the server yourself and that can be a real hassle if you
        don’t have much experience and knowledge about managing a server. Luckily there are a lot of tutorials for
        <Link
          href="https://www.digitalocean.com/community/tutorials/initial-server-setup-with-ubuntu-20-04"
          target="_blank"
          space
        >
          initial server setup
        </Link>
        out there which you can follow. Don’t forget to install the
        <i className="code">unattended-upgrades</i>
        package (if you are using Ubuntu), enable a firewall and you will be fine (I am <strong>not</strong>
        an expert on server management or security, so please don’t quote me on this).
      </p>

      <p className="mb-4">
        Anyway, the real pain is to manage and install every single application and it’s dependencies. For example: when
        you are hosting a PHP application with Nginx as the webserver you have to install PHP, Composer (for package
        management), Nginx and PHP-FPM. If you have some front-end dependencies like Vue.js with Webpack you also have
        to install Node.js and maintain those packages.
      </p>

      <p className="mb-4">
        Luckily for me (and you), we have
        <Link href="https://www.docker.com/" target="_blank" space>
          Docker
        </Link>
        these days which makes it much easier to manage all these stuff because each application will have it’s own
        <i className="code">Dockerfile</i> or
        <i className="code">docker-compose.yml</i>
        file which will handle everything that is needed to run the application correctly. This is a much better
        approach already, except now we aren’t managing dependencies directly but we are managing containers. Worrying
        about what will happen when a container will fall over, will it restart correctly, what happens if my database
        container fails, etc.
      </p>

      <p className="mb-4">
        This is where
        <Link href="https://github.com/dokku/dokku" target="_blank" space>
          Dokku
        </Link>
        gets in the picture. Dokku describes itself as “a Docker powered mini-Heroku”, and it really is as easy to use
        as Heroku. It will take care of all server related stuff, like managing dependencies, using SSL with Let’s
        Encrypt, redirects of domains etc. But at the same time it will allow us to define our own
        <i className="code">Dockerfile</i>
        which will give us more room to customize the way our application is handled by Dokku.
      </p>

      <p className="mb-4">
        I always use the following commands to get Dokku up and running with an application using the
        <Link
          href="https://github.com/dokku/dokku/blob/master/docs/deployment/methods/buildpacks.md"
          target="_blank"
          space
        >
          Buildpacks
        </Link>
        that Dokku supports at the moment.
      </p>

      <p className="mb-4">
        To install Dokku on your server, you should follow the
        <Link href="http://dokku.viewdocs.io/dokku/getting-started/installation/" target="_blank" space dot>
          official documentation
        </Link>
        . They also have a
        <Link href="http://dokku.viewdocs.io/dokku/deployment/application-deployment/" target="_blank" space>
          great guide
        </Link>
        for deploying your first application.
      </p>

      <p className="mb-4">
        When Dokku is installed we can create a new app by executing the following commands on your server. This will
        tell Dokku we want to create a new application with the name
        <i className="code">appname</i> and assign two domains to it:
        <i className="code">example.com</i> and
        <i className="code">www.example.com</i>.
      </p>

      <Code
        className="mb-4"
        lang="shell"
        code={`dokku apps:create appname dokku domains:add appname example.com dokku domains:add appname www.example.com`}
      />

      <p className="mb-4">
        You application should now be reachable at
        <i className="code">example.com</i> and
        <i className="code">www.example.com</i>
        if you have updated your DNS records correctly. Next thing we need to tell Dokku to use SSL. Dokku doesn’t
        support Let’s Encrypt certificates out of the box, so we need to install a
        <Link href="https://github.com/dokku/dokku-letsencrypt" target="_blank" space>
          plugin
        </Link>
        for it. Execute the following commands on your server.
      </p>

      <Code
        className="mb-4"
        lang="shell"
        code={`# Install the plugin: 
sudo dokku plugin:install https://github.com/dokku/dokku-letsencrypt.git 

# Tell Let's Encrypt which email to use: 
dokku config:set --global DOKKU_LETSENCRYPT_EMAIL={your-email}

# Enable Let's Encrypt for our application: 
dokku letsencrypt appname`}
      />

      <p className="mb-4">
        Congratulations your application now uses SSL certificates from Let’s Encrypt. The last thing we need to do is
        to tell Dokku that we want the redirect the <i className="code">example.com</i>
        domain to the <i className="code">www.example.com</i>
        domain, so we don’t have double content on the internet. We also have to install a
        <Link href="https://github.com/dokku/dokku-redirect" target="_blank" space>
          plugin
        </Link>
        to make it work.
      </p>

      <Code
        className="mb-4"
        lang="shell"
        code={`# Install the plugin: 
dokku plugin:install https://github.com/dokku/dokku-redirect.git 

# Redirect example.com to www.example.com: 
dokku redirect:set appname example.com www.example.com`}
      />

      <p className="mb-4">
        That’s it! You now have a application running on a server using Let’s Encrypt SSL certificates and redirecting
        the root domain
        <i className="code">www.example.com</i> to the subdomain
        <i className="code">www.example.com</i>.
      </p>

      <p className="mb-4">
        In a next blog post I will show you how to use a custom
        <i className="code">Dockerfile</i>
        and use it with Dokku. If you want to read more about that already, you can check out the
        <Link href="https://dokku.viewdocs.io/dokku/deployment/methods/dockerfiles/" target="_blank" space dot>
          Dokku documentation
        </Link>
        .
      </p>
    </>
  );
}
