import Header from '@/components/Header';

export default function Post() {
  return (
    <>
      <Header title="What did you undesign?" date="September 28, 2020" readingTime="1" />

      <p className="mb-4">
        In the video below Eric Berger from Ars Technica asks a question on how Elon Musk and the team at SpaceX build
        an iteration of Starship within 4/5 months and how they’d go so fast. Here is the transcript for those who want
        to read instead of listening:
      </p>

      <p className="mb-4">
        <strong>Eric Berger:</strong> How did you go so fast?
      </p>

      <p>
        <strong>Elon Musk:</strong>
      </p>

      <p className="mb-4">I have this mantra: if the schedule is long, it’s wrong. If it’s tight, it’s right.</p>

      <p className="mb-4">Basically just have recursive improvement on a schedule.</p>

      <p className="mb-4">
        Say with every feedback loop: Did this make it go faster? If it did not, we are going to need to fix it. If the
        design takes a long time to build, it’s the wrong design. This is the fundamental thing. The tendency is to
        complicate things.
      </p>

      <p className="mb-4">
        The best process is no process. It weights nothing, it costs nothing. Can’t go wrong. As obvious as that sounds.
        <strong>The best part is no part</strong>.
      </p>

      <p className="mb-4">
        The thing I’m most impressed with when I have the design meetings at SpaceX is: what did you{' '}
        <strong>undesign</strong>?
      </p>

      <p className="mb-4">
        What did you undesign in your projects recently? Or are you in a scenario where you are only adding more and
        more stuff?
      </p>

      <p className="mb-4">
        <strong>Undesigning</strong> is the best thing.
      </p>

      <p className="mb-4">
        <strong>Just delete it.</strong>
      </p>

      <p className="mb-4">
        <strong>That’s the best thing.</strong>
      </p>

      <br />
      <br />

      <p className="mb-4">Enjoy the video.</p>

      <video controls>
        <source src="/videos/undesigning-is-the-best-thing.mp4" type="video/mp4" />
      </video>
    </>
  );
}
