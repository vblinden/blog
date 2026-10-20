import matter from "gray-matter";
import { renderMarkdown } from "./markdown";
import type { Post, PostMeta } from "./post-types";

const postFiles = import.meta.glob("../../posts/*.md", {
  eager: true,
  query: "?raw",
  import: "default",
}) as Record<string, string>;

function slugFromPath(filePath: string): string {
  const fileName = filePath.split("/").pop() ?? filePath;
  return fileName.replace(/\.md$/, "");
}

function headlineFromSlug(slug: string): string {
  return slug
    .split("-")
    .map((part) => part.charAt(0).toUpperCase() + part.slice(1))
    .join(" ");
}

function normalizeTitle(title: string): string {
  return title.trim().replace(/^['"]|['"]$/g, "");
}

function normalizePostContent(content: string): string {
  return content.replace(/<\/?x-link/gi, (match) =>
    match.toLowerCase().startsWith("</") ? "</a" : "<a",
  );
}

function isDraftFrontMatter(draft: unknown): boolean {
  if (typeof draft === "boolean") return draft;
  if (typeof draft === "string") {
    return ["1", "true", "yes", "on"].includes(draft.toLowerCase());
  }
  if (typeof draft === "number") return draft === 1;
  return false;
}

function frontMatterDate(value: unknown): string {
  if (value instanceof Date) {
    return value.toISOString().slice(0, 10);
  }

  if (typeof value === "number") {
    if (value > 1_000_000_000) {
      return new Date(value * 1000).toISOString().slice(0, 10);
    }
    return String(value);
  }

  return String(value ?? "").trim();
}

function timestampFor(date: string): number {
  if (!date) return 0;

  if (/^\d{4}-\d{2}-\d{2}(?:[ T]\d{2}:\d{2}(?::\d{2})?)?/.test(date)) {
    const timestamp = Date.parse(
      `${date.includes("T") || date.includes(" ") ? date : `${date}T00:00:00`}Z`,
    );
    return Number.isNaN(timestamp) ? 0 : Math.floor(timestamp / 1000);
  }

  const normalizedDate = date.replace("Augustus", "August");
  const timestamp = Date.parse(`${normalizedDate} UTC`);
  return Number.isNaN(timestamp) ? 0 : Math.floor(timestamp / 1000);
}

function displayDate(rawDate: string, publishedAt: number): string {
  if (!rawDate) return "";

  if (/^\d{4}-\d{2}-\d{2}$/.test(rawDate) && publishedAt > 0) {
    return new Intl.DateTimeFormat("en-US", {
      month: "long",
      day: "numeric",
      year: "numeric",
      timeZone: "UTC",
    }).format(new Date(publishedAt * 1000));
  }

  return rawDate;
}

function stripMarkdown(content: string): string {
  let normalized = content.replace(/```[\s\S]*?```/g, " ");
  normalized = normalized.replace(/`([^`]+)`/g, "$1");
  normalized = normalized.replace(/!\[[^\]]*]\([^)]*\)/g, " ");
  normalized = normalized.replace(/\[([^\]]+)]\([^)]*\)/g, "$1");
  normalized = normalized.replace(/<[^>]+>/g, " ");
  normalized = normalized.replace(/[*_#>\-]/g, " ");
  return normalized.replace(/\s+/g, " ").trim();
}

function limit(value: string, maxLength: number): string {
  if (value.length <= maxLength) return value;
  return `${value.slice(0, maxLength - 1).trimEnd()}…`;
}

function descriptionFor(
  frontMatterDescription: unknown,
  content: string,
): string {
  const description = String(frontMatterDescription ?? "").trim();
  if (description) return normalizeTitle(description);
  return limit(stripMarkdown(content), 160);
}

function readingTimeFor(content: string): number {
  const words = stripMarkdown(content).split(/\s+/).filter(Boolean);
  return Math.max(1, Math.ceil(words.length / 200));
}

function isPublished(publishedAt: number, now: number): boolean {
  if (publishedAt === 0) return true;
  return publishedAt <= now;
}

function parsePostContents(
  slug: string,
  contents: string,
  includeBody: false,
): PostMeta | null;
function parsePostContents(
  slug: string,
  contents: string,
  includeBody: true,
): Promise<Post | null>;
function parsePostContents(
  slug: string,
  contents: string,
  includeBody: boolean,
): PostMeta | null | Promise<Post | null> {
  if (slug.startsWith("_")) return includeBody ? Promise.resolve(null) : null;

  const { data, content: rawMarkdown } = matter(contents);

  if (isDraftFrontMatter(data.draft)) {
    return includeBody ? Promise.resolve(null) : null;
  }

  const normalizedContent = normalizePostContent(rawMarkdown);
  const title = normalizeTitle(String(data.title ?? headlineFromSlug(slug)));
  const rawDate = frontMatterDate(data.date);
  const publishedAt = timestampFor(rawDate);
  const date = displayDate(rawDate, publishedAt);
  const description = descriptionFor(data.description, normalizedContent);
  const readingTime = readingTimeFor(normalizedContent);

  const meta: PostMeta = {
    slug,
    title,
    date,
    description,
    readingTime,
    publishedAt,
    publishedAtIso8601:
      publishedAt === 0 ? null : new Date(publishedAt * 1000).toISOString(),
  };

  if (!includeBody) {
    return meta;
  }

  return renderMarkdown(normalizedContent).then((html) => ({
    ...meta,
    content: normalizedContent,
    html,
  }));
}

function getRawPost(slug: string): string | null {
  const entry = Object.entries(postFiles).find(
    ([path]) => slugFromPath(path) === slug,
  );
  return entry?.[1] ?? null;
}

async function getIndex(): Promise<PostMeta[]> {
  const now = Math.floor(Date.now() / 1000);

  return Object.entries(postFiles)
    .map(([path, contents]) =>
      parsePostContents(slugFromPath(path), contents, false),
    )
    .filter((post): post is PostMeta => post !== null)
    .filter((post) => isPublished(post.publishedAt, now))
    .sort((a, b) => b.publishedAt - a.publishedAt);
}

export async function loadAllPosts(): Promise<PostMeta[]> {
  return getIndex();
}

export async function loadAllPostsWithContent(): Promise<Post[]> {
  const posts = await getIndex();
  const withContent = await Promise.all(
    posts.map(async (post) => {
      const raw = getRawPost(post.slug);
      if (!raw) return null;
      return parsePostContents(post.slug, raw, true);
    }),
  );

  return withContent.filter((post): post is Post => post !== null);
}

export async function loadPostWithAdjacent(slug: string): Promise<{
  post: Post | null;
  newer: PostMeta | null;
  older: PostMeta | null;
}> {
  const posts = await getIndex();
  const index = posts.findIndex((post) => post.slug === slug);

  if (index === -1) {
    return { post: null, newer: null, older: null };
  }

  const raw = getRawPost(slug);
  const post = raw ? await parsePostContents(slug, raw, true) : null;

  return {
    post,
    newer: index > 0 ? posts[index - 1] : null,
    older: posts[index + 1] ?? null,
  };
}
