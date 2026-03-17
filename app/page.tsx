import type { Metadata } from "next";
import { Fragment } from "react";

import Link from "@/components/link";
import { getAllPosts } from "@/lib/posts";
import {
  buildAbsoluteUrl,
  homeDescription,
  projects,
  siteName,
  siteTitle,
} from "@/lib/site";

const canonicalUrl = buildAbsoluteUrl("/");

export const metadata: Metadata = {
  title: siteTitle,
  description: homeDescription,
  alternates: canonicalUrl
    ? {
        canonical: canonicalUrl,
      }
    : undefined,
  openGraph: {
    type: "website",
    siteName,
    title: siteTitle,
    description: homeDescription,
    url: canonicalUrl ?? undefined,
  },
  twitter: {
    card: "summary",
    title: siteTitle,
    description: homeDescription,
  },
};

export default function Home() {
  const allPosts = getAllPosts();
  const jsonLd = [
    {
      "@context": "https://schema.org",
      "@type": "WebSite",
      name: siteName,
      description: homeDescription,
      ...(canonicalUrl ? { url: canonicalUrl } : {}),
    },
    {
      "@context": "https://schema.org",
      "@type": "Blog",
      name: siteName,
      description: homeDescription,
      author: {
        "@type": "Person",
        name: "vblinden",
      },
      ...(canonicalUrl ? { url: canonicalUrl } : {}),
    },
  ];

  return (
    <>
      <script
        type="application/ld+json"
        dangerouslySetInnerHTML={{ __html: JSON.stringify(jsonLd) }}
      />

      <main className="space-y-14">
        <section className="max-w-3xl">
          <p className="lede">
            Hey friends, my name is Vincent van der Linden and you can find me
            online as{" "}
            <Link href="https://github.com/vblinden" target="_blank">
              @vblinden
            </Link>
            . I am currently working at{" "}
            <Link href="https://team.blue" target="_blank">
              team.blue
            </Link>{" "}
            as a senior software engineer. This is my little corner of the web
            for stuff I&apos;ve found important, handy, or just wanted to save.
            Hope you find something interesting! The opinions expressed herein
            are my own personal opinions and do not represent my employer&apos;s
            view in any way.
          </p>
        </section>

        <section>
          <h2 className="section-title">Posts.</h2>

          <ul className="post-list">
            {allPosts.map((post) => (
              <li key={post.slug}>
                <Link href={`/posts/${post.slug}`}>{post.title}</Link>
              </li>
            ))}
          </ul>
        </section>

        <section>
          <h2 className="section-title">Projects.</h2>

          <dl className="project-list max-w-3xl">
            {projects.map((project) => (
              <Fragment key={project.name}>
                <dt>
                  <Link href={project.url} target="_blank">
                    {project.name}
                  </Link>
                </dt>
                <dd dangerouslySetInnerHTML={{ __html: project.description }} />
              </Fragment>
            ))}
          </dl>
        </section>
      </main>
    </>
  );
}
