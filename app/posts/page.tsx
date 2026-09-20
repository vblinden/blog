import type { Metadata } from "next";
import Link from "next/link";
import { getAllPosts } from "@/lib/posts";
import { site } from "@/lib/site";

export const metadata: Metadata = {
  title: "Posts",
  description: `Posts by ${site.author} on software engineering, side projects, and practical lessons.`,
  alternates: {
    canonical: "/posts",
  },
  openGraph: {
    title: `Posts - ${site.title}`,
    description: `Posts by ${site.author} on software engineering, side projects, and practical lessons.`,
    url: "/posts",
  },
};

export default function PostsPage() {
  const posts = getAllPosts();

  return (
    <main>
      <Link className="page-nav" href="/">
        ← Home
      </Link>

      <h1 className="page-title">Posts</h1>

      <div className="home-list home-list-all">
        {posts.map((post) => (
          <article className="home-item" key={post.slug}>
            <h2 className="home-item-title">
              <Link href={`/posts/${post.slug}`}>{post.title}</Link>
              {post.date !== "" && (
                <>
                  <span className="home-item-sep" aria-hidden="true">
                    {" "}
                    —{" "}
                  </span>
                  <time
                    className="home-item-date"
                    dateTime={post.publishedAtIso8601 ?? undefined}
                  >
                    {post.date}
                  </time>
                </>
              )}
            </h2>
          </article>
        ))}
      </div>
    </main>
  );
}
