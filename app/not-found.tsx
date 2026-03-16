import Link from "@/components/link";

export default function NotFound() {
  return (
    <section className="max-w-3xl">
      <h2 className="section-title">Page not found</h2>
      <p className="lede">
        The page you&apos;re looking for doesn&apos;t exist or has been moved.
      </p>
      <p className="mt-6">
        <Link href="/">Back to home</Link>
      </p>
    </section>
  );
}
