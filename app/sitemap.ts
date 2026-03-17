import type { MetadataRoute } from "next";

import { getAllPosts } from "@/lib/posts";
import { buildAbsoluteUrl } from "@/lib/site";

export default function sitemap(): MetadataRoute.Sitemap {
  const homeUrl = buildAbsoluteUrl("/");

  if (!homeUrl) {
    return [];
  }

  return [
    {
      url: homeUrl,
    },
    ...getAllPosts().flatMap((post) => {
      const url = buildAbsoluteUrl(`/posts/${post.slug}`);

      if (!url) {
        return [];
      }

      return [
        {
          url,
          lastModified: post.publishedAtIso8601 ?? undefined,
        },
      ];
    }),
  ];
}
