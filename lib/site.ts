export const siteName = "vblinden";
export const siteTitle = "vblinden";
export const homeDescription =
  "Personal blog of vblinden about software engineering, side projects, deployment, Laravel, and practical lessons from building things.";

const configuredSiteUrl = process.env.NEXT_PUBLIC_SITE_URL?.trim().replace(
  /\/$/,
  "",
);

export function buildAbsoluteUrl(path = "/") {
  if (!configuredSiteUrl) {
    return null;
  }

  return new URL(path, `${configuredSiteUrl}/`).toString();
}

export const projects = [
  {
    name: "sendwich.dev",
    url: "https://sendwich.dev",
    description:
      "It's a lean, developer-first transactional email service that delivers the essentials without the bloat, gimmicks, or hidden pricing tricks.",
  },
  {
    name: "checkeroni.com",
    url: "https://www.checkeroni.com",
    description:
      "Minimal, simple and inexpensive 24/7 uptime monitoring service. Create an account, add an url, and it will check it every couple of minutes. When the url is down, it will notify you via email, SMS or by pinging a webhook.",
  },
  {
    name: "whatswrong.dev",
    url: "https://whatswrong.dev",
    description:
      "Great tool to help you find out what's wrong with your website. Application exception tracking service for Laravel. A sort of Sentry light.",
  },
  {
    name: "staravatars.com",
    url: "https://staravatars.com",
    description:
      "Create beautiful space and star based avatars based on the text provided. I use this for my own projects to get rid of the boring default avatars.",
  },
  {
    name: "nederboard.nl",
    url: "https://nederboard.nl",
    description:
      'A soundboard with snippets from all kinds of different meme videos in the Netherlands. Including classics like <a href="https://nederboard.nl/board/helemaalknettah" target="_blank" rel="noreferrer">Helemaal knettah</a> and <a href="https://nederboard.nl/board/rustahg" target="_blank" rel="noreferrer">Rustahg</a> plus a dozen more!',
  },
  {
    name: "iloveitshipit.com",
    url: "https://iloveitshipit.com",
    description:
      'Small and for fun soundboard of the legendary words spoken by <a href="https://www.hanselman.com" target="_blank" rel="noreferrer">Scott Hanselman</a> during a .NET conference back in the day.',
  },
] as const;
