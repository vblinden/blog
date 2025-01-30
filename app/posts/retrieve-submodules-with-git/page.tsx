import Link from '@/components/Link';
import Code from '@/components/Code';
import Header from '@/components/Header';

export default function Post() {
  return (
    <>
      <Header title="Retrieve submodules with Git" date="August 29, 2019" readingTime="1" />

      <p className="mb-4">
        Yesterday I had a really hard time with pulling in a submodule from an old git repository I had lying around. I
        thought a quick Google with DuckDuckGo would solve all my problems, but alas. There was a lot of outdated
        information that simply didn't work with the Git version I had installed on my computer (or maybe I just applied
        it incorrectly).
      </p>

      <p className="mb-4">
        Finally I found an
        <Link href="https://stackoverflow.com/a/44692935" target="_blank" space>
          answer
        </Link>
        on StackOverflow that didn't quite work, but send me in the right direction. Eventually I gave up the
        DuckDuckGoing and did what I should have done in the first place: Look at the
        <Link href="https://git-scm.com/docs/git-submodule" target="_blank" space>
          Git documentation
        </Link>
        for the submodule command.
      </p>

      <p className="mb-4">
        The command I ran (from the root of my git folder) that worked for me after I cloned my repository was:
      </p>

      <Code className="mb-4" lang="shell" code={`git submodule update --init --recursive`} />

      <p>An important lesson learned: If there is documentation available, consult that first.</p>
    </>
  );
}
