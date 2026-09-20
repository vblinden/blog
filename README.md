# vblinden.dev

Personal blog — Next.js port of the previous Laravel site.

## Develop

```bash
npm install
npm run dev
```

## Content

Posts live in `posts/` as Markdown with YAML frontmatter (`title`, `date`, `description`, optional `draft`).

Drafts: underscore-prefixed filenames (`_wip.md`) or `draft: true`. Future-dated posts stay hidden until their date.

## Env

Optional:

```bash
NEXT_PUBLIC_SITE_URL=https://vblinden.dev
```
