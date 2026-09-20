import Link from "next/link";

export default function NotFound() {
  return (
    <main>
      <h1 className="page-title">Not found</h1>
      <p className="prose-note">That page doesn&apos;t exist.</p>
      <p className="home-section-more">
        <Link href="/">← Home</Link>
      </p>
    </main>
  );
}
