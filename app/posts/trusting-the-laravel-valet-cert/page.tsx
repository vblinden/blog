import Code from '@/components/Code';
import Header from '@/components/Header';

export default function Post() {
  return (
    <>
      <Header title="Trusting the Laravel Valet cert" date="Augustus 16, 2024" readingTime="1" />

      <p className="mb-4">
        Sometimes your PHP processes will not trust the Laravel Valet certificate when communicating between sites. This
        can be fixed by adding the certificate to the list of trusted certificates in your locally Homebrew
        <strong>cacert.pem</strong> file (which is then being used by OpenSSL). Btw, these instructions are for macOS,
        but I think it should be similar for other operating systems.
      </p>

      <p className="mb-4">First get the Laravel Valet certificate.</p>

      <Code className="mb-4" lang="shell" code={`cat ~/.config/valet/CA/LaravelValetCASelfSigned.pem | pbcopy`} />

      <p className="mb-4">Then add it to the bottom of the locally Homebrew cert (which is being used by OpenSSL).</p>

      <Code className="mb-4" lang="shell" code={`vim /opt/homebrew/etc/ca-certificates/cert.pem`}></Code>

      <p className="mb-4">
        Restart the services with <strong>valet restart</strong> and you should be good to go. Hope it helps!
      </p>
    </>
  );
}
