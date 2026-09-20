"use client";

import { useEffect, useRef } from "react";

export function ClampedDescription({
  children,
  title,
}: {
  children: string;
  title?: string;
}) {
  const ref = useRef<HTMLParagraphElement>(null);

  useEffect(() => {
    const el = ref.current;
    if (!el) return;

    const sync = () => {
      if (el.classList.contains("is-expanded")) return;

      if (el.scrollHeight > el.clientHeight + 1) {
        if (!el.classList.contains("is-clamped")) {
          el.classList.add("is-clamped");
          el.setAttribute("tabindex", "0");
          el.setAttribute("role", "button");
          el.setAttribute("aria-expanded", "false");
        }
      } else {
        el.classList.remove("is-clamped");
        el.removeAttribute("tabindex");
        el.removeAttribute("role");
        el.removeAttribute("aria-expanded");
      }
    };

    const toggle = () => {
      const expanded = el.classList.toggle("is-expanded");
      el.setAttribute("aria-expanded", String(expanded));
    };

    const onKeyDown = (event: KeyboardEvent) => {
      if (event.key === "Enter" || event.key === " ") {
        event.preventDefault();
        toggle();
      }
    };

    sync();
    el.addEventListener("click", toggle);
    el.addEventListener("keydown", onKeyDown);
    window.addEventListener("resize", sync);

    if (document.fonts?.ready) {
      void document.fonts.ready.then(sync);
    }

    return () => {
      el.removeEventListener("click", toggle);
      el.removeEventListener("keydown", onKeyDown);
      window.removeEventListener("resize", sync);
    };
  }, [children]);

  return (
    <p className="home-item-description" title={title} ref={ref}>
      {children}
    </p>
  );
}
