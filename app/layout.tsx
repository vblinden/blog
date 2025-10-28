import type { Metadata } from "next";
import { Geist, Geist_Mono } from "next/font/google";
import Link from "next/link";
import { Analytics } from "@vercel/analytics/next";

import "./globals.css";

const geistSans = Geist({
  variable: "--font-geist-sans",
  subsets: ["latin"],
});

const geistMono = Geist_Mono({
  variable: "--font-geist-mono",
  subsets: ["latin"],
});

export const metadata: Metadata = {
  title: "vblinden",
  description:
    "I am currently working at team.blue as a senior software engineer. This is my little corner of the web for stuff I've found important, handy, or just wanted to save. Hope you find something interesting!",
};

export default function RootLayout({
  children,
}: Readonly<{
  children: React.ReactNode;
}>) {
  return (
    <html lang="en">
      <head>
        <link
          rel="shortcut icon"
          href="data:image/x-icon;,"
          type="image/x-icon"
        />
      </head>

      <body
        className={`text-lg antialiased ${geistSans.variable} ${geistMono.variable}`}
      >
        <div className="max-w-4xl mx-auto mb-8">
          <div className="mx-3">
            <div className="my-8">
              <h1 className="text-3xl font-bold mb-3 font-sans">
                <Link
                  href="/"
                  className="hover:text-blue-600 dark:text-white dark:hover:text-slate-100 text-4xl font-display"
                >
                  vblinden.
                </Link>
              </h1>
            </div>

            {children}
          </div>
        </div>
        <Analytics />
      </body>
    </html>
  );
}
