import Link from '@/components/Link';

export default function NotFound() {
  return (
    <div>
      <h2 className="text-xl font-bold mb-4">We can't find the page you are looking for.</h2>

      <Link href="/">Return back home</Link>
    </div>
  );
}
