import { notFound } from "next/navigation";
import { getPostData, getAllPostSlugs } from "@/lib/posts";
import Link from "@/components/link";
import Markdown from "@/components/markdown";

interface PostPageProps {
  params: Promise<{ slug: string }>;
}

export async function generateStaticParams() {
  const slugs = getAllPostSlugs();
  return slugs.map((slug) => ({
    slug,
  }));
}

export async function generateMetadata({ params }: PostPageProps) {
  const { slug } = await params;
  const post = getPostData(slug);

  if (!post) {
    return {
      title: "Post Not Found",
    };
  }

  return {
    title: `${post.title} — vblinden`,
    description: post.title,
  };
}

export default async function PostPage({ params }: PostPageProps) {
  const { slug } = await params;
  const post = getPostData(slug);

  if (!post) {
    notFound();
  }

  return (
    <article className="markdown prose prose-lg prose-gray max-w-none dark:prose-invert">
      <header className="mb-8">
        <h1 className="text-4xl font-bold font-display mb-1">{post.title}</h1>
        {post.date && (
          <time className="text-gray-600 dark:text-gray-400">
            {new Date(post.date).toLocaleDateString("en-US", {
              year: "numeric",
              month: "long",
              day: "numeric",
            })}
          </time>
        )}
      </header>

      <div className="prose prose-lg max-w-none dark:prose-invert">
        <Markdown content={post.content} />
      </div>

      <footer className="mt-12 pt-8">
        <Link href="/" target="_self">
          Back to home
        </Link>
      </footer>
    </article>
  );
}
