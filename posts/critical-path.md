---
title: The Critical Path
date: July 14, 2026
description: What SpaceX's Starship documentary teaches about the critical path, and how to apply it to software development.
---

I watched SpaceX's new Starship documentary, [Critical Path](https://www.youtube.com/watch?v=-a0ecQMq-rM). It follows the final days before Flight 12. Rockets, countdowns, things breaking at the worst possible moment. The usual SpaceX chaos.

But the video is not really about rockets. It is about a simple idea that I think applies just as well to shipping software.

## What is the critical path?

Early in the film, an engineer explains it like this:

> The critical path is the longest set of sequential events that are gated by each other that must be completed in order for a task to happen.

SpaceX makes that very real. A static fire that does not run full duration? Launch moves. A chopstick roller snaps the day after the test? Thirty-six hours of scrambling to hot-shot a replacement chain from Florida. A QD arm that jiggles during unpin at T-minus 40 seconds? Scrub for the day, weld a hard stop overnight, try again tomorrow.

None of that is glamorous. All of it is on the path to launch.

## Stage zero

One of the best lines in the video is about the launch pad:

> The integration mechanism is the pad. The catch mechanism is the pad. [...] The reason we call it stage zero is literally it is the first stage of the launch process. And if it is not working, we cannot go launch.

Every software team has a stage zero. It is rarely the feature demo. It is the deployment pipeline that actually promotes to production. The auth layer. The migration that has to run cleanly. The API contract the mobile app already shipped against.

These things are boring until they are not. Then they own your calendar.

I have seen teams treat stage zero as background work while they polish something with float. Work that has slack. It can slip without moving the date. A refactor nobody asked for. A fourth dashboard variant. A clever abstraction for a use case that does not exist yet. Meanwhile the thing that actually gates release sits blocked.

## Paranoia in the right places

Flight 12 is a good lesson in misplaced confidence. The team went into launch worried about fuel drain vent holds. Those passed. They got bit by QD arm dynamics nobody had seen under flight-like conditions.

> You got to be paranoid about everything.

That sounds exhausting. But in software, paranoia belongs on the critical path, not everywhere. You cannot treat every line of code like a rocket engine. You can treat the chain that gates release like one.

For a typical product launch, that might mean:

- The one integration that has never run end-to-end in production-like conditions
- The migration on a table you have never copied at real scale
- The rollback path you have never exercised
- The background job that only ever ran on a small dev dataset
- The rate limit or timeout behavior under actual load

Run the scary test early. In the video, the fourth static fire attempt finally gave them the data they needed. Waiting until launch day to learn the hard thing is how programs slip by weeks.

## Float is real

Not everything in the documentary is urgent. Buoys get patched. Imaging satellites get a final inspection. Families watch a booster roll down the highway. Important work, but not all of it sits on the chain that ends with ignition.

Software teams have float too. Documentation can slip. Internal tooling can wait. A nice-to-have admin screen can land next sprint.

The demo looks great in a recorded walkthrough. The critical path is whether it works on Tuesday at 14:00 when the data is messy and the user is impatient.

## "Critical path to Mars is not blowing up rockets"

That line stuck with me.

The critical path to a successful product is not heroics. It is not cutting corners on the chain that keeps users safe. It is not launching because the calendar said so when the preflight data says otherwise. It is not skipping backups, merging without tests on the code that moves money, or deploying something you cannot roll back when it fails.

SpaceX scrubs. Good teams do too. A delay on the critical path is expensive. A failure on the critical path is worse.

<iframe class="mt-4" width="560" height="315" src="https://www.youtube-nocookie.com/embed/-a0ecQMq-rM"
        title="Starship - Critical Path" frameborder="0"
        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
        referrerpolicy="strict-origin-when-cross-origin" allowfullscreen>
</iframe>

<p class="disclaimer text-left">
    Copyright belongs to SpaceX. Original video: <a href="https://www.youtube.com/watch?v=-a0ecQMq-rM">https://www.youtube.com/watch?v=-a0ecQMq-rM</a>
</p>
