# Villa Fabulosa Pinterest workflow

Last updated: 2026-10-26. Dates in this campaign use Asia/Karachi unless a platform timestamp explicitly identifies another timezone.

Use this guide for future work. Use [POSTING-LOG.md](POSTING-LOG.md) for what actually happened, the [published Pin records](samples/), the [prepared queue](prepared/README.md), and the Google Sheet linked from [tracker-sheet.md](tracker-sheet.md) for the working register. A private [Google Doc combines the rules and posting log](https://docs.google.com/document/d/1B-CN1gnRRRtuwjpHpgpw_hlzG7vL3c6LucCg4sGoaUU). Local asset review establishes preparation; publication and saved platform fields require separate live verification.

## 1. Scope and authorization

- The owner selected **75 total campaign Pins**, using all **15 green keywords × 5 target locations**. This replaces the conflicting 60-Pin totals in the original brief.
- The original sample was reviewed and approved before publication. Pins 001–004 were published and their description hashtags verified by 2026-10-19. Pins 005–007 were published and reload-verified on 2026-10-20. On 2026-10-25, the owner authorized **four more Pins**, IDs 008–011; all four are published and reload-verified, for **eleven public Pins total**.
- On 2026-10-26, the owner authorized creating **all 64 remaining Pins, 012–075**, in individual local folders, with posting later. These are **prepared locally and ready for owner review**. This instruction authorizes no Pinterest upload, publication or scheduling. The next prepared Pin to publish is **012**; the next unused creative ID is **076**, outside the completed 75-Pin campaign.
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

Villa Fabulosa's **Business account was confirmed in Business Hub on 2026-10-19**. Its website claim was still pending. Recheck the account identity before future publishing.

## 3. Campaign plan and location accuracy

The full 75-Pin asset set is prepared: **11 published Pins and 64 unpublished local Pins**. The [matrix](prepared/matrix.json) covers all 15 approved keywords across five locations exactly once, and 15 actual source-photo families with five creative variants each. The existing eleven assets anchor their source families' first variants. The five design treatments are classic editorial, photo-forward, framed, asymmetric editorial and magazine editorial; the magazine layout places the photograph above the headline. This completes the fifth-variant decision left open by the original 60-Pin brief. No generated lifestyle people were added.

| Target location | Required wording rule |
| --- | --- |
| Temecula Wine Country | The property may be described as being in Temecula Wine Country. |
| Riverside County | The property may be described as being in Temecula, Riverside County. |
| Southern California | The property may be described as being in Southern California. |
| Los Angeles | Address travelers **from Los Angeles**; do not imply the estate is located in Los Angeles. |
| Orange County | Address travelers **from Orange County**; do not imply the estate is located in Orange County. |

The only board used in the first batches is **Top Vacation Rental in Temecula Wine Country**. The original five-board plan remains future work:

1. Villa Fabulosa | Luxury Estate & Resort Amenities
2. Temecula Wine Country Vacation Rental
3. Group Vacation Home & Family Reunion Ideas
4. Resort-Style Pool & Outdoor Living
5. Corporate Retreats & Private Getaways

If the owner authorizes that setup, distribute the complete 75-Pin plan at 15 Pins per planned board. Do not create boards during a small publishing batch merely to make the original checklist appear complete.

## 4. Images and text on the graphic

- Use actual Villa Fabulosa property photos from `public/frontend/imgs/photos-for-vrbo/`. Record the precise source path for every Pin.
- Continue the approved warm ivory, navy and gold editorial design, with readable serif headlines, generous margins and a clear `Explore VillaFabulosa.com` call to action.
- Inspect every source photo and the approved style reference before generation. Use the built-in image generation tool for the generated designs, then inspect the final saved image. Preserve the full prompt and source/style-reference paths in the Pin's Markdown record.
- Ask the generation tool to preserve architecture, pool shape, furniture, scenery and amenities. Compare its output with the original: instructions alone do not prove photographic fidelity. Record visible differences honestly. Do not advertise invented property features.
- The campaign format is vertical **2:3**. The brief requests **1000 × 1500**; both the published assets 001–011 and prepared assets 012–075 are actually **1024 × 1536**. Record actual dimensions and do not silently claim an exact export size that was not produced.
- The full campaign's published and prepared creatives contain **no AI-generated people**. The original brief's lifestyle-people concept was not used in the five-treatment production mix.
- Avoid unsupported superiority, savings, fee or rate guarantees, including `#1`, `Best Rates Guaranteed`, or `Skip Platform Fees`, unless current evidence supports the exact claim. Do not imply that a reunion or retreat use automatically permits events.

Rotate the original headline bank in order, avoiding consecutive repeats. With 75 Pins, a 20-headline bank would be used about three or four times per headline. The first four used are:

1. The Ultimate Group Getaway in Temecula
2. Spacious Luxury Estate for Large Groups
3. Perfect Venue for Family Reunions & Retreats
4. Private Estate Designed for Multi-Family Stays

Original headline 5, `#1 Vacation Rental in California`, was skipped in the first published batches because its ranking is unsupported. Pins 005–007 used original headlines 6–8. Pins 008–011 used original headlines 9–12, with headline 10 factually adapted to **Luxury Bedrooms & High-End Amenities** because plural master suites are unconfirmed. Pin 009's posted asset is `pin-009-v2.png`; its original image is retained as unposted history. Prepared Pin 012 continues at entry 13, adapted to **Private Estate in Temecula Wine Country** without a travel-time claim. The remaining queue rotates the bank with factual replacements documented in [CAMPAIGN-REFERENCE.md](CAMPAIGN-REFERENCE.md) and each Pin's metadata. Pin 075 ends at adapted entry 16. Check each claim against the photo and property information. Do not reuse the sample's photograph when only its visual style is intended as a reference.

### Local preparation and owner review

Each folder `prepared/pin-012/` through `prepared/pin-075/` contains its `pin-NNN.png`, `posting.md`, `metadata.json`, `prompt.txt` and `review.json`. Posting copy includes the title, complete description with three hashtags, alt text, recommended existing board and unique destination/UTM. The full prompt and exact source/style paths accompany every asset. The original built-in generated PNG is saved without code image edits.

Use the [visual index](prepared/index.html) to review the designs, [README](prepared/README.md) for navigation, [queue CSV](prepared/queue.csv) for copy, and [manifest](prepared/manifest.json), [matrix](prepared/matrix.json) and [validation report](prepared/validation.json) for local checks. Visual reviews record legibility and source fidelity, including visible generative differences. Local validation checks file completeness, dimensions, unique IDs/UTMs and campaign coverage; it does not establish saved Pinterest state.

Keep each new record `prepared`, with public URL, posting date, scheduling date, saved manual AI setting, public AI badge and performance measurements blank. Preserve `live_verified: false`. The owner will review these assets before selecting a future publishing batch. That later instruction determines publication scope; preparing all 64 does not authorize posting them.

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

The regular organic builder and Edit Pin exposed no native topic selector for Pins 008–011 on 2026-10-25. Their three description hashtags were saved and verified; no native related topics were selected.

Tracking format:

```text
https://villafabulosa.com/?utm_source=pinterest&utm_medium=organic_social&utm_campaign=villa_fabulosa_75_pins&utm_content=pin_005
```

Increment the Pin ID once, keep the ID identical in filenames, the Sheet and `utm_content`, and never reuse a published ID for a new Pin. Check the complete destination field before saving so that a truncated display or clipboard problem does not lose tracking parameters.

## 6. AI disclosure preference and platform labels

The owner's latest instruction is to continue with generated designs and leave the **manual AI disclosure toggle Off**. For prepared Pins 012–075 this is a requested future setting only: no saved platform toggle or public badge state exists yet. When publishing, check and record the saved manual toggle state for each Pin. Do not claim a generated design is a pixel-identical original photograph, or that it contains no AI work.

The manual toggle was verified Off after full reload for Pins 001–004 on 2026-10-19, Pins 005–007 on 2026-10-20 and Pins 008–011 on 2026-10-25. Each Pin visibly displayed Pinterest's AI-modified badge at its own latest recorded check.

Pinterest can apply an **AI modified** badge automatically, independently of the manual toggle, using metadata and detection systems. Manual Off therefore does not guarantee that a public badge disappears. Record the visible badge state separately; never strip provenance metadata or attempt detection evasion. Pinterest directs owners to support if they want to appeal a label. [Pinterest: Gen AI labels](https://help.pinterest.com/en/article/gen-ai-labels)

If future creative includes generated people, document that fact and review the then-current platform disclosure requirements before posting. No current Pin should be documented as containing an AI-generated person.

## 7. Publish and verify one Pin at a time

Use the regular organic **Create Pin** builder. On 2026-10-25, the legacy `/pin-creation-tool/` redirected to **Create Pin for Idea ad** at `/idea-pin-builder/`; the observed navigation's **Create Pin** option opened the regular `/pin-builder/`. Recheck the live interface rather than assuming an old URL still opens the correct flow. Keep **Ad-only Off** and select immediate publication for a batch requested now; this workflow does not authorize launching ads.

Before publishing:

- [ ] Correct account, existing public board, next prepared ID and authorized batch count; start with 012 unless a later owner instruction specifies otherwise.
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

For the 64 prepared Pins, record local preparation/review status and proposed posting copy in the prepared queue. Leave Pin links, posting dates and live verification empty until publication is confirmed. Existing eleven published rows and their verification dates remain authoritative; local preparation does not reverify them.

Update [POSTING-LOG.md](POSTING-LOG.md) with completed actions and unresolved tasks. Keep exact posting copy in the Pin files and Sheet so a later edit can be audited. Share the public links and tracker link when reporting completion.

## 9. Future scheduling and setup

The planning cadence is **three Pins per day for 25 days** for 75 total, subject to the owner's next batch instruction. It has not been scheduled as a complete campaign. The 2026-10-25 publication batch, 008–011, is complete. The 2026-10-26 preparation batch, 012–075, is ready for owner review and has not been uploaded, published or scheduled.

At the 2026-10-19 help-page check, Pinterest's native business scheduler permitted dates up to 30 days ahead and up to 10 future Pins at a time. Recheck these limits before future scheduling; no scheduling was performed during offline preparation. Do not report that all 75 have been scheduled through one native queue. [Pinterest: schedule Pins](https://help.pinterest.com/en/business/article/schedule-pins)

Domain claiming is pending. Local application support exists in `config/services.php` through `services.pinterest.domain_verify` / `PINTEREST_DOMAIN_VERIFY`, and the shared `resources/views/layouts/partials/head.blade.php` conditionally emits the verification meta tag. Obtain the real token from the correct Pinterest account, configure/deploy it through the authorized website workflow, inspect the live page head, then complete and verify the claim in Pinterest. Prepared code is not a claimed domain.

Before future platform work, confirm the correct business account is still active and review the prepared assets and matrix with the owner. Domain claiming and the planned new-board setup remain separate unfinished work. Business status was last verified during the published batches; all 75 campaign assets now exist, while 64 still await owner review and a publishing instruction.

## Source and review notes

The owner-supplied strategy, subsequent owner decisions and actual saved Pin records determine this campaign's scope. Current Pinterest UI and official help determine platform capabilities. The official help pages above were checked on 2026-10-19; recheck time-sensitive limits and controls before a later batch.
