import type { Metadata } from "next";
import { Instrument_Sans } from "next/font/google";
import Link from "next/link";
import { Analytics } from "@vercel/analytics/next";

import { ThemeToggle } from "@/components/theme-toggle";
import {
  buildAbsoluteUrl,
  homeDescription,
  siteName,
  siteTitle,
} from "@/lib/site";

import "./globals.css";

const instrumentSans = Instrument_Sans({
  subsets: ["latin"],
  variable: "--font-sans",
});

const siteUrl = buildAbsoluteUrl("/");
const themeScript = `
(() => {
  const cookie = document.cookie
    .split("; ")
    .find((value) => value.startsWith("theme="))
    ?.split("=")[1];
  const theme =
    cookie === "light" || cookie === "dark"
      ? cookie
      : window.matchMedia("(prefers-color-scheme: dark)").matches
        ? "dark"
        : "light";

  document.documentElement.classList.toggle("dark", theme === "dark");
  document.documentElement.dataset.theme = theme;
})();
`;

export const metadata: Metadata = {
  metadataBase: siteUrl ? new URL(siteUrl) : undefined,
  title: siteTitle,
  description: homeDescription,
  authors: [{ name: "vblinden" }],
  robots: {
    index: true,
    follow: true,
  },
  alternates: siteUrl
    ? {
        canonical: "/",
      }
    : undefined,
  openGraph: {
    type: "website",
    siteName,
    title: siteTitle,
    description: homeDescription,
    url: siteUrl ?? undefined,
  },
  twitter: {
    card: "summary",
    title: siteTitle,
    description: homeDescription,
  },
};

export default function RootLayout({
  children,
}: Readonly<{
  children: React.ReactNode;
}>) {
  return (
    <html lang="en" suppressHydrationWarning>
      <head>
        <script dangerouslySetInnerHTML={{ __html: themeScript }} />
      </head>
      <body className={instrumentSans.variable}>
        <div className="page-shell">
          <header className="site-header">
            <h1 className="site-title">
              <Link href="/" className="no-underline">
                vblinden.
              </Link>
            </h1>

            <ThemeToggle />
          </header>

          {children}
        </div>
        <Analytics />
      </body>
    </html>
  );
}
