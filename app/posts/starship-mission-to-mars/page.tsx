import Link from '@/components/Link';
import Header from '@/components/Header';

export default function Post() {
  return (
    <>
      <Header title="Starship Mission to Mars" date="January 14, 2024" readingTime="5" />

      <p className="mb-4">Just a video that I want to archive in case it will disappear from the internet.</p>

      <p className="mb-4">Enjoy the video.</p>

      <video controls>
        <source src="/videos/starship-mission-to-mars.mp4" type="video/mp4" />
      </video>

      <p className="text-center text-sm text-slate-500 dark:text-zinc-600 mt-2">
        Copyright belongs to SpaceX, original video can be found here:
        <Link href="https://www.youtube.com/watch?v=921VbEMAwwY">https://www.youtube.com/watch?v=PMp3lJl2zE8</Link>
      </p>
    </>
  );
}
