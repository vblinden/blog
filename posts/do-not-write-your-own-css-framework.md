---
title: Do not write your own CSS framework
date: May 15, 2025
---

In the past it was quite easy to see which websites used the popular Bootstrap framework for styling their website. The websites all kinda looked the same, especially if they didn't spend much time customizing the framework. The website usually had the distinct blue primary color navbar, buttons and it used the jumbotron and grid layouts components in a recognizable way. 

Too many times I have seen companies wanted to differentiate theirselves from that particulair "Bootstrap" look. Not by customizing the Bootstrap framework (or any other framework for that matter), but by writing their own CSS framework from scratch. Which is almost always a very bad idea. 

It usually goes something like this: someone, or a small team, gets tasked with building the company CSS framework. For a while, it's genuinely great, slick components get built, and there's a sense of accomplishment. Then, inevitably, the framework is declared "feature complete", or the original architect moves on to the next project or leaves the company.

Maybe the framework even gets rolled out across several projects. Everybody is happy. But then comes the inevitable redesign, the "brand refresh" project. Suddenly, that framework nobody's actively maintaining becomes an anchor. One poor soul gets tasked with ramming in the new styles, doing just enough to make it work, and calls it a day. Fast forward a few years of these band-aid updates, and you've got a monster on your hands. 

Nobody dares touch a component for fear of breaking three other things. Fixing a simple display bug becomes an archaeological dig. Changing a color feels like defusing a bomb. And good luck to any new developer joining the team. Get ready for a painful onboarding. Documentation? Either non-existent or so outdated it's actively misleading. Need to tweak the ancient Gulp config to get things running or make a change? Prepare for a special kind of hell.

At this point, everyone's just muttering under their breath: "We should have just used an existing framework".

If you have at least one developer who can dedicate a significant, consistent portion of their time, practically becoming a full-time framework maintainer, it might not immediately implode. But can that one person truly keep up with the demands of a larger development team that constantly needs new features and rapid iteration? If that "dedicated" time is just "half a day on fridays, if there are no urgent issues", while twenty other developers are blocked or hacking around limitations, it's not a feasible model. It's a bottleneck in the making. 

Instead of building your own, you should use and existing CSS framework. For example just use Tailwind CSS. They provide sane defaults, they provide updates, they provide documentation, they provide fixes, new hires can Google questions, ask AI or draw on previous experience because, chances are, they've used it (and loved it) at previous companies. There is a reason Tailwind CSS took the CSS world by storm since its conception and is the most used CSS framework since 2020 according to <x-link href="https://stateofcss.com" target="_blank">stateofcss.com</x-link>.

It is very easy to customize Tailwind CSS with for example <x-link href="https://tailwindcss.com/docs/theme" target="_blank">themes</x-link>. Want different colors for theme? Different radius? Different text sizes? You can just use <x-link href="https://developer.mozilla.org/en-US/docs/Web/CSS/CSS_cascading_variables/Using_CSS_custom_properties" target="_blank">CSS custom properties</x-link> and just import the theme in your company CSS and be done with it.

```css
@import "tailwindcss";
@import "../brand/theme.css";
```

Almost all web development today is component-based. Lit, React, Vue, Svelte, Blazor and even server side view frameworks support components, like for example Twig and Laravel Blade. Worried about forgetting that one class at that one place for a button? With Tailwind, your styles live within your component. Define your `<Button type="submit">` once, and reuse that component. The styling is encapsulated, predictable, and easy to manage. This drastically reduces the fear of unintended side effects that plagues global CSS.

No more inventing abstract class names for every minor variation. Need a bit more padding? `p-6`. Different text color on hover? `hover:text-red-500`. It's direct, intuitive, and keeps you in your HTML or component file.

**But it makes the HTML messy/verbose!**
In a component-based world, those utilities are encapsulated within your component definition. You interact with `<Button variant="primary">`, not necessarily a long string of classes in your page-level code. Plus, well-formatted utility classes are often more scannable and self-documenting than arbitrary names like `.product-card-header-subtitle-final-v2`.

**But it is not semantic!**
HTML tags (`<article>`, `<nav>`, `<aside>`) provide document structure and semantics. Aria attributes enhance accessibility. CSS class names are primarily for styling hooks. `class="font-bold text-lg"` is perfectly clear about the styling intent. Chasing "semantic" class names like `.important-user-message`for styling often leads to a convoluted mess when styling needs change but the meaning doesn't.

**But it bloats your CSS file size!**
This is a common misconception, usually based on outdated information. Tailwind CSS uses a Just-In-Time (JIT) compiler by default. This scans your template files and generates only the CSS classes you actually use. Which results in production builds that are incredibly small and highly optimized, often significantly smaller than traditional CSS framework bundles or custom stylesheets that accumulate years of unused classes.

So, the next time someone on your team suggests, "Let's just build our own CSS framework, it'll be cleaner/faster/better for us", pause and reflect on the choice you are about to make. The road to a custom CSS framework is paved with good intentions but often leads to a road to hell of maintenance headaches, developer frustration, and project slowdowns. Instead of reinventing the wheel and burdening yourself with years of thankless infrastructure work, embrace the power and pragmatism of a mature solution like Tailwind CSS (or others). Focus your energy on building unique features and exceptional user experiences, not on wrestling with another soon-to-be-legacy internal framework. Your team's productivity, your project's velocity, and your own sanity will thank you for it.

