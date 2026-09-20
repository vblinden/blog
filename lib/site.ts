export const site = {
  name: "vblinden",
  title: "vblinden",
  author: "Vincent van der Linden",
  authorHandle: "vblinden",
  locale: "en_US",
  description:
    "Personal blog of Vincent van der Linden (vblinden) about software engineering, side projects, deployment, Laravel, and practical lessons from building things.",
  url: process.env.NEXT_PUBLIC_SITE_URL?.replace(/\/$/, "") || "https://vblinden.dev",
  social: {
    github: "https://github.com/vblinden",
    x: "https://x.com/vblinden",
    email: "support@vblinden.dev",
  },
  projectTracking: {
    utm_source: "vblinden.dev",
    utm_medium: "referral",
    utm_campaign: "homepage",
  },
} as const;

export type Project = {
  name: string;
  url: string;
  description: string;
  status?: "active" | "sunset";
};

export const projects: Project[] = [
  {
    name: "usefizz.dev",
    url: "https://usefizz.dev",
    description:
      "Deploy Laravel, Next.js, or static apps to your own VPS with Git push deploys, automatic HTTPS, and easy rollbacks.",
  },
  {
    name: "checkeroni.com",
    url: "https://checkeroni.com",
    description:
      "Uptime monitoring with flexible check types. Instant alerts when something goes down, plus public status pages.",
  },
  {
    name: "mailsurge.dev",
    url: "https://mailsurge.dev",
    description:
      "Lean transactional email for developers. A simple API with domain verification, signed webhooks, and analytics.",
  },
  {
    name: "ohwhat.dev",
    url: "https://ohwhat.dev",
    description:
      "Quieter error tracking for developers. Fewer dashboards, clearer signals, and less noise when things break.",
  },
  {
    name: "favicons.vblinden.dev",
    url: "https://favicons.vblinden.dev",
    description:
      "Drop-in favicon URLs for any domain. Cached, easy to refresh, and built for hotlinking.",
  },
  {
    name: "pennymetrics.dev",
    url: "https://pennymetrics.dev",
    description:
      "Privacy-friendly web analytics without cookies or consent banners. The numbers that matter, nothing else.",
  },
  {
    name: "chatwithyoursite.com",
    url: "https://chatwithyoursite.com",
    description:
      "Turn your site, PDFs, and notes into a grounded chatbot and search API that answers from your own content.",
  },
  {
    name: "goutipedia.com",
    url: "https://goutipedia.com",
    description:
      "Clear guidance on gout symptoms, triggers, and treatment. Practical advice for day-to-day life with gout.",
  },
  {
    name: "staravatars.com",
    url: "https://staravatars.com",
    description:
      "Deterministic space-themed avatars from any name, email, or path. The same input always gives the same avatar.",
  },
  {
    name: "nederboard.nl",
    url: "https://nederboard.nl",
    description:
      "A Dutch meme soundboard with viral clips and internet classics. Press a button, blast a sound.",
  },
  {
    name: "iloveitshipit.com",
    url: "https://iloveitshipit.com",
    description:
      'Replay Scott Hanselman\'s "I love it, ship it" whenever a project is almost done and just needs a push.',
  },
  {
    name: "moyouai.com",
    url: "https://moyouai.com",
    description:
      "Describe a brand and generate production-ready SVG logos. Export clean vectors ready for web and print.",
    status: "sunset",
  },
  {
    name: "absurge.com",
    url: "https://absurge.com",
    description:
      "A/B testing and session replay in one tool. Run experiments and watch real sessions to see why a variant wins.",
    status: "sunset",
  },
];

export function getProjectsForHome(): Project[] {
  const tracking = new URLSearchParams(site.projectTracking).toString();

  return [...projects]
    .map((project) => {
      if ((project.status ?? "active") === "sunset") {
        return project;
      }

      const separator = project.url.includes("?") ? "&" : "?";
      return { ...project, url: `${project.url}${separator}${tracking}` };
    })
    .sort((a, b) => {
      const aSunset = (a.status ?? "active") === "sunset" ? 1 : 0;
      const bSunset = (b.status ?? "active") === "sunset" ? 1 : 0;
      return aSunset - bSunset;
    });
}

export function absoluteUrl(path = "/"): string {
  const normalized = path.startsWith("/") ? path : `/${path}`;
  return `${site.url}${normalized === "/" ? "" : normalized}`;
}
