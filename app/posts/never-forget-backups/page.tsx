import Link from '@/components/Link';
import Header from '@/components/Header';

export default function Post() {
  return (
    <>
      <Header title="Never. Forget. Backups." date="August 26, 2019" readingTime="1" />

      <p>
        Unfortunately DigitalOcean had a node failure yesterday in their AMS3 data center. And sadly my virtual machine
        running my blog was on there and I didn’t have backups enabled. So all my data is permanently gone. Which is not
        a huge problem, because I only had two small blog posts on here. So today I decided to make my blog again with
        the amazing
        <Link href="https://nextjs.org/" target="_blank" space>
          Next.js
        </Link>
        framework. Let's see how it holds up.
      </p>
    </>
  );
}
