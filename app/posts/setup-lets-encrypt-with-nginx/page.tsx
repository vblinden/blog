import Link from '@/components/Link';
import Code from '@/components/Code';
import Header from '@/components/Header';

export default function Post() {
  return (
    <>
      <Header title="Setup Let's Encrypt with Nginx" date="November 19, 2019" readingTime="5" />

      <p className="mb-4">
        When I migrated my VPS (with Ubuntu) to an other host, I needed to setup
        <Link href="https://nginx.org/" target="_blank" space>
          Nginx
        </Link>
        again with
        <Link href="https://letsencrypt.org/" target="_blank" space>
          Let's Encrypt
        </Link>
        but I always forget how to exactly do it. This blog post is aimed to describe in easy steps how to setup up
        Nginx with auto-renewing Let’s Encrypt SSL certificates.
      </p>

      <h2 className="text-2xl font-bold">Setting up Nginx</h2>

      <p className="mb-4">Setting up Nginx is super easy on Ubuntu. Run the following commands on your VPS.</p>

      <Code className="mb-4" lang="shell" code={`sudo apt update sudo apt install nginx`} />

      <p className="mb-4">
        If you have a firewall (ufw) enabled run the following command to enable HTTP (80) and HTTPS (443) to the
        firewall.
      </p>

      <Code className="mb-4" lang="shell" code={`sudo ufw allow 'Nginx Full'`} />

      <h2 className="text-2xl font-bold">Installing Certbot</h2>

      <p className="mb-4">
        <Link href="https://certbot.eff.org" target="_blank">
          Certbot
        </Link>
        is also super easy. Run the following commands on your VPS.
      </p>

      <Code
        className="mb-4"
        lang="shell"
        code={`sudo apt-get update 
sudo apt-get install software-properties-common 

sudo add-apt-repository universe 
sudo add-apt-repository ppa:certbot/certbot 

sudo apt-get update 
sudo apt-get install certbot python-certbot-nginx`}
      />

      <h2 className="text-2xl font-bold">Getting a SSL certificate from Let’s Encrypt</h2>

      <p className="mb-4">
        Now that we installed Certbot we can get a certificate from Let’s Encrypt by running the following command.
      </p>

      <Code className="mb-4" lang="shell" code={`sudo certbot --nginx -d example.com -d www.example.com`} />

      <h2 className="text-2xl font-bold">Auto-renew your certificates</h2>

      <p className="mb-4">
        To auto-renew the certificates you have installed, add the following command to your crontab (open by running
        crontab -e from terminal)
      </p>

      <Code className="mb-4" lang="shell" code={`0 * * * * sudo certbot renew`} />
    </>
  );
}
