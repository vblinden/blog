---
title: Undesign it
date: July 11, 2026
---

Most teams get good at adding things. New features. New abstractions. New process. New dashboards. New settings for the settings that already exist.

Very few teams get good at taking things away.

I keep coming back to a question Elon Musk asks in SpaceX design meetings: what did you undesign? Not what did you ship. Not what did you invent. What did you remove.

That question is uncomfortable on purpose. Adding feels like progress. Deleting feels like loss. In software, we celebrate the pull request that introduces something. We rarely celebrate the one that makes the system smaller.

But smaller is often better.

The unused feature still costs you. Somebody has to understand it. Somebody has to test around it. Somebody has to explain why it exists when a new hire stumbles into it. The abstraction you added "just in case" still sits in the call stack. The weekly meeting that stopped being useful still burns an hour. Complexity does not politely leave when you stop caring about it. It stays until someone deletes it.

I have seen products where half the settings page existed for decisions nobody remembered making. Feature flags that outlived the experiment. Background jobs nobody was sure were still needed, so nobody dared turn them off. Internal tools with three ways to do the same thing because nobody wanted the political fight of picking one.

The pattern is always the same. Something gets added for a real reason. The reason fades. The thing remains.

Undesigning is the work of noticing that gap and closing it.

This is not the same as refusing to build. Sometimes you need the feature. Sometimes the abstraction earns its keep. Sometimes the process exists because the last outage was painful enough. Undesigning is not purity. It is judgment. You look at the system and ask whether each part is still carrying its weight.

A useful test: if this disappeared tomorrow, would anyone notice in a good way, a bad way, or not at all?

- If people would celebrate, delete it.
- If people would break, keep it, or redesign it carefully.
- If nobody would notice, that is the most interesting answer. It was already dead. You are just making the codebase honest.

Side projects make this easier to practice. When it is your product, your time, and your maintenance burden, you feel the cost of every extra thing immediately. You delete the half-finished settings screen. You drop the second queue. You stop supporting the weird edge case that only existed because you imagined a user who never showed up. That muscle matters at work too.

The hard part is cultural. Deleting can look like undoing someone's work. It can look like admitting a bet failed. Managers sometimes prefer a roadmap full of additions because removal does not demo well. So teams keep accumulating surface area until everything is a little slower, a little harder to explain, and a little more fragile.

If you lead engineers, ask the undesign question on purpose. In planning. In design reviews. In retros. Make removal a first-class outcome. A week where the product got simpler is a successful week.

If you write the code, leave a trail of deletions. Remove the dead path. Collapse the two similar helpers into one. Kill the option nobody uses. Trust that future you would rather maintain less.

The best part is often no part.

So before you add the next thing, ask the other question first: what can we undesign?
