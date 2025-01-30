import Link from '@/components/Link';

export default function Home() {
  const randomEmail = (Math.random() + 1).toString(36).substring(2);

  return (
    <>
      <div className="my-8">
        <p className="text-justify">
          Hey friends, my name is Vincent van der Linden and you can find me online as
          <Link href="https://github.com/vblinden" target="_blank" space dot>
            @vblinden
          </Link>
          . I am currently working at
          <Link href="https://team.blue" target="_blank" space>
            team.blue
          </Link>
          as a software engineer. On this website you can find some things that I thought were important or useful
          enough to put online. Please enjoy. The opinions expressed herein are my own personal opinions and do not
          represent my employer’s view in any way.
        </p>
      </div>

      <section className="mb-8">
        <h2 className="font-bold font-display mb-3 text-2xl">Posts.</h2>
        <ul className="list-inside list-disc ml-6">
          <li>
            <Link href="/posts/trusting-the-laravel-valet-cert">Trusting the Laravel Valet cert</Link>
          </li>
          <li>
            <Link href="/posts/where-are-the-product-people">Where are the product people?</Link>
          </li>
          <li>
            <Link href="/posts/starship-mission-to-mars">Starship Mission to Mars</Link>
          </li>
          <li>
            <Link href="/posts/implement-rigorously-the-five-step-process">
              Implement Rigorously: The Five Step Process
            </Link>
          </li>
          <li>
            <Link href="/posts/how-to-install-amqp-on-macos">How to install AMQP on macOS</Link>
          </li>
          <li>
            <Link href="/posts/what-did-you-undesign">What did you undesign?</Link>
          </li>
          <li>
            <Link href="/posts/deploying-an-application-using-dokku-with-https-and-redirects">
              Deploying an application using Dokku (with HTTPS and redirects)
            </Link>
          </li>
          <li>
            <Link href="/posts/setup-lets-encrypt-with-nginx">Setup Let's Encrypt with Nginx</Link>
          </li>
          <li>
            <Link href="/posts/retrieve-submodules-with-git">Retrieve submodules with Git</Link>
          </li>
          <li>
            <Link href="/posts/never-forget-backups">Never. Forget. Backups.</Link>
          </li>
        </ul>
      </section>

      <section className="mb-8">
        <h2 className="font-bold font-display mb-3 text-2xl">Projects.</h2>
        <dl>
          <dt className="fw-normal">
            <Link href="https://www.checkeroni.com" target="_blank">
              checkeroni.com
            </Link>
          </dt>
          <dd>
            Minimal, simple and inexpensive 24/7 uptime monitoring service. Create an account, add an url, and it will
            check it every couple of minutes. When the url is down, it will notify you via email, SMS or by pinging a
            webhook.
          </dd>

          <dt className="mt-3 fw-normal">
            <Link href="https://bin.vblinden.dev" target="_blank">
              bin.vblinden.dev
            </Link>
          </dt>
          <dd>
            Bin is an online content-hosting service where users can store plain text publicly or privately for a
            specific duration. Client side encryption is optional.
          </dd>

          <dt className="mt-3 fw-normal">
            <Link href="https://nederboard.nl" target="_blank">
              nederboard.nl
            </Link>
          </dt>
          <dd>
            A soundboard with snippets from all kinds of different meme videos in the Netherlands. Including classics
            like
            <Link href="https://nederboard.nl/board/helemaalknettah" target="_blank" space>
              Helemaal knettah
            </Link>
            and
            <Link href="https://nederboard.nl/board/rustahg" target="_blank" space>
              Rustahg
            </Link>
            plus a dozen more!
          </dd>

          <dt className="mt-3 fw-normal">
            <Link href="https://iloveitshipit.com" target="_blank">
              iloveitshipit.com
            </Link>
          </dt>
          <dd>
            Small and for fun soundboard of the legendary words spoken by
            <Link href="https://www.hanselman.com" target="_blank" space>
              Scott Hanselman
            </Link>
            during a .NET conference back in the day.
          </dd>
        </dl>
      </section>

      <section className="mb-8">
        <h2 className="text-2xl font-bold font-display mb-3">Contact.</h2>
        <p>
          You can reach me at <span className="lowercase">{randomEmail} [at] vblinden.dev</span>.
        </p>
      </section>
    </>
  );
}
