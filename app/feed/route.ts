import { cacheLife } from "next/cache";
import { getAllPostsWithContent } from "@/lib/posts";
import { absoluteUrl, site } from "@/lib/site";

function escapeXml(value: string): string {
  return value
    .replace(/&/g, "&amp;")
    .replace(/</g, "&lt;")
    .replace(/>/g, "&gt;")
    .replace(/"/g, "&quot;")
    .replace(/'/g, "&apos;");
}

async function getAtomFeed(): Promise<string> {
  "use cache";
  cacheLife("minutes");

  const posts = await getAllPostsWithContent();
  const updatedAt =
    posts[0]?.publishedAtIso8601 ?? new Date().toISOString();
  const feedUrl = absoluteUrl("/feed");
  const homeUrl = absoluteUrl("/");

  const entries = posts
    .map((post) => {
      const url = absoluteUrl(`/posts/${post.slug}`);
      const dates = post.publishedAtIso8601
        ? `
            <published>${post.publishedAtIso8601}</published>
            <updated>${post.publishedAtIso8601}</updated>`
        : "";

      return `
        <entry>
            <title>${escapeXml(post.title)}</title>
            <link href="${url}" rel="alternate" type="text/html" />
            <id>${url}</id>${dates}
            <summary>${escapeXml(post.description)}</summary>
            <content type="html" xml:base="${homeUrl}">
                <![CDATA[
                    ${post.html}
                ]]>
            </content>
        </entry>`;
    })
    .join("");

  const email = site.social.email
    ? `\n            <email>${escapeXml(site.social.email)}</email>`
    : "";

  return `<?xml version="1.0" encoding="UTF-8"?>
<feed xmlns="http://www.w3.org/2005/Atom">
    <title>${escapeXml(site.name)}</title>
    <subtitle>${escapeXml(site.description)}</subtitle>
    <link href="${feedUrl}" rel="self" type="application/atom+xml" />
    <link href="${homeUrl}" rel="alternate" type="text/html" />
    <id>${homeUrl}</id>
    <updated>${updatedAt}</updated>
    <author>
        <name>${escapeXml(site.author)}</name>
        <uri>${homeUrl}</uri>${email}
    </author>
    ${entries}
</feed>`;
}

export async function GET() {
  const xml = await getAtomFeed();

  return new Response(xml, {
    headers: {
      "Content-Type": "application/atom+xml; charset=UTF-8",
      "Cache-Control": "public, max-age=300",
    },
  });
}
