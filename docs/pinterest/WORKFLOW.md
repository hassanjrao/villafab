# Villa Fabulosa Pinterest workflow

Last updated: 2026-11-08. Dates in this campaign use Asia/Karachi unless a platform timestamp explicitly identifies another timezone.

Use this guide for future work. Use [POSTING-LOG.md](POSTING-LOG.md) for what actually happened, the [published Pin records](samples/), the [prepared queue](prepared/README.md), and the Google Sheet linked from [tracker-sheet.md](tracker-sheet.md) for the working register. A private [Google Doc combines the rules and posting log](https://docs.google.com/document/d/1B-CN1gnRRRtuwjpHpgpw_hlzG7vL3c6LucCg4sGoaUU). Local asset review establishes preparation; publication and saved platform fields require separate live verification.

## 1. Scope and authorization

- The owner selected **75 total campaign Pins**, using all **15 green keywords × 5 target locations**. This replaces the conflicting 60-Pin totals in the original brief.
- The original sample was reviewed and approved before publication. Pins 001–004 were published and their description hashtags verified by 2026-10-19. Pins 005–007 were published and reload-verified on 2026-10-20. On 2026-10-25, the owner authorized **four more Pins**, IDs 008–011; all four are published and reload-verified, for **eleven public Pins total**.
- On 2026-10-26, the owner authorized creating **all 64 remaining Pins, 012–075**, in individual local folders, with posting later. All were prepared and visually reviewed locally; that preparation instruction alone authorized no Pinterest upload, publication or scheduling.
- On 2026-10-27, the owner first authorized publishing 012–013, which completed that two-Pin batch. The owner then said **“do it”** to the full setup/scheduling plan: claim the domain, create the five public boards, redistribute existing campaign Pins and schedule the remaining 62 at three per day. Continue that authorized work as native queue capacity opens; a new approval is not needed for each remaining planned Pin. Do not publish the backlog immediately. The next unused creative ID remains **076**, outside this 75-Pin campaign.
- When the owner explicitly asks to publish a batch, finish that authorized batch without asking again for the same permission. Ask only when necessary information or access prevents a concrete action, or when a proposed action exceeds the requested scope.
- Preserve each public Pin's URL when correcting its copy. Edit the existing Pin instead of making a duplicate.
- Do not include passwords, login codes, cookies, authentication tokens, or other credentials in documentation, prompts, screenshots, spreadsheet cells, or source control.

## 2. Confirm account, inputs and current access

Before preparing or publishing a batch:

1. Read the latest owner messages, this guide, the posting log, the Sheet and existing Pin records. Resolve IDs and existing URLs before creating anything.
2. For publication or platform edits, verify that the active Pinterest profile is Villa Fabulosa and that the selected board belongs to that profile. Local preparation and review do not require a Pinterest browser or sign-in. The Chrome profile used for sign-in is separate from the Pinterest account identity.
3. Use the approved keyword spreadsheet as the keyword source: [original keyword sheet](https://docs.google.com/spreadsheets/d/1aNHMxeokyUFZGjOtK_Lg17W-U17oKpwzr7LLXfcSvcs/edit). The exact 15 green keyword cells and original headline bank were checked on 2026-10-20 and recorded in [CAMPAIGN-REFERENCE.md](CAMPAIGN-REFERENCE.md). The four selected keyword cells for 008–011 were rechecked on 2026-10-25. Check the existing keyword/ID mapping before selecting the next theme.
4. Inspect the actual property source photos and check the proposed amenities and booking claims against the property information.
5. When publishing or editing live Pins, confirm which browser or connected publishing tool is actually available. Initial publication used the owner's authenticated Chrome profile with temporary Windows UI automation. When that shared Chrome session moved to another task, a separate ephemeral Playwright Chrome session was opened and the owner manually signed in. Final edits and reload checks used that authenticated isolated session. No connected Pinterest or Metricool integration was used.

Use the isolated session for subsequent platform work when it is authenticated. If it is not signed in, let the user complete a one-time manual sign-in there. Never copy their Chrome profile, passwords, or session cookies to obtain access. Do not claim that a dedicated browser is logged in until that session is visibly authenticated. Do not automate unrelated browser tabs or take over a tab the user has moved to another task; re-establish a dedicated Pinterest target first.

The 2026-10-25 batch used a dedicated persistent Playwright profile stored outside the repository, authenticated by the owner's manual sign-in. No existing Chrome profile or cookies were copied. Keep browser authentication state outside source control and recheck the account identity each session.

Villa Fabulosa's **Business account** and **villafabulosa.com claim** were verified on 2026-10-27. The live canonical and www page checks each exposed exactly one matching verification meta tag; Pinterest showed the domain connected and an Unclaim control after a fresh settings navigation. See [domain-claim-setup-2026-10-27.md](domain-claim-setup-2026-10-27.md). Recheck the account identity before future platform work.

## 3. Campaign plan and location accuracy

The full 75-Pin asset set exists: **35 published, 10 scheduled and 30 prepared for later scheduling** (checkpoint 2026-11-08). The [matrix](prepared/matrix.json) covers all 15 approved keywords across five locations exactly once, and 15 actual source-photo families with five creative variants each. The original eleven assets anchored their source families' first variants. The five treatments are classic editorial, photo-forward, framed, asymmetric editorial and magazine editorial. No generated lifestyle people were added.

| Target location | Required wording rule |
| --- | --- |
| Temecula Wine Country | The property may be described as being in Temecula Wine Country. |
| Riverside County | The property may be described as being in Temecula, Riverside County. |
| Southern California | The property may be described as being in Southern California. |
| Los Angeles | Address travelers **from Los Angeles**; do not imply the estate is located in Los Angeles. |
| Orange County | Address travelers **from Orange County**; do not imply the estate is located in Orange County. |

The first batches originally used Top Vacation Rental in Temecula Wine Country. On 2026-10-27 the following five exact public boards were created and verified, and all 13 published campaign Pins were moved to their assigned boards with public URLs preserved:

1. Villa Fabulosa | Luxury Estate & Resort Amenities
2. Temecula Wine Country Vacation Rental
3. Group Vacation Home & Family Reunion Ideas
4. Resort-Style Pool & Outdoor Living
5. Corporate Retreats & Private Getaways

The complete 75-Pin allocation is **15 per board**, grouping three actual source-photo families with five variants each. Use the exact board URL, current state and mapping in [board-schedule-plan-2026-10-27.json](board-schedule-plan-2026-10-27.json). Older unrelated boards and non-campaign Pins were preserved.

## 4. Images and text on the graphic

- Use actual Villa Fabulosa property photos from `public/frontend/imgs/photos-for-vrbo/`. Record the precise source path for every Pin.
- Continue the approved warm ivory, navy and gold editorial design, with readable serif headlines, generous margins and a clear `Explore VillaFabulosa.com` call to action.
- Inspect every source photo and the approved style reference before generation. Use the built-in image generation tool for the generated designs, then inspect the final saved image. Preserve the full prompt and source/style-reference paths in the Pin's Markdown record.
- Ask the generation tool to preserve architecture, pool shape, furniture, scenery and amenities. Compare its output with the original: instructions alone do not prove photographic fidelity. Record visible differences honestly. Do not advertise invented property features.
- The campaign format is vertical **2:3**. The brief requests **1000 × 1500**; all published and prepared campaign assets, 001–075, are actually **1024 × 1536**. Record actual dimensions and do not silently claim an exact export size that was not produced.
- The full campaign's published and prepared creatives contain **no AI-generated people**. The original brief's lifestyle-people concept was not used in the five-treatment production mix.
- Avoid unsupported superiority, savings, fee or rate guarantees, including `#1`, `Best Rates Guaranteed`, or `Skip Platform Fees`, unless current evidence supports the exact claim. Do not imply that a reunion or retreat use automatically permits events.

Rotate the original headline bank in order, avoiding consecutive repeats. With 75 Pins, a 20-headline bank would be used about three or four times per headline. The first four used are:

1. The Ultimate Group Getaway in Temecula
2. Spacious Luxury Estate for Large Groups
3. Perfect Venue for Family Reunions & Retreats
4. Private Estate Designed for Multi-Family Stays

Original headline 5, `#1 Vacation Rental in California`, was skipped in the first published batches because its ranking is unsupported. Pins 005–007 used headlines 6–8; 008–011 used 9–12, adapting 10 to **Luxury Bedrooms & High-End Amenities** because plural master suites are unconfirmed. Pin 009's posted image is `pin-009-v2.png`; its original remains unposted. Published Pin 012 uses adapted entry 13, **Private Estate in Temecula Wine Country**, without a travel-time claim; 013 uses entry 14, **Scenic Views & Private Estate Luxury**. Remaining assignments and factual replacements are recorded in [CAMPAIGN-REFERENCE.md](CAMPAIGN-REFERENCE.md) and each Pin's metadata. Check claims against the actual photo and property information; use the sample as a style reference without borrowing its scene.

### Local preparation and owner review

Each folder `prepared/pin-012/` through `prepared/pin-075/` contains its `pin-NNN.png`, `posting.md`, `metadata.json`, `prompt.txt` and `review.json`. Posting copy includes the title, complete description with three hashtags, alt text, recommended existing board and unique destination/UTM. The full prompt and exact source/style paths accompany every asset. The original built-in generated PNG is saved without code image edits.

Use the [visual index](prepared/index.html) to review the designs, [README](prepared/README.md) for navigation, [queue CSV](prepared/queue.csv) for copy, and [manifest](prepared/manifest.json), [matrix](prepared/matrix.json) and [validation report](prepared/validation.json) for local checks. Visual reviews record legibility and source fidelity, including visible generative differences. Local validation checks file completeness, dimensions, unique IDs/UTMs and campaign coverage; it does not establish saved Pinterest state.

The folders 012–075 remain the original asset archive: 24 are published (012–014, 064, 051, 043, 069, 066, 068, 036, 049, 034, 052, 038 and 057, 039, 075, 045, 041, 030, 048, 070, 059, 053), ten records are scheduled and 30 remain prepared. Scheduled records keep public URL, posted date, public badge and metrics blank, with `live_verified: false`; actual schedule IDs, owner-only previews, saved times and verification scope are recorded separately. Planned dates are never evidence of a saved schedule. Original prompt/review records and all PNGs remain unchanged.

## 5. Title, description, hashtags, topics and alt text

Prepare the full copy before opening the publishing form:

| Field | Campaign rule |
| --- | --- |
| Title | Up to 100 characters; use the selected keyword and a truthful location phrase, followed by `\| Villa Fabulosa` when it fits. |
| Description | Target 100–500 characters, including hashtags. Write natural sentences tied to the actual photo, useful amenities and reason to visit; end with a clear availability/direct-website invitation. |
| Hashtags | The owner requested tags. Add three focused hashtags in the description, mixing destination and the specific travel/amenity theme. Record the exact hashtags; do not promise ranking or booking improvements. |
| Related topic tags | Use Pinterest's native related-topic selector when it is offered, choosing only genuinely relevant options. These are separate from typed hashtags. Do not choose `Golf Equipment` or `Golf Tips` for a vacation estate's miniature golf amenity. |
| Alt text | Describe the photo and material image text for accessibility. Do not use it as a keyword or hashtag list. |
| Destination | Use the live property URL with a unique `utm_content` for this Pin. |

Pinterest permits hashtags in descriptions and provides up to 10 native related-topic tags; availability of a particular topic or editing control must be checked in the live form. [Pinterest: create a Pin](https://help.pinterest.com/en/article/create-a-pin-from-an-image-or-video)

If Edit Pin does not expose a native topic selector for an older Pin, add the authorized description hashtags and record the topic field as unavailable in that editor. Do not report that native topics were added when only the description changed.

The regular organic builder and Edit Pin exposed no native topic selector for Pins 008–011 on 2026-10-25 or 012–013 on 2026-10-27. Their three description hashtags were saved and verified; no native related topics were selected.

Tracking format:

```text
https://villafabulosa.com/?utm_source=pinterest&utm_medium=organic_social&utm_campaign=villa_fabulosa_75_pins&utm_content=pin_005
```

Increment the Pin ID once, keep the ID identical in filenames, the Sheet and `utm_content`, and never reuse a published ID for a new Pin. Check the complete destination field before saving so that a truncated display or clipboard problem does not lose tracking parameters.

## 6. AI disclosure preference and platform labels

The owner's latest instruction is to continue generated designs and leave the **manual AI disclosure toggle Off**. For ten scheduled Pins, manual AI Off, generated-person Off, Ad-only Off and exact alt text were checked before submission; the saved scheduled UI exposes none of those fields, so saved-state verification remains unavailable. For the 30 prepared Pins, Off remains a requested future setting only. Recheck saved fields when exposed after publication, and record public AI badges independently. Do not claim a generated design is a pixel-identical photograph.

Manual AI Off was verified after full reload for 001–004 on 2026-10-19, 005–007 on 2026-10-20, 008–011 on 2026-10-25, 012–013 on 2026-10-27, 014/064 on 2026-10-28 051, 043, 069, 066, 068, 036, 049, 034, 052, 038 on 2026-11-03 and 057, 039, 075, 045, 041, 030, 048, 070, 059, 053 on 2026-11-08. Public AI badges were Present for the older 13 at their recorded checks. No badge was observed for the twenty-two automatically published Pins at their checks; this does not guarantee permanent absence. Future scheduled/prepared Pins have no public badge observation.

Pinterest can apply an **AI modified** badge automatically, independently of the manual toggle, using metadata and detection systems. Manual Off therefore does not guarantee that a public badge disappears. Record the visible badge state separately; never strip provenance metadata or attempt detection evasion. Pinterest directs owners to support if they want to appeal a label. [Pinterest: Gen AI labels](https://help.pinterest.com/en/article/gen-ai-labels)

If future creative includes generated people, document that fact and review the then-current platform disclosure requirements before posting. No current Pin should be documented as containing an AI-generated person.

## 7. Publish and verify one Pin at a time

Use the regular organic **Create Pin** builder. On 2026-10-25, the legacy `/pin-creation-tool/` redirected to **Create Pin for Idea ad** at `/idea-pin-builder/`; the observed navigation's **Create Pin** option opened the regular `/pin-builder/`. Recheck the live interface rather than assuming an old URL still opens the correct flow. Keep **Ad-only Off**. For the standing campaign schedule select **Publish at a later date**. Use immediate publication only when separately requested. No ads are authorized.

Before publishing:

- [ ] Correct account, exact assigned public board, unused queue capacity, next ID in the authoritative schedule order and standing authorized scope. Next backlog ID is **056** (rebased slot 2026-11-11T20:00:00+05:00); inspect the live queue before any retry.
- [ ] Source photo and final image visually checked; spelling, margins and actual dimensions recorded.
- [ ] Title, complete description with hashtags, unique tracking destination and alt text prepared.
- [ ] Relevant native topics added where available; no unrelated tags chosen.
- [ ] Manual AI toggle checked against the owner's latest instruction; generated-person setting reflects the actual image.
- [ ] Regular organic Pin flow confirmed, Ad-only Off, and immediate publication selected when requested.

Publish only one Pin at a time. Capture the resulting public URL before starting the next upload. If publication returns an uncertain result, inspect the Created tab and existing Pin before retrying; a timeout is not evidence that publication failed.

After publication or any edit:

1. Open the individual public Pin URL and fully reload the page.
2. Open Edit Pin and read back the exact saved title, entire description including hashtags, destination URL and alt text where the interface exposes it.
3. Confirm the board, manual AI setting and Ad-only Off; separately inspect the public AI badge after reload. Record alt-text verification only when the saved editor exposes the exact field.
4. Confirm that the live image and public URL correspond to the correct ID and asset.
5. Save the verified details and verification date in the Sheet, the Pin Markdown record and the batch/log record. Do not mark an uninspected field verified.

**Known saving issue:** the first Pin initially published with a blank description. An automation `ValuePattern` change on Pinterest's editable description area did not reliably persist. Use actual native text input, move focus away to trigger the field's change/blur handling, save, fully reload, and read back the saved text. A populated form or successful Save click alone is insufficient evidence.

In the isolated browser, Playwright `.fill()` also appended duplicate description text during one Pin 001 edit attempt. Readback caught it **before saving**. Focus the field, use native `Ctrl+A`, type the exact complete caption, blur, and compare its full value before Save; then reload and compare again. Do not trust `.fill()` alone on Pinterest's editable description control.

During Pin 005 preparation on 2026-10-20, filling the Link field after typing the description truncated the description. The exact pre-publication readback caught the problem. Set **Title and Link first, then type Description last**, blur, and compare the entire caption before publishing. Keep the full reload/readback check after publication as well; changing field order reduces this observed failure but is not proof that a later form saved correctly.

## 8. Tracking and performance review

Keep one Sheet row per public Pin and preserve unpublished preparation records separately from the live register, with at least:

- Pin ID and public URL; title; complete description; hashtags; native topics; board.
- Source photo; final image path; actual dimensions; headline; keyword and target-location theme.
- Destination/UTM URL; actual posted date; timezone; publication status; last verified date.
- Alt text; manual AI toggle; public AI badge state; source/generation method; review notes.
- Impressions, saves, outbound clicks, website sessions, inquiries and bookings when measured, with the measurement date/window and source.

Keep the Description column aligned with the last known saved caption. Store requested-but-unsaved copy or hashtags separately with a pending status. In particular, do not replace a saved caption in the tracker with a prepared edit until Pinterest save/reload verification succeeds. The batch JSON can contain prepared target copy, so read its verification and update-status fields before treating that copy as live.

Leave unmeasured metrics blank. Use `Not verified`, `Unavailable in edit form`, or a precise observed status rather than inventing values or treating blanks as zero. Recheck the Sheet after writing it; a local CSV alone does not fulfill a request for a Google Sheet.

**Cloud tracker synced in place on 2026-11-08** (same files, same links; see [setup-cloud-sync-2026-11-08.json](setup-cloud-sync-2026-11-08.json)): the `Prepared Queue` retains the original 64 asset records: 24 Published, ten Scheduled and 30 Prepared. Scheduled/prepared public links, posting dates, saved manual AI and public badges remain blank. The `Schedule` tab separates the original 62 planned slots from 32 historical saved schedules (22 now Published and ten future Scheduled); columns D:E hold the current rebased planned instants and the added AA:AB keep the pre-rebase originals. It records owner-only previews separately from actual public URLs. `Boards` holds exact URLs, descriptions, public verification and current counts. `Pins` and `Performance` hold 35 public records. Performance measurements stay blank. After each later checkpoint, update these tabs in place, read them back and record a new dated cloud receipt.

Update [POSTING-LOG.md](POSTING-LOG.md) with completed actions and unresolved tasks. Keep exact posting copy in the Pin files and Sheet so a later edit can be audited. Share the public links and tracker link when reporting completion.

## 9. Scheduling and completed setup

**Setup and scheduling completed on 2026-10-27–28:** Villa Fabulosa remains a Business account. The live website verification tag and Pinterest claim were verified for **villafabulosa.com**. All five exact public boards were created with saved descriptions and public privacy; all 13 existing campaign Pins were moved and reload-verified with their original public URLs, posting dates and copy preserved. At that checkpoint the campaign had **15 published, 10 scheduled and 50 prepared for later scheduling**. Scheduled IDs, in order: **051, 043, 069, 066, 068, 036, 049, 034, 052, 038**. The ten saved owner-only previews confirm title, full description, UTM, board, date and time. Alt text, manual AI Off, generated-person Off and Ad-only Off were checked before submission; those fields are unavailable in the saved scheduled UI and are not marked saved-verified. See the [board/schedule plan and verified states](board-schedule-plan-2026-10-27.json) and [domain receipt](domain-claim-setup-2026-10-27.md).

Pinterest's native scheduler permits at most **10 future Pins** and dates up to **30 days ahead**, as checked on 2026-10-27. The first ten saved slots ran **28–31 October 2026** and all published. All remaining 62 were originally planned for **28 October–17 November 2026**, at **10:00, 15:00 and 20:00 Asia/Karachi (UTC+05:00)**, with two on the final day.

**Continuation on 2026-11-03:** the queue read 0 future Pins; the ten queued Pins were reconciled public with full saved-field readback. Because the slots for 057–048 had passed, the 50 unsubmitted entries were shifted exactly **+3 days** (daily groupings unchanged; calendar now ends **20 November**); originals are kept as `original_planned_publication_local/utc`. A bounded batch then scheduled **057, 039, 075, 045, 041, 030, 048, 070, 059, 053** for **4–7 November**, each saved-verified. State then: 25 published, 10 scheduled, 40 planned, 22 historical submissions; next backlog ID 067. Check the live queue and public Pins before retrying or advancing. If backlog slots pass again, shift the whole unsubmitted backlog by whole days (keeping daily groupings and at most three per day) rather than publishing overdue Pins.

**Continuation on 2026-11-08:** the queue again read 0; 057, 039, 075, 045, 041, 030, 048, 070, 059, 053 were reconciled public with full saved-field readback and image checks. 067, 073 and 040 had passed, so the 40 unsubmitted entries were shifted **+1 day** (calendar now ends **21 November**). 067/073 keep a day of their own because 053 from their original day had already published. A bounded batch scheduled **067, 073, 040, 050, 019, 031, 017, 055, 023, 072** for **8–11 November**, each saved-verified. State: **35 published, 10 scheduled, 30 planned**, 32 historical submissions. Next backlog ID is **056**, planned for **2026-11-11T20:00:00+05:00**; the earliest opening follows 067's 8 November 15:00 slot.

**Builder load stall (2026-11-08):** the first `scheduleOpenDraft` for 067 timed out waiting for the upload input because `/pin-builder/` rendered only its header. Nothing was uploaded. The in-memory guard then correctly blocked a second draft. After confirming the plan state (`planned_not_submitted`) and an empty queue, a clean controller `close` and driver relaunch cleared the guard, and the retry worked. Never clear guards this way after an upload or submission attempt; inspect the queue and profile first.

Helper notes from 2026-11-03: `scheduleVerifyPublic <ID> url=<observed public URL>` is the generic read-only public verifier (it never saves the editor or writes the plan); record results with a reviewed, dated step. `scheduleVerifySaved` now compares the queue card's date numerically because Pinterest shows unpadded days such as `11/4`. [Pinterest scheduler limits](https://help.pinterest.com/en/business/article/schedule-pins)

For every new scheduled Pin, use regular organic `/pin-builder/`, select **Publish at a later date**, choose the assigned board, fill the date and select the time from its native menu. Typing the time with `.fill()` reverted it to noon during this setup; exact pre-submit readback caught that before submission. Fill title/link first and type the full description last with native input and blur. Compare the full form before submission. After the native confirmation, inspect the queue and reload the owner-only scheduled preview. Record only exposed saved fields; the preview is not a public Pin URL and its planned publication date is not an actual posting date.

Use [CLAUDE-HANDOFF.md](CLAUDE-HANDOFF.md) for the exact continuation state, helper limits and next action. Browser automation must have one writer; inspect uncertain submissions before retrying. Do not rerun the original plan builder because it would overwrite saved evidence. No automated refill service has been installed; a future work session must reconcile the live queue and continue the authorized rolling schedule.

## Source and review notes

The owner-supplied strategy, subsequent owner decisions and actual saved Pin records determine this campaign's scope. Current Pinterest UI and official help determine platform capabilities. The scheduler and domain-claim help pages were checked again on 2026-10-27; other historical help references retain their earlier check dates. Recheck time-sensitive limits and controls before a later batch.
