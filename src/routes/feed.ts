import { createFileRoute } from "@tanstack/react-router";
import { atomResponse, getAtomFeed } from "@/lib/feed";

export const Route = createFileRoute("/feed")({
  server: {
    handlers: {
      GET: async () => atomResponse(await getAtomFeed()),
    },
  },
});
