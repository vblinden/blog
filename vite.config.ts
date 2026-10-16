import { defineConfig } from "vite";
import { tanstackStart } from "@tanstack/react-start/plugin/vite";
import { cloudflare } from "@cloudflare/vite-plugin";
import viteReact from "@vitejs/plugin-react";
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
  server: {
    port: 3000,
  },
  resolve: {
    tsconfigPaths: true,
  },
  plugins: [
    cloudflare({ viteEnvironment: { name: "ssr" } }),
    tailwindcss(),
    tanstackStart({
      prerender: {
        enabled: true,
        // Keep Atom feeds on the server so Content-Type headers are set correctly.
        filter: ({ path }) =>
          path !== "/feed" &&
          path !== "/feed/" &&
          !path.startsWith("/feed."),
      },
    }),
    viteReact(),
  ],
});
