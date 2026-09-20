import { GET as feedGet } from "../feed/route";

export const dynamic = "force-static";
export const revalidate = 300;

export const GET = feedGet;
