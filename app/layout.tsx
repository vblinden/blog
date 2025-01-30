import Link from '@/components/Link';
import type { Metadata } from 'next';
import { Roboto } from 'next/font/google';
import './globals.css';

const robotoSans = Roboto({
  weight: ['400', '700'],
  style: ['normal'],
  subsets: ['latin'],
});

const description =
  'Hey friends, my name is Vincent van der Linden and you can find me online as @vblinden. I am currently working at team.blue as a software engineer. On this website you can find some things that I thought were important or useful enough to put online. Please enjoy.';

export const metadata: Metadata = {
  title: 'vblinden',
  description: description,
  icons: {
    icon: 'data:image/x-icon;',
  },
  keywords: '',
  openGraph: {
    type: 'website',
    url: 'https://vblinden.dev',
    title: 'vblinden',
    description: description,
    siteName: 'vblinden',
    images: [
      {
        url: 'https://example.com/og.png',
      },
    ],
  },
};

export default function RootLayout({
  children,
}: Readonly<{
  children: React.ReactNode;
}>) {
  return (
    <html lang="en">
      <body className={`${robotoSans.className} dark:bg-zinc-900 dark:text-zinc-400 bg-gray-50 text-lg antialiased`}>
        <div className="container mx-auto mb-8">
          <div className="mx-3">
            <div className="my-8">
              <h1 className="text-3xl font-bold mb-3 font-sans">
                <Link
                  href="/"
                  className="hover:text-blue-600 dark:text-white dark:hover:text-slate-100 text-4xl font-display"
                >
                  vblinden.
                </Link>
              </h1>
            </div>

            {children}
          </div>
        </div>
      </body>
    </html>
  );
}
