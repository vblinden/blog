import type { Metadata } from "next";
import { Instrument_Sans } from "next/font/google";
import Link from "next/link";
import Script from "next/script";
import { Analytics } from "@vercel/analytics/next";

import {
  buildAbsoluteUrl,
  homeDescription,
  siteName,
  siteTitle,
} from "@/lib/site";

import "./globals.css";

const instrumentSans = Instrument_Sans({
  subsets: ["latin"],
  weight: ["400", "500", "600"],
  variable: "--font-instrument-sans",
  display: "swap",
});

const siteUrl = buildAbsoluteUrl("/");

export const metadata: Metadata = {
  metadataBase: siteUrl ? new URL(siteUrl) : undefined,
  title: siteTitle,
  description: homeDescription,
  authors: [{ name: "Vincent van der Linden" }],
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
        <link
          rel="shortcut icon"
          href="data:image/x-icon;,"
          type="image/x-icon"
        />
        <Script id="theme-init" strategy="beforeInteractive">
          {`(() => {
            const storageKey = 'theme';
            const storedTheme = localStorage.getItem(storageKey);
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            const activeTheme = storedTheme ?? (prefersDark ? 'dark' : 'light');

            document.documentElement.classList.toggle('dark', activeTheme === 'dark');
            document.documentElement.style.colorScheme = activeTheme;
          })();`}
        </Script>
      </head>

      <body className={instrumentSans.variable}>
        <div className="page-shell">
          <header className="site-header">
            <h1 className="site-title">
              <Link href="/" className="no-underline">
                vblinden.
              </Link>
            </h1>

            <button
              type="button"
              className="theme-toggle"
              data-theme-toggle
              aria-label="Switch to dark mode"
              aria-pressed="false"
            >
              <span
                className="theme-toggle-icon"
                data-theme-toggle-icon
                aria-hidden="true"
              >
                ☀️
              </span>
              <span className="sr-only" data-theme-toggle-label>
                Dark mode
              </span>
            </button>
          </header>

          {children}
        </div>

        <Script id="theme-toggle" strategy="afterInteractive">
          {`const storageKey = 'theme';
const themeToggle = document.querySelector('[data-theme-toggle]');
const themeToggleLabel = document.querySelector('[data-theme-toggle-label]');
const themeToggleIcon = document.querySelector('[data-theme-toggle-icon]');
const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');

const applyTheme = (theme) => {
    const isDark = theme === 'dark';

    document.documentElement.classList.toggle('dark', isDark);
    document.documentElement.style.colorScheme = theme;

    if (themeToggle !== null) {
        themeToggle.setAttribute('aria-pressed', isDark ? 'true' : 'false');
        themeToggle.setAttribute('aria-label', isDark ? 'Switch to light mode' : 'Switch to dark mode');
    }

    if (themeToggleLabel !== null) {
        themeToggleLabel.textContent = isDark ? 'Light mode' : 'Dark mode';
    }

    if (themeToggleIcon !== null) {
        themeToggleIcon.textContent = isDark ? '🌕' : '☀️';
    }
};

const resolveInitialTheme = () => {
    const storedTheme = window.localStorage.getItem(storageKey);

    if (storedTheme === 'light' || storedTheme === 'dark') {
        return storedTheme;
    }

    return mediaQuery.matches ? 'dark' : 'light';
};

applyTheme(resolveInitialTheme());

themeToggle?.addEventListener('click', () => {
    const nextTheme = document.documentElement.classList.contains('dark') ? 'light' : 'dark';

    window.localStorage.setItem(storageKey, nextTheme);
    applyTheme(nextTheme);
});

mediaQuery.addEventListener('change', (event) => {
    if (window.localStorage.getItem(storageKey) !== null) {
        return;
    }

    applyTheme(event.matches ? 'dark' : 'light');
});`}
        </Script>
        <Analytics />
      </body>
    </html>
  );
}
