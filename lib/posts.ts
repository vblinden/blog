import fs from "node:fs";
import path from "node:path";

import matter from "gray-matter";

const postsDirectory = path.join(process.cwd(), "posts");

export interface PostSummary {
  slug: string;
  title: string;
  date: string;
  description: string;
  readingTime: number;
  publishedAt: number;
  publishedAtIso8601: string | null;
}

export interface PostData extends PostSummary {
  content: string;
}

function parsePostFile(fileName: string): PostData | null {
  try {
    const slug = fileName.replace(/\.md$/, "");
    const fullPath = path.join(postsDirectory, fileName);
    const fileContents = fs.readFileSync(fullPath, "utf8");
    const { data, content } = matter(fileContents);
    const normalizedContent = normalizePostContent(content);
    const title = normalizeTitle(String(data.title ?? headlineFromSlug(slug)));
    const date = String(data.date ?? "").trim();
    const publishedAt = timestampFor(date);
    const description = descriptionFor(data.description, normalizedContent);
    const readingTime = readingTimeFor(normalizedContent);

    return {
      slug,
      title,
      date,
      description,
      readingTime,
      publishedAt,
      publishedAtIso8601:
        publishedAt === 0 ? null : new Date(publishedAt).toISOString(),
      content: normalizedContent,
    };
  } catch (error) {
    console.error(`Error reading post ${fileName}:`, error);

    return null;
  }
}

function normalizePostContent(content: string) {
  return content.replace(/<x-link\b/gi, "<a").replace(/<\/x-link>/gi, "</a>");
}

function normalizeTitle(title: string) {
  return title.trim().replace(/^['"]|['"]$/g, "");
}

function headlineFromSlug(slug: string) {
  return slug
    .split("-")
    .map((part) => part.charAt(0).toUpperCase() + part.slice(1))
    .join(" ");
}

function timestampFor(date: string) {
  if (date === "") {
    return 0;
  }

  const normalizedDate = date.replaceAll("Augustus", "August");
  const timestamp = Date.parse(`${normalizedDate} UTC`);

  return Number.isNaN(timestamp) ? 0 : timestamp;
}

function descriptionFor(frontMatterDescription: unknown, content: string) {
  const description = String(frontMatterDescription ?? "").trim();

  if (description !== "") {
    return normalizeTitle(description);
  }

  return limit(stripMarkdown(content), 160);
}

function readingTimeFor(content: string) {
  const words = stripMarkdown(content)
    .split(/\s+/)
    .filter(Boolean).length;

  return Math.max(1, Math.ceil(words / 200));
}

function stripMarkdown(content: string) {
  return content
    .replace(/```[\s\S]*?```/g, " ")
    .replace(/`([^`]+)`/g, "$1")
    .replace(/!\[[^\]]*]\([^)]*\)/g, " ")
    .replace(/\[([^\]]+)]\([^)]*\)/g, "$1")
    .replace(/<[^>]+>/g, " ")
    .replace(/[*_#>-]/g, " ")
    .replace(/\s+/g, " ")
    .trim();
}

function limit(value: string, maxLength: number) {
  if (value.length <= maxLength) {
    return value;
  }

  return `${value.slice(0, maxLength - 1).trimEnd()}…`;
}

export function getAllPostSlugs() {
  return fs
    .readdirSync(postsDirectory)
    .filter((name) => name.endsWith(".md"))
    .map((name) => name.replace(/\.md$/, ""));
}

export function getAllPosts(): PostSummary[] {
  return fs
    .readdirSync(postsDirectory)
    .filter((name) => name.endsWith(".md"))
    .map((fileName) => parsePostFile(fileName))
    .filter((post): post is PostData => post !== null)
    .sort((left, right) => right.publishedAt - left.publishedAt)
    .map((post) => ({
      slug: post.slug,
      title: post.title,
      date: post.date,
      description: post.description,
      readingTime: post.readingTime,
      publishedAt: post.publishedAt,
      publishedAtIso8601: post.publishedAtIso8601,
    }));
}

export function getPostData(slug: string) {
  return parsePostFile(`${slug}.md`);
}
