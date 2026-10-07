import type { MetadataRoute } from "next";
import { getAllPosts } from "@/lib/posts";
import { absoluteUrl } from "@/lib/site";

export default async function sitemap(): Promise<MetadataRoute.Sitemap> {
  const posts = await getAllPosts();
  const latest = posts[0]?.publishedAtIso8601
    ? new Date(posts[0].publishedAtIso8601)
    : undefined;

  return [
    {
      url: absoluteUrl("/"),
      lastModified: latest,
      changeFrequency: "weekly",
      priority: 1,
    },
    {
      url: absoluteUrl("/posts"),
      lastModified: latest,
      changeFrequency: "weekly",
      priority: 0.9,
    },
    {
      url: absoluteUrl("/feed"),
      changeFrequency: "weekly",
      priority: 0.3,
    },
    ...posts.map((post) => ({
      url: absoluteUrl(`/posts/${post.slug}`),
      lastModified: post.publishedAtIso8601
        ? new Date(post.publishedAtIso8601)
        : undefined,
      changeFrequency: "monthly" as const,
      priority: 0.8,
    })),
  ];
}
