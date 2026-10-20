import { createFileRoute, Link, notFound } from "@tanstack/react-router";
import { JsonLd } from "@/components/json-ld";
import { getPostWithAdjacent, wordCount } from "@/lib/posts";
import { absoluteUrl, site } from "@/lib/site";
import { pageHead } from "@/lib/head";

export const Route = createFileRoute("/posts/$slug")({
  loader: async ({ params }) => {
    const result = await getPostWithAdjacent({ data: { slug: params.slug } });
    if (!result.post) {
      throw notFound();
    }
    return result;
  },
  head: ({ loaderData }) => {
    if (!loaderData?.post) {
      return { meta: [{ title: "Not found" }] };
    }

    const { post, newer, older } = loaderData;
    const base = pageHead({
      title: post.title,
      description: post.description,
      path: `/posts/${post.slug}`,
      type: "article",
      publishedTime: post.publishedAtIso8601,
    });

    return {
      ...base,
      links: [
        ...base.links,
        ...(older
          ? [{ rel: "prev", href: `/posts/${older.slug}` }]
          : []),
        ...(newer
          ? [{ rel: "next", href: `/posts/${newer.slug}` }]
          : []),
      ],
    };
  },
  component: PostPage,
});

function PostPage() {
  const { post, newer, older } = Route.useLoaderData();

  if (!post) {
    return null;
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
                <Link to="/posts/$slug" params={{ slug: older.slug }}>
                  {older.title}
                </Link>
              </>
            )}
          </div>
          <div className="article-nav-item article-nav-item-end">
            {newer && (
              <>
                <span className="article-nav-label">Newer</span>
                <Link to="/posts/$slug" params={{ slug: newer.slug }}>
                  {newer.title}
                </Link>
              </>
            )}
          </div>
        </nav>

        <footer className="article-footer">
          <Link className="page-nav" to="/">
            ← Home
          </Link>
          <Link to="/posts">Go to all posts</Link>
        </footer>
      </article>
    </>
  );
}
