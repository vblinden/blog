import { absoluteUrl, site } from "./site";

type Meta = Record<string, string | undefined>;

export function defaultHead() {
  return {
    meta: [
      { charSet: "utf-8" },
      { name: "viewport", content: "width=device-width, initial-scale=1" },
      { title: site.title },
      { name: "description", content: site.description },
      { name: "author", content: site.author },
      { name: "robots", content: "index, follow" },
      {
        name: "googlebot",
        content: "index, follow, max-image-preview:large",
      },
      { property: "og:type", content: "website" },
      { property: "og:site_name", content: site.name },
      { property: "og:locale", content: site.locale },
      { property: "og:title", content: site.title },
      { property: "og:description", content: site.description },
      { property: "og:url", content: absoluteUrl("/") },
      {
        property: "og:image",
        content: absoluteUrl("/apple-touch-icon.png"),
      },
      { name: "twitter:card", content: "summary" },
      { name: "twitter:site", content: `@${site.authorHandle}` },
      { name: "twitter:creator", content: `@${site.authorHandle}` },
      { name: "twitter:title", content: site.title },
      { name: "twitter:description", content: site.description },
      {
        name: "twitter:image",
        content: absoluteUrl("/apple-touch-icon.png"),
      },
      {
        name: "theme-color",
        content: "#ffffff",
        media: "(prefers-color-scheme: light)",
      },
      {
        name: "theme-color",
        content: "#1a1a1a",
        media: "(prefers-color-scheme: dark)",
      },
    ] satisfies Meta[],
    links: [
      { rel: "canonical", href: absoluteUrl("/") },
      {
        rel: "alternate",
        type: "application/atom+xml",
        title: site.name,
        href: absoluteUrl("/feed"),
      },
      { rel: "icon", href: "/favicon.png", type: "image/png" },
      { rel: "icon", href: "/favicon.svg", type: "image/svg+xml" },
      { rel: "apple-touch-icon", href: "/apple-touch-icon.png" },
    ],
  };
}

export function pageHead({
  title,
  description,
  path,
  type = "website",
  publishedTime,
}: {
  title: string;
  description: string;
  path: string;
  type?: "website" | "article";
  publishedTime?: string | null;
}) {
  const url = absoluteUrl(path);
  const fullTitle = title === site.title ? title : `${title} - ${site.title}`;

  return {
    meta: [
      { title: fullTitle },
      { name: "description", content: description },
      { property: "og:type", content: type },
      { property: "og:title", content: fullTitle },
      { property: "og:description", content: description },
      { property: "og:url", content: url },
      { name: "twitter:title", content: fullTitle },
      { name: "twitter:description", content: description },
      ...(type === "article"
        ? [
            ...(publishedTime
              ? [
                  {
                    property: "article:published_time",
                    content: publishedTime,
                  },
                  {
                    property: "article:modified_time",
                    content: publishedTime,
                  },
                ]
              : []),
            { property: "article:author", content: site.author },
            {
              property: "article:section",
              content: "Software engineering",
            },
          ]
        : []),
    ] satisfies Meta[],
    links: [{ rel: "canonical", href: url }],
  };
}
