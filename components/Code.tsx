import { codeToHtml } from 'shiki';

export default async function Code({
  lang,
  className,
  code,
}: Readonly<{
  lang: string;
  className?: string;
  code: string;
}>) {
  const out = await codeToHtml(code, {
    lang: lang,
    theme: 'tokyo-night',
    mergeWhitespaces: 'never',
  });

  return <div className={className} dangerouslySetInnerHTML={{ __html: out }} />;
}
