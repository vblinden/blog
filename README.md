# vblinden.dev

Personal blog — TanStack Start on Cloudflare Workers.

## Develop

```bash
npm install
npm run dev
```

## Build / deploy

```bash
npm run build
npm run preview   # local Workers preview
npm run deploy    # build + wrangler deploy
```

## Content

Posts live in `posts/` as Markdown with YAML frontmatter (`title`, `date`, `description`, optional `draft`).

Drafts: underscore-prefixed filenames (`_wip.md`) or `draft: true`. Future-dated posts stay hidden until their date.

## Env

Optional:

```bash
VITE_SITE_URL=https://vblinden.dev
```
