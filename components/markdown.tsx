import type { ComponentPropsWithoutRef } from "react";
import ReactMarkdown from "react-markdown";
import rehypeHighlight from "rehype-highlight";
import rehypeRaw from "rehype-raw";
import remarkGfm from "remark-gfm";

import Link from "./link";

interface MarkdownProps {
  content: string;
}

export default function Markdown({ content }: MarkdownProps) {
  return (
    <ReactMarkdown
      remarkPlugins={[remarkGfm]}
      rehypePlugins={[rehypeRaw, rehypeHighlight]}
      components={{
        a: ({ href, children, ...props }: ComponentPropsWithoutRef<"a">) => (
          <Link href={href ?? "#"} {...props}>
            {children}
          </Link>
        ),
      }}
    >
      {content}
    </ReactMarkdown>
  );
}
