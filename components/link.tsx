import NextLink from "next/link";
import type { AnchorHTMLAttributes, ReactNode } from "react";

interface LinkProps extends AnchorHTMLAttributes<HTMLAnchorElement> {
  href: string;
  children: ReactNode;
}

export default function Link({
  href,
  children,
  target,
  rel,
  className,
  ...props
}: LinkProps) {
  const isExternal =
    /^(?:[a-z]+:)?\/\//i.test(href) ||
    href.startsWith("mailto:") ||
    href.startsWith("tel:");
  const resolvedTarget = target ?? "_self";
  const resolvedRel =
    rel ?? (resolvedTarget === "_blank" ? "noreferrer" : undefined);

  if (isExternal) {
    return (
      <a
        href={href}
        target={resolvedTarget}
        rel={resolvedRel}
        className={className}
        {...props}
      >
        {children}
      </a>
    );
  }

  return (
    <NextLink
      href={href}
      target={resolvedTarget}
      rel={resolvedRel}
      className={className}
      {...props}
    >
      {children}
    </NextLink>
  );
}
