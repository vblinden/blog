import type { ReactNode } from "react";
import {
  Outlet,
  createRootRoute,
  HeadContent,
  Scripts,
  Link,
} from "@tanstack/react-router";
import { defaultHead } from "@/lib/head";
import "@fontsource-variable/geist";
import "@fontsource-variable/geist-mono";
import "@/styles/globals.css";

export const Route = createRootRoute({
  head: () => defaultHead(),
  notFoundComponent: NotFound,
  component: RootComponent,
});

function RootComponent() {
  return (
    <RootDocument>
      <Outlet />
    </RootDocument>
  );
}

function RootDocument({ children }: Readonly<{ children: ReactNode }>) {
  return (
    <html lang="en" className="antialiased">
      <head>
        <HeadContent />
      </head>
      <body>
        <a className="skip-link" href="#main-content">
          Skip to content
        </a>
        <div id="main-content">{children}</div>
        <Scripts />
      </body>
    </html>
  );
}

function NotFound() {
  return (
    <main>
      <h1 className="page-title">Not found</h1>
      <p className="prose-note">That page doesn&apos;t exist.</p>
      <p className="home-section-more">
        <Link to="/">← Home</Link>
      </p>
    </main>
  );
}
