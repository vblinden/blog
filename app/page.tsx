import Link from "next/link";
import { JsonLd } from "@/components/json-ld";
import { ClampedDescription } from "@/components/clamped-description";
import { getAllPosts } from "@/lib/posts";
import { absoluteUrl, getProjectsForHome, site } from "@/lib/site";

export default function HomePage() {
  const posts = getAllPosts();
  const latest = posts.slice(0, 5);
  const projectList = getProjectsForHome();
  const sameAs = [site.social.github, site.social.x].filter(Boolean);
  const canonicalUrl = absoluteUrl("/");

  const jsonLd = [
    {
      "@context": "https://schema.org",
      "@type": "WebSite",
      name: site.name,
      description: site.description,
      url: canonicalUrl,
      inLanguage: "en",
      author: {
        "@type": "Person",
        name: site.author,
        url: canonicalUrl,
      },
      potentialAction: {
        "@type": "ReadAction",
        target: canonicalUrl,
      },
    },
    {
      "@context": "https://schema.org",
      "@type": "Blog",
      name: site.name,
      description: site.description,
      url: canonicalUrl,
      inLanguage: "en",
      author: {
        "@type": "Person",
        name: site.author,
        url: canonicalUrl,
        sameAs,
      },
      blogPost: posts.slice(0, 10).map((post) => ({
        "@type": "BlogPosting",
        headline: post.title,
        url: absoluteUrl(`/posts/${post.slug}`),
        datePublished: post.publishedAtIso8601,
        description: post.description,
      })),
    },
    {
      "@context": "https://schema.org",
      "@type": "Person",
      name: site.author,
      alternateName: site.authorHandle,
      url: canonicalUrl,
      jobTitle: "Software engineer",
      sameAs,
      email: site.social.email,
    },
  ];

  return (
    <>
      <JsonLd data={jsonLd} />
      <main>
        <header className="home-intro">
          <h1 className="page-title">{site.name}</h1>
          <p>
            Software engineer at{" "}
            <a href="https://team.blue" target="_blank" rel="noreferrer">
              team.blue
            </a>
            . Online I&apos;m{" "}
            <a href={site.social.github} target="_blank" rel="noreferrer">
              @{site.authorHandle}
            </a>
            . This is where I write down things I&apos;ve found useful,
            important, or worth keeping.
          </p>
        </header>

        <section className="home-section" aria-labelledby="latest-posts-heading">
          <div className="home-section-header">
            <h2 id="latest-posts-heading" className="home-section-title">
              Latest posts
            </h2>
          </div>

          <div className="home-list">
            {latest.map((post) => (
              <article className="home-item" key={post.slug}>
                <h3 className="home-item-title">
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
                </h3>
                {post.description !== "" && (
                  <p className="home-item-description">{post.description}</p>
                )}
              </article>
            ))}
          </div>

          <p className="home-section-more">
            <Link href="/posts">Go to all posts</Link>
          </p>
        </section>

        <section className="home-section" aria-labelledby="projects-heading">
          <div className="home-section-header">
            <h2 id="projects-heading" className="home-section-title">
              Projects
            </h2>
          </div>

          <div className="home-grid">
            {projectList.map((project) => {
              const isSunset = (project.status ?? "active") === "sunset";

              return (
                <div
                  className={`home-item${isSunset ? " is-sunset" : ""}`}
                  key={project.name}
                >
                  <h3 className="home-item-title">
                    {isSunset ? (
                      <>
                        <span>{project.name}</span>
                        <span className="sunset-badge">sunset</span>
                      </>
                    ) : (
                      <a
                        href={project.url}
                        target="_blank"
                        rel="noreferrer"
                      >
                        {project.name}
                      </a>
                    )}
                  </h3>
                  <ClampedDescription title={project.description}>
                    {project.description}
                  </ClampedDescription>
                </div>
              );
            })}
          </div>
        </section>

        <footer className="home-footer">
          <nav className="home-footer-links" aria-label="Elsewhere">
            <Link href="/posts">Posts</Link>
            <a href={site.social.github} target="_blank" rel="noreferrer">
              GitHub
            </a>
            <a href={site.social.x} target="_blank" rel="noreferrer">
              X
            </a>
            <a href={`mailto:${site.social.email}`}>Email</a>
            <a href="/feed">RSS</a>
          </nav>
          <p className="prose-note">
            Opinions here are my own and do not represent my employer. If you
            need help with any of the products, contact me on{" "}
            <a href={site.social.x} target="_blank" rel="noreferrer">
              X
            </a>
            .
          </p>
        </footer>
      </main>
    </>
  );
}
