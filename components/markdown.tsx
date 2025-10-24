"use client";

import ReactMarkdown from "react-markdown";
import remarkGfm from "remark-gfm";
import rehypeHighlight from "rehype-highlight";
import rehypeRaw from "rehype-raw";
import type { Components } from "react-markdown";
import Link from "./link";

interface MarkdownProps {
  content: string;
}

const extendedComponents = {
  a: (props) => {
    return (
      <Link href={props.href} target={props.target}>
        {props.children}
      </Link>
    );
  },
} as Components;

export default function Markdown({ content }: MarkdownProps) {
  return (
    <ReactMarkdown
      remarkPlugins={[remarkGfm]}
      rehypePlugins={[rehypeRaw, rehypeHighlight]}
      components={extendedComponents}
    >
      {content}
    </ReactMarkdown>
  );
}
