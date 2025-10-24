import Link from "@/components/link";

export default function Home() {
  return (
    <>
      <div className="my-8">
        <p className="text-justify">
          Hey friends, my name is Vincent van der Linden and you can find me
          online as{" "}
          <Link href="https://github.com/vblinden" target="_blank">
            @vblinden
          </Link>
          . I am currently working at{" "}
          <Link href="https://team.blue" target="_blank">
            team.blue
          </Link>{" "}
          as a senior software engineer. This is my little corner of the web for
          stuff I&apos;ve found important, handy, or just wanted to save. Hope
          you find something interesting! The opinions expressed herein are my
          own personal opinions and do not represent my employer&apos;s view in
          any way.
        </p>
      </div>

      <section className="mb-8">
        <h2 className="font-bold font-display mb-3 text-2xl">Posts.</h2>
        <ul className="list-inside list-disc ml-6">
          <li>
            <Link
              href={`/posts/tinkerers-make-better-engineers`}
              target="_self"
            >
              Tinkerers make better engineers
            </Link>
          </li>

          <li>
            <Link
              href={`/posts/technically-proficient-managers`}
              target="_self"
            >
              Technically proficient managers
            </Link>
          </li>

          <li>
            <Link
              href={`/posts/do-not-write-your-own-css-framework`}
              target="_self"
            >
              Do not write your own CSS framework
            </Link>
          </li>

          <li>
            <Link
              href={`/posts/fixing-net-err-content-decoding-failed-error`}
              target="_self"
            >
              Fixing the &quot;net::ERR_CONTENT_DECODING_FAILED&quot; error
            </Link>
          </li>

          <li>
            <Link
              href={`/posts/fixing-timeout-when-firing-lots-of-requests-with-laravel-valet`}
              target="_self"
            >
              Fixing timeout when firing lots of requests with Laravel Valet
            </Link>
          </li>

          <li>
            <Link
              href={`/posts/trusting-the-laravel-valet-cert`}
              target="_self"
            >
              Trusting the Laravel Valet cert
            </Link>
          </li>

          <li>
            <Link href={`/posts/where-are-the-product-people`} target="_self">
              Where are the product people?
            </Link>
          </li>

          <li>
            <Link href={`/posts/starship-mission-to-mars`} target="_self">
              Starship Mission to Mars
            </Link>
          </li>

          <li>
            <Link
              href={`/posts/implement-rigorously-the-five-step-process`}
              target="_self"
            >
              Implement Rigorously: The Five Step Process
            </Link>
          </li>

          <li>
            <Link href={`/posts/how-to-install-amqp-on-macos`} target="_self">
              How to install AMQP on macOS
            </Link>
          </li>

          <li>
            <Link href={`/posts/what-did-you-undesign`} target="_self">
              What did you undesign?
            </Link>
          </li>

          <li>
            <Link
              href={`/posts/deploying-an-application-using-dokku-with-https-and-redirects`}
              target="_self"
            >
              Deploying an application using Dokku (with HTTPS and redirects)
            </Link>
          </li>

          <li>
            <Link href={`/posts/setup-lets-encrypt-with-nginx`} target="_self">
              Setup Let&apos;s Encrypt with Nginx
            </Link>
          </li>

          <li>
            <Link href={`/posts/retrieve-submodules-with-git`} target="_self">
              Retrieve submodules with Git
            </Link>
          </li>

          <li>
            <Link href={`/posts/never-forget-backups`} target="_self">
              Never. Forget. Backups.
            </Link>
          </li>
        </ul>
      </section>

      <section className="mb-8">
        <h2 className="font-bold font-display mb-3 text-2xl">Projects.</h2>
        <dl>
          <dt className="fw-normal">
            <Link href="https://sendwich.dev" target="_blank">
              sendwich.dev
            </Link>
          </dt>
          <dd className="text-justify">
            It&apos;s a lean, developer-first transactional email service that
            delivers the essentials without the bloat, gimmicks, or hidden
            pricing tricks.
          </dd>

          <dt className="mt-3 fw-normal">
            <Link href="https://www.checkeroni.com" target="_blank">
              checkeroni.com
            </Link>
          </dt>
          <dd className="text-justify">
            Minimal, simple and inexpensive 24/7 uptime monitoring service.
            Create an account, add an url, and it will check it every couple of
            minutes. When the url is down, it will notify you via email, SMS or
            by pinging a webhook.
          </dd>

          <dt className="mt-3 fw-normal">
            <Link href="https://whatswrong.dev" target="_blank">
              whatswrong.dev
            </Link>
          </dt>
          <dd className="text-justify">
            Great tool to help you find out what&apos;s wrong with your website.
            Application exception tracking service for Laravel. A sort of Sentry
            light.
          </dd>

          <dt className="mt-3 fw-normal">
            <Link href="https://staravatars.com" target="_blank">
              staravatars.com
            </Link>
          </dt>
          <dd className="text-justify">
            Create beautiful space and star based avatars based on the text
            provided. I use this for my own projects to get rid of the boring
            default avatars.
          </dd>

          {/* <dt className="mt-3 fw-normal">
            <Link href="https://feedbackwidget.dev" target="_blank">
              feedbackwidget.dev
            </Link>
          </dt>
          <dd>
            Gain unparalleled insights and fuel your growth with our intuitive
            feedback widget! Easily gather user feedback directly from your
            website using our simple, customizable forms. No coding required.
            For ultimate flexibility, our API access lets you tailor feedback
            collection to your unique workflows.
          </dd> */}

          <dt className="mt-3 fw-normal">
            <Link href="https://nederboard.nl" target="_blank">
              nederboard.nl
            </Link>
          </dt>
          <dd className="text-justify">
            A soundboard with snippets from all kinds of different meme videos
            in the Netherlands. Including classics like{" "}
            <Link
              href="https://nederboard.nl/board/helemaalknettah"
              target="_blank"
            >
              Helemaal knettah
            </Link>{" "}
            and{" "}
            <Link href="https://nederboard.nl/board/rustahg" target="_blank">
              Rustahg
            </Link>{" "}
            plus a dozen more!
          </dd>

          <dt className="mt-3 fw-normal">
            <Link href="https://iloveitshipit.com" target="_blank">
              iloveitshipit.com
            </Link>
          </dt>
          <dd className="text-justify">
            Small and for fun soundboard of the legendary words spoken by{" "}
            <Link href="https://www.hanselman.com" target="_blank">
              Scott Hanselman
            </Link>{" "}
            during a .NET conference back in the day.
          </dd>
        </dl>
      </section>

      <section className="mb-8">
        <h2 className="text-2xl font-bold font-display mb-3">Contact.</h2>
        <p>
          You can reach me at{" "}
          <span className="lowercase">blog [at] vblinden.dev</span>.
        </p>
      </section>
    </>
  );
}
