import type { Metadata } from "next";
import { notFound } from "next/navigation";

import Link from "@/components/link";
import Markdown from "@/components/markdown";
import { getAllPostSlugs, getPostData } from "@/lib/posts";
import { buildAbsoluteUrl, siteName } from "@/lib/site";

interface PostPageProps {
  params: Promise<{ slug: string }>;
}

export async function generateStaticParams() {
  return getAllPostSlugs().map((slug) => ({
    slug,
  }));
}

export async function generateMetadata({
  params,
}: PostPageProps): Promise<Metadata> {
  const { slug } = await params;
  const post = getPostData(slug);

  if (!post) {
    return {
      title: "Post not found",
    };
  }

  const canonicalUrl = buildAbsoluteUrl(`/posts/${post.slug}`);
  const title = `${post.title} - vblinden`;

  return {
    title,
    description: post.description,
    alternates: canonicalUrl
      ? {
          canonical: canonicalUrl,
        }
      : undefined,
    openGraph: {
      type: "article",
      siteName,
      title,
      description: post.description,
      ...(canonicalUrl ? { url: canonicalUrl } : {}),
      ...(post.publishedAtIso8601
        ? { publishedTime: post.publishedAtIso8601 }
        : {}),
    },
    twitter: {
      card: "summary",
      title,
      description: post.description,
    },
  };
}

export default async function PostPage({ params }: PostPageProps) {
  const { slug } = await params;
  const post = getPostData(slug);

  if (!post) {
    notFound();
  }

  const canonicalUrl = buildAbsoluteUrl(`/posts/${post.slug}`);
  const jsonLd = {
    "@context": "https://schema.org",
    "@type": "BlogPosting",
    headline: post.title,
    description: post.description,
    author: {
      "@type": "Person",
      name: "Vincent van der Linden",
    },
    publisher: {
      "@type": "Person",
      name: "Vincent van der Linden",
    },
    ...(canonicalUrl
      ? {
          mainEntityOfPage: canonicalUrl,
          url: canonicalUrl,
        }
      : {}),
    ...(post.publishedAtIso8601
      ? {
          datePublished: post.publishedAtIso8601,
          dateModified: post.publishedAtIso8601,
        }
      : {}),
  };

  return (
    <>
      <script
        type="application/ld+json"
        dangerouslySetInnerHTML={{ __html: JSON.stringify(jsonLd) }}
      />

      <article className="max-w-3xl">
        <header className="article-header">
          {post.date !== "" && <time className="article-date">{post.date}</time>}

          <h1 className="article-title">{post.title}</h1>

          <p className="article-meta">{post.readingTime} min read</p>
        </header>

        <div className="markdown">
          <Markdown content={post.content} />
        </div>

        <footer className="article-footer">
          <Link href="/">Back to home</Link>
        </footer>
      </article>
    </>
  );
}
