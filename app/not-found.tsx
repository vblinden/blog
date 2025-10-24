import Link from "@/components/link";

export default function NotFound() {
  return (
    <div className="py-12">
      <h2 className="text-3xl font-bold font-display mb-1">Page not found</h2>
      <p className="text-gray-600 dark:text-gray-400 mb-12">
        The page you&apos;re looking for doesn&apos;t exist or has been moved.
      </p>
      <Link href="/" target="_self">
        Back to home
      </Link>
    </div>
  );
}
