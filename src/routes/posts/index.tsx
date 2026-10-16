import { createFileRoute, Link } from "@tanstack/react-router";
import { getAllPosts } from "@/lib/posts";
import { site } from "@/lib/site";
import { pageHead } from "@/lib/head";

const postsDescription = `Posts by ${site.author} on software engineering, side projects, and practical lessons.`;

export const Route = createFileRoute("/posts/")({
  loader: () => getAllPosts(),
  head: () =>
    pageHead({
      title: "Posts",
      description: postsDescription,
      path: "/posts",
    }),
  component: PostsPage,
});

function PostsPage() {
  const posts = Route.useLoaderData();

  return (
    <main>
      <Link className="page-nav" to="/">
        ← Home
      </Link>

      <h1 className="page-title">Posts</h1>

      <div className="home-list home-list-all">
        {posts.map((post) => (
          <article className="home-item" key={post.slug}>
            <h2 className="home-item-title">
              <Link to="/posts/$slug" params={{ slug: post.slug }}>
                {post.title}
              </Link>
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
