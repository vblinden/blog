import NextLink from "next/link";

const Link = ({ href, children, className = "", target, ...props }) => {
  return (
    <NextLink
      href={href}
      className={`text-blue-500 hover:text-blue-700 dark:hover:text-blue-300 underline ${
        className || ""
      }`}
      target={target || "_self"}
      {...props}
    >
      {children}
    </NextLink>
  );
};

export default Link;
