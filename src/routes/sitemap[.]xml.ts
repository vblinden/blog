import { createFileRoute } from "@tanstack/react-router";
import { getAllPosts } from "@/lib/posts";
import { absoluteUrl } from "@/lib/site";

export const Route = createFileRoute("/sitemap.xml")({
  server: {
    handlers: {
      GET: async () => {
        const posts = await getAllPosts();
        const latest = posts[0]?.publishedAtIso8601;

        const urls = [
          {
            loc: absoluteUrl("/"),
            lastmod: latest,
            changefreq: "weekly",
            priority: "1.0",
          },
          {
            loc: absoluteUrl("/posts"),
            lastmod: latest,
            changefreq: "weekly",
            priority: "0.9",
          },
          {
            loc: absoluteUrl("/feed"),
            changefreq: "weekly",
            priority: "0.3",
          },
          ...posts.map((post) => ({
            loc: absoluteUrl(`/posts/${post.slug}`),
            lastmod: post.publishedAtIso8601 ?? undefined,
            changefreq: "monthly",
            priority: "0.8",
          })),
        ];

        const body = `<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
${urls
  .map(
    (entry) => `  <url>
    <loc>${entry.loc}</loc>
${entry.lastmod ? `    <lastmod>${entry.lastmod}</lastmod>\n` : ""}    <changefreq>${entry.changefreq}</changefreq>
    <priority>${entry.priority}</priority>
  </url>`,
  )
  .join("\n")}
</urlset>`;

        return new Response(body, {
          headers: {
            "Content-Type": "application/xml; charset=UTF-8",
            "Cache-Control": "public, max-age=3600",
          },
        });
      },
    },
  },
});
