import type { Metadata } from "next";
import Link from "next/link";
import { notFound } from "next/navigation";
import { JsonLd } from "@/components/json-ld";
import {
  getPostSlugs,
  getPostWithAdjacent,
  wordCount,
} from "@/lib/posts";
import { absoluteUrl, site } from "@/lib/site";

export async function generateStaticParams() {
  const slugs = await getPostSlugs();
  return slugs.map((slug) => ({ slug }));
}

export async function generateMetadata({
  params,
}: PageProps<"/posts/[slug]">): Promise<Metadata> {
  const { slug } = await params;
  const { post } = await getPostWithAdjacent(slug);

  if (!post) {
    return { title: "Not found" };
  }

  return {
    title: post.title,
    description: post.description,
    alternates: {
      canonical: `/posts/${post.slug}`,
    },
    openGraph: {
      type: "article",
      title: `${post.title} - ${site.title}`,
      description: post.description,
      url: `/posts/${post.slug}`,
      publishedTime: post.publishedAtIso8601 ?? undefined,
      modifiedTime: post.publishedAtIso8601 ?? undefined,
      authors: [site.author],
      section: "Software engineering",
    },
    twitter: {
      title: `${post.title} - ${site.title}`,
      description: post.description,
    },
    other: {
      ...(post.publishedAtIso8601
        ? {
            "article:published_time": post.publishedAtIso8601,
            "article:modified_time": post.publishedAtIso8601,
          }
        : {}),
      "article:author": site.author,
      "article:section": "Software engineering",
    },
  };
}

export default async function PostPage({
  params,
}: PageProps<"/posts/[slug]">) {
  const { slug } = await params;
  const { post, newer, older } = await getPostWithAdjacent(slug);

  if (!post) {
    notFound();
  }

  const canonicalUrl = absoluteUrl(`/posts/${post.slug}`);
  const sameAs = [site.social.github, site.social.x].filter(Boolean);

  const jsonLd = [
    {
      "@context": "https://schema.org",
      "@type": "BlogPosting",
      headline: post.title,
      description: post.description,
      author: {
        "@type": "Person",
        name: site.author,
        url: absoluteUrl("/"),
        sameAs,
      },
      publisher: {
        "@type": "Person",
        name: site.author,
        url: absoluteUrl("/"),
      },
      mainEntityOfPage: {
        "@type": "WebPage",
        "@id": canonicalUrl,
      },
      url: canonicalUrl,
      inLanguage: "en",
      wordCount: wordCount(post.html || post.content),
      timeRequired: `PT${post.readingTime}M`,
      isPartOf: {
        "@type": "Blog",
        name: site.name,
        url: absoluteUrl("/"),
      },
      ...(post.publishedAtIso8601
        ? {
            datePublished: post.publishedAtIso8601,
            dateModified: post.publishedAtIso8601,
          }
        : {}),
    },
    {
      "@context": "https://schema.org",
      "@type": "BreadcrumbList",
      itemListElement: [
        {
          "@type": "ListItem",
          position: 1,
          name: "Home",
          item: absoluteUrl("/"),
        },
        {
          "@type": "ListItem",
          position: 2,
          name: post.title,
          item: canonicalUrl,
        },
      ],
    },
  ];

  return (
    <>
      <JsonLd data={jsonLd} />
      {older && <link rel="prev" href={`/posts/${older.slug}`} />}
      {newer && <link rel="next" href={`/posts/${newer.slug}`} />}

      <article className="article">
        <header className="article-header">
          <h1 className="article-title">{post.title}</h1>
          <p className="article-meta">
            {post.date !== "" && (
              <>
                <time
                  className="article-date"
                  dateTime={post.publishedAtIso8601 ?? undefined}
                >
                  {post.date}
                </time>
                <span aria-hidden="true">—</span>
              </>
            )}
            <span>{post.readingTime} min read</span>
          </p>
        </header>

        <div
          className="markdown"
          dangerouslySetInnerHTML={{ __html: post.html }}
        />

        <nav className="article-nav" aria-label="Post navigation">
          <div className="article-nav-item">
            {older && (
              <>
                <span className="article-nav-label">Older</span>
                <Link href={`/posts/${older.slug}`}>{older.title}</Link>
              </>
            )}
          </div>
          <div className="article-nav-item article-nav-item-end">
            {newer && (
              <>
                <span className="article-nav-label">Newer</span>
                <Link href={`/posts/${newer.slug}`}>{newer.title}</Link>
              </>
            )}
          </div>
        </nav>

        <footer className="article-footer">
          <Link className="page-nav" href="/">
            ← Home
          </Link>
          <Link href="/posts">Go to all posts</Link>
        </footer>
      </article>
    </>
  );
}
