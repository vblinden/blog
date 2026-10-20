import { createServerFn } from "@tanstack/react-start";
import { absoluteUrl } from "./site";
import type { Post, PostMeta } from "./post-types";
import {
  loadAllPosts,
  loadAllPostsWithContent,
  loadPostWithAdjacent,
} from "./posts.server";

export type { Post, PostMeta };

export const getAllPosts = createServerFn({ method: "GET" }).handler(
  async () => loadAllPosts(),
);

export const getAllPostsWithContent = createServerFn({ method: "GET" }).handler(
  async () => loadAllPostsWithContent(),
);

export const getPostWithAdjacent = createServerFn({ method: "GET" })
  .validator((data: { slug: string }) => data)
  .handler(async ({ data }) => loadPostWithAdjacent(data.slug));

export function postUrl(slug: string): string {
  return absoluteUrl(`/posts/${slug}`);
}

export function wordCount(htmlOrMarkdown: string): number {
  let normalized = htmlOrMarkdown.replace(/```[\s\S]*?```/g, " ");
  normalized = normalized.replace(/`([^`]+)`/g, "$1");
  normalized = normalized.replace(/!\[[^\]]*]\([^)]*\)/g, " ");
  normalized = normalized.replace(/\[([^\]]+)]\([^)]*\)/g, "$1");
  normalized = normalized.replace(/<[^>]+>/g, " ");
  normalized = normalized.replace(/[*_#>\-]/g, " ");
  return normalized.replace(/\s+/g, " ").trim().split(/\s+/).filter(Boolean)
    .length;
}
