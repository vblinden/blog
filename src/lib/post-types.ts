export type PostMeta = {
  slug: string;
  title: string;
  date: string;
  description: string;
  readingTime: number;
  publishedAt: number;
  publishedAtIso8601: string | null;
};

export type Post = PostMeta & {
  content: string;
  html: string;
};
