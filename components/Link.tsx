import classNames from 'classnames';
import NextLink from 'next/link';

export default function Link({
  href,
  target,
  className,
  space,
  dot,
  children,
}: Readonly<{
  href: string;
  target?: string;
  className?: string;
  space?: boolean;
  dot?: boolean;
  children: React.ReactNode;
}>) {
  return (
    <>
      {space && ' '}
      <NextLink
        href={href}
        target={target}
        className={classNames('text-blue-600 hover:text-blue-600 dark:text-white dark:hover:text-slate-100', className)}
      >
        {children}
      </NextLink>
      {space && !dot && ' '}
    </>
  );
}
