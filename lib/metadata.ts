import { site, absoluteUrl } from "@/lib/site";
import type { Metadata } from "next";

export const defaultMetadata: Metadata = {
  metadataBase: new URL(site.url),
  title: {
    default: site.title,
    template: `%s - ${site.title}`,
  },
  description: site.description,
  authors: [{ name: site.author, url: site.url }],
  robots: {
    index: true,
    follow: true,
    googleBot: {
      index: true,
      follow: true,
      "max-image-preview": "large",
    },
  },
  alternates: {
    canonical: "/",
    types: {
      "application/atom+xml": absoluteUrl("/feed"),
    },
  },
  openGraph: {
    type: "website",
    siteName: site.name,
    locale: site.locale,
    title: site.title,
    description: site.description,
    url: "/",
    images: [{ url: "/apple-touch-icon.png" }],
  },
  twitter: {
    card: "summary",
    site: `@${site.authorHandle}`,
    creator: `@${site.authorHandle}`,
    title: site.title,
    description: site.description,
    images: ["/apple-touch-icon.png"],
  },
  icons: {
    icon: [
      { url: "/favicon.png", type: "image/png" },
      { url: "/favicon.svg", type: "image/svg+xml" },
    ],
    apple: "/apple-touch-icon.png",
  },
};
