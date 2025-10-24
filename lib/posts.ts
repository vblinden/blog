import fs from "fs";
import path from "path";
import matter from "gray-matter";

const postsDirectory = path.join(process.cwd(), "posts");

export interface PostData {
  slug: string;
  title: string;
  date: string;
  content: string;
}

export interface PostMeta {
  slug: string;
  title: string;
  date: string;
}

export function getAllPostSlugs(): string[] {
  const fileNames = fs.readdirSync(postsDirectory);

  return fileNames
    .filter((name) => name.endsWith(".md"))
    .map((name) => name.replace(/\.md$/, ""));
}

export function getAllPosts(): PostMeta[] {
  const slugs = getAllPostSlugs();
  const posts = slugs
    .map((slug) => {
      const fullPath = path.join(postsDirectory, `${slug}.md`);
      const fileContents = fs.readFileSync(fullPath, "utf8");
      const { data } = matter(fileContents);

      return {
        slug,
        title: data.title || slug.replace(/-/g, " "),
        date: data.date || "",
      };
    })
    .sort((a, b) => new Date(b.date).getTime() - new Date(a.date).getTime());

  return posts;
}

export function getPostData(slug: string): PostData | null {
  try {
    const fullPath = path.join(postsDirectory, `${slug}.md`);
    const fileContents = fs.readFileSync(fullPath, "utf8");
    const { data, content } = matter(fileContents);

    return {
      slug,
      title: data.title || slug.replace(/-/g, " "),
      date: data.date || "",
      content: content,
    };
  } catch (error) {
    console.error(`Error reading post ${slug}:`, error);

    return null;
  }
}
