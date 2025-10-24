import Link from "@/components/link";

export default function NotFound() {
  return (
    <div className="text-center py-12">
      <h2 className="text-3xl font-bold font-display mb-4">Post Not Found</h2>
      <p className="text-gray-600 dark:text-gray-400 mb-6">
        The post you&apos;re looking for doesn&apos;t exist or has been moved.
      </p>
      <Link
        href="/"
        target="_self"
        className="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300"
      >
        ← Back to home
      </Link>
    </div>
  );
}
