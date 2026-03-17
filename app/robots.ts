import type { MetadataRoute } from "next";

import { buildAbsoluteUrl } from "@/lib/site";

export default function robots(): MetadataRoute.Robots {
  const siteUrl = buildAbsoluteUrl("/");
  const sitemapUrl = buildAbsoluteUrl("/sitemap.xml");

  return {
    rules: {
      userAgent: "*",
      allow: "/",
    },
    host: siteUrl ?? undefined,
    sitemap: sitemapUrl ?? undefined,
  };
}
