# Claude handoff: Villa Fabulosa Pinterest campaign

**Handoff updated: 8 November 2026. Pinterest checkpoint verified at about 13:00 Asia/Karachi; local archive QA passed. Google Sheet/Doc synced in place to this checkpoint later on 8 November ([cloud receipt](setup-cloud-sync-2026-11-08.json)).**

The domain claim, five public boards and 13 existing-Pin moves are complete. Twenty-two automatic publications and three refills (28 October: two slots; 3 November: ten; 8 November: ten) have been verified. There are **35 published Pins, ten future Pins and 30 locally prepared/planned Pins**. The dedicated browser/controller was cleanly closed. The task is to continue the existing campaign, preserve its public Pins and refill native scheduling slots as capacity becomes available. These counts are a dated checkpoint, not a live promise after the next scheduled time passes.

## Workspace and exact resume point

Use the existing Windows workspace **`D:\laravel\villafab-laravel`**, PowerShell and installed Node/Playwright. The Pinterest account is **Villa Fabulosa**, profile `https://www.pinterest.com/VillaFabulosa/`. The Google/Chrome profile name is not the Pinterest account identity.

The owner selected **75 Pins**, all 15 approved keywords across five locations. All artwork already exists. The owner most recently authorized claiming the domain, creating the five public boards, distributing the campaign evenly and scheduling three Pins daily. There is no authorization to launch ads, delete Pins, change sharing or replace existing published URLs. No new image creation, resizing or image editing is needed for this continuation.

**Verified Pinterest checkpoint — [setup-2026-11-08.json](setup-2026-11-08.json):**

| Item | Verified state |
| --- | --- |
| Published campaign Pins | **35**: original 001–013; 014/064 (reconciled 28 October); 051, 043, 069, 066, 068, 036, 049, 034, 052, 038 (published 28–31 October, verified 3 November, [batch](batch-2026-11-03.json)); and **057, 039, 075, 045, 041, 030, 048, 070, 059, 053** (published 4–7 November at their native slots, verified 8 November, [batch](batch-2026-11-08.json)) |
| Domain | Claimed; public tag and post-reload claimed-account readback verified |
| Five public boards | All five `created_verified_public`; exact names, descriptions and public settings verified |
| Existing Pin moves | All 13 `moved_and_reload_verified`, preserving every public URL and other saved field |
| Native scheduled queue | **10**: 067, 073, 040, 050, 019, 031, 017, 055, 023, 072, from 8 Nov 15:00 to 11 Nov 15:00 Asia/Karachi. Individual saved fields and the final read-only queue readback (exactly ten, no unknown entries) verified; owner-only preview URLs are in the receipt |
| Remaining local backlog | **30**, prepared/planned only. There have been **32 historical scheduling submissions**: twenty-two have published and ten remain future |
| Backlog rebases | Whole-day shifts of the unsubmitted backlog only: **+3 days on 3 November** (057–048 had passed) and **+1 day on 8 November** (067, 073, 040 had passed). Daily groupings and order are unchanged; 067/073 keep their own 8 November day because 053 from their original day had already published. The calendar now ends **21 November 2026**. Originals are kept per Pin as `original_planned_publication_local/utc`, and both shifts are in `schedule_policy.rebase_history` |
| Next rolling calendar slot | **056**, **11 Nov 2026 20:00 Asia/Karachi** / **15:00 UTC**, board 4. The queue is full: wait for a slot, reconcile the actual live state, then authorize a bounded refill |
| Earliest expected queue opening | After **067** publishes at its **8 Nov 2026 15:00 Asia/Karachi / 10:00 UTC** slot. Verify its actual public URL/saved fields before treating that slot as free |
| Scheduler browser timezone | Verified **Asia/Karachi** on 8 November. Recheck on later recovery; use recorded UTC instants if browser timezone differs |
| Google Sheet / Google Doc | **Synced in place on 8 November** with the Sheets/Docs editor connectors ([cloud receipt](setup-cloud-sync-2026-11-08.json)): 3,894 Sheet cells read back with 0 mismatches; Doc 22 paragraphs updated, 7 added, 60 table rows added and verified. Same files and links; sharing unchanged. Update them in place after each later checkpoint and never recreate them |
| Local/remote Git | Observed local `main` at `1fc573066ed827a9ee2c9dc683d5b754e6f4bc0a`; dirty working tree; remote HEAD not queried; no commit/push performed |
| Browser / active scheduling batch | Driver cleanly closed through RPC (`closed: true`); `schedule_policy.active_scheduling_ids` is **[]**, blocking new scheduling mutations until the next reconciled bounded batch |

The first action after receiving the final handoff is **read the actual queue and reconcile any scheduled Pins that have since published**. Do not upload Pin 014 simply because it is the lowest unpublished creative ID. Scheduling order is deliberately interleaved and the current calendar cursor must come from the saved receipt/plan.

## Authoritative files and status meanings

Read these in order:

1. This handoff's final checkpoint, then [WORKFLOW.md](WORKFLOW.md) and [POSTING-LOG.md](POSTING-LOG.md).
2. [board-schedule-plan-2026-10-27.json](board-schedule-plan-2026-10-27.json). This is the full 75-Pin mapping, exact board IDs/names/URLs, saved board-move receipts, planned local/UTC calendar and posting copy. Its original `current_status_at_plan` is historical; inspect the explicit operation/saved-schedule fields for subsequent actions.
3. [board-schedule-plan-2026-10-27.md](board-schedule-plan-2026-10-27.md) for the readable full calendar. A planned date alone is never evidence of successful scheduling.
4. [setup-2026-10-28.json](setup-2026-10-28.json) and dated publication batches through [batch-2026-10-28.json](batch-2026-10-28.json). The 28 October batch records reconciled public Pins 014 and 064 rather than new immediate uploads. Their posting date is the observed public date; Pinterest did not expose the exact actual publication timestamp. Do not treat `batch-2026-10-25-superseded-prepared.json` as published Pins.
5. [prepared/manifest.json](prepared/manifest.json), [prepared/matrix.json](prepared/matrix.json) and each `prepared/pin-NNN/metadata.json`, `posting.md`, `review.json`, `prompt.txt`, `pin-NNN.png`. [prepared/index.html](prepared/index.html) is the visual index. These folders are the original 012–075 local asset archive; their filenames do not establish live status.
6. [domain-claim-setup-2026-10-27.md](domain-claim-setup-2026-10-27.md), [tracker-sheet.md](tracker-sheet.md) and [rules-doc.md](rules-doc.md) for technical and cloud readback receipts.

Keep these states separate:

| State | Evidence required |
| --- | --- |
| Prepared | Artwork and posting copy exist locally; no live Pinterest record implied |
| Planned | Target board/date/time recorded; no successful submission implied |
| Submission attempted / pending verification | A mutating click was attempted; inspect the live outcome before any retry |
| Scheduled | The Pin is in Pinterest's future queue, with saved fields and exact scheduled instant read back |
| Published | A public Pin URL exists, the matching image is visible and saved copy/settings are reloaded and read back |

An internal scheduled Pin ID or editing URL is not automatically a public URL. Never enter a future scheduled date as an actual posting date. Leave performance metrics blank unless measured. Never replace verified saved copy with intended copy before the save/readback succeeds.

## Board mapping and fixed quota

| ID | Exact public board | Photo families | Campaign quota |
| --- | --- | --- | ---: |
| board_1 | Villa Fabulosa \| Luxury Estate & Resort Amenities | 9, 13, 15: bedrooms and foyer | 15 |
| board_2 | Temecula Wine Country Vacation Rental | 7, 11, 14: aerial, estate view, outdoor recreation/hills | 15 |
| board_3 | Group Vacation Home & Family Reunion Ideas | 4, 6, 12: miniature golf, arcade, kitchen | 15 |
| board_4 | Resort-Style Pool & Outdoor Living | 1, 5, 8: pool and patio | 15 |
| board_5 | Corporate Retreats & Private Getaways | 2, 3, 10: living, covered lounge, dining | 15 |

All five public board URLs are in the JSON plan. Do not create another board with the same name. Three source-photo families × five creatives give each board exactly 15 across the completed campaign. That quota includes the 13 existing public Pins; it is not 15 new Pins per board. A gathering-space photo does not establish event permission or a dedicated corporate meeting facility.

Existing URL-preserving move mapping: **001→4, 002→5, 003→5, 004→3, 005→4, 006→3, 007→2, 008→4, 009→1, 010→5, 011→2, 012→3, 013→2**. A final `moved_and_reload_verified` receipt means the operation is done. Preserve the legacy board rather than deleting it as cleanup.

## Browser ownership and recovery

The browser driver controls a dedicated persistent Chrome profile, **not the user's ordinary Chrome**. The user manually authenticated this dedicated profile. Its directory is constructed by Node as:

```js
path.join(require('os').tmpdir(), 'codex-pinterest-villa-fabulosa-dedicated')
```

That profile and authentication data remain outside the repository. Never copy ordinary Chrome profiles/cookies, read passwords, inspect session tokens, export browser storage or commit authentication data. This handoff contains no credentials. Pinterest posting requires no SSH login. Domain claiming is already deployed; do not reconnect to production for routine queue work.

There must be **one running driver and one command writer**. Do not run two agents or terminals that send controller commands concurrently. Each client invocation writes a single shared command file, so parallel clients can overwrite commands/responses. All mutating operations are sequential, one Pin at a time. Read-only local file work can run separately.

From the workspace, first use the existing driver's health endpoint, only once no other operator is issuing commands:

```powershell
Set-Location 'D:\laravel\villafab-laravel'
node tmp/pinterest-live-client.cjs health
```

An explicit `browserConnected: true` allows using the recovery action below if the dedicated page is closed. A health result confirms connectivity, not account identity or authentication. Inspect the actual Pinterest page/profile before mutations. The persistent context can return no `context.browser()` object, so missing/undefined `browserConnected` is not a usable recovery signal. Do not call `recoverPage` in that case: confirm the old controller is stopped, close its stale dedicated context safely and relaunch the same profile without starting two drivers.

```powershell
node tmp/pinterest-live-client.cjs recoverPage
node tmp/pinterest-live-client.cjs inspect
```

If no driver is running, the client times out after roughly 55 seconds. A timeout does **not** prove a previous publish/schedule operation failed. Inspect the existing queue/public profile before retrying any submission. Do not start a second driver while an existing one holds the persistent profile.

If the driver is confirmed stopped, start it from one dedicated terminal and keep that terminal alive:

```powershell
Set-Location 'D:\laravel\villafab-laravel'
node tmp/pinterest-browser-live.cjs
```

Wait for `browser_ready`. The visible Chrome window uses the same dedicated profile. In a separate command terminal, run the sequential client commands. If Pinterest asks for authentication, let the owner sign in directly in that window; do not request or type a password. Confirm **Villa Fabulosa** before doing anything else.

At the end, once all pending requests are finished, close through the controller:

```powershell
node tmp/pinterest-live-client.cjs close
```

The profile persists for later manual-authenticated reuse; do not delete it as routine cleanup.

## Helper architecture and scope

These are local automation helpers; confirm each exists on the current machine. Do not assume ignored/untracked `tmp` files are present in a fresh Git clone.

| Helper | Purpose |
| --- | --- |
| `tmp/pinterest-browser-live.cjs` | Launches dedicated persistent Chrome; holds `session.context` and `session.page`; polls one shared command file |
| `tmp/pinterest-live-client.cjs` | Sends a single action with a unique `request_id`, waits for the matching response, exits nonzero on a returned error |
| `tmp/pinterest-live-actions.cjs` | Hot-reloaded action router; health/recovery/inspection and old publication actions; delegates setup actions |
| `tmp/pinterest-setup-actions.cjs` | Guarded claim readback, board setup, exact existing-Pin board moves and reload verification |
| `tmp/pinterest-setup-batch-client.cjs` | Sequential wrapper for `boardMovePinComplete` on existing 001–013 only; stop at first error |
| `tmp/pinterest-live-command.json` / `tmp/pinterest-live-response.json` | Transient RPC files; match `request_id`, not just latest content; not authoritative saved-state receipts |
| `tmp/pinterest-schedule-actions.cjs` | Opens one approved unsent scheduling draft; checks bounded active IDs, live capacity, unknown queue entries, prepared metadata, image path, exact copy and duplicate guards |
| `tmp/pinterest-schedule-finalize.cjs` | Scheduling configuration, full checks, guarded submission and saved-queue verification; standalone read-only `scheduleReadQueue`, `scheduleReadProfile` and `scheduleVerifyPublic` work without a draft |
| `tmp/pinterest-schedule-batch-client.cjs` | Sequential wrapper over `schedule_policy.active_scheduling_ids`; verifies each saved Pin before continuing, skips verified records and stops at the first unresolved attempt |

The driver deletes the Node require cache before loading the action router each command. UI session variables such as current draft/upload/attempt guards live in the running driver and are lost on restart. Persisted platform receipts are therefore necessary for duplicate protection after recovery.

**The old publication helper is hard-coded to batch 2026-10-27, IDs 012 and 013. Both are already published. Do not reuse its `openCreator`, `upload`, `publish`, `activateOct27Batch` or other old immediate-publication flow for the future queue.** Do not merely remove the ID guard. The new scheduler must use the complete calendar and guard against both published and already-scheduled IDs.

For read-only reconciliation after a driver restart, the new scheduler provides a standalone action which does not require a current draft:

```powershell
node tmp/pinterest-live-client.cjs scheduleReadQueue
node tmp/pinterest-live-client.cjs scheduleReadProfile
```

The first command opens the dedicated account's native queue at `https://www.pinterest.com/VillaFabulosa/scheduled-pins/`; the second reads the public profile to help locate due publications. Both are read-only and work without a current draft. Run reconciliation before selecting the next upload. The other scheduling actions still require the matching in-memory draft/upload guards, and those guards are intentionally cleared after successful saved-queue verification.

The scheduling helpers use **`schedule_policy.active_scheduling_ids`**. It is **[]** at handoff, so starting the wrapper now does not upload anything. After reconciling live public/queued state, set this array in the existing JSON plan to only the next eligible calendar IDs, with its length at most the number of free native slots. For example, if exactly one slot becomes free and 056 is still the next future unsubmitted record, the bounded batch is `["056"]`. Preserve every other receipt and metadata field. Do not delete this property, remove the guards or authorize the entire backlog for one wrapper run. Clear the array back to **[]** after the bounded batch is verified or when stopping.

After that capacity check and explicit bounded-array update, the tested per-Pin sequence is:

```powershell
# Example for the next record: run only after 056 is in the bounded active batch.
node tmp/pinterest-live-client.cjs scheduleOpenDraft 056
node tmp/pinterest-live-client.cjs scheduleConfigure 056
node tmp/pinterest-live-client.cjs scheduleCheckDraft 056
node tmp/pinterest-live-client.cjs scheduleSubmit 056
node tmp/pinterest-live-client.cjs scheduleOpenQueue 056
node tmp/pinterest-live-client.cjs scheduleVerifySaved 056
```

Inspect each response and require exact checks/`match: true` before proceeding to submission. The sequential batch wrapper performs the opening, configuration, submission, confirmation and saved verification for the explicitly active IDs:

```powershell
node tmp/pinterest-schedule-batch-client.cjs
```

Do not run the wrapper alongside individual client commands. Its optional Pin argument resumes an already opened draft at configuration; it is not an instruction to force a new draft after an uncertain submission. `scheduleOpenDraft` rereads the native queue, refuses a count of ten and refuses an unknown/unreconciled queued item before uploading. Retain those checks. Submission/verification dates now use the plan's timezone dynamically.

The new `scheduleReconcilePublic` action was written for the two observed 014/064 public URLs and contains fixed **28 October** publication-date fields. Do not assume it can reconcile 051 or other future IDs, and do not reuse its fixed date template for later publications without review. For another due Pin, use generic `scheduleReadProfile`, locate its actual public card and match the title, image and unique `utm_content=pin_NNN` destination. Then use a reviewed read-only saved-field verifier with that observed URL and record a new dated receipt. Never derive a public Pin URL from the internal scheduled ID, reset a disappeared queue card to Prepared, or reuse the old 012/013 verifier.

**Generic public verifier (added 3 November):** after `scheduleReadProfile` shows a due Pin's card, run `node tmp/pinterest-live-client.cjs scheduleVerifyPublic <ID> url=https://www.pinterest.com/pin/<number>/`. It refuses a non-due, already-recorded or duplicate URL, fully reloads the public Pin, reads Edit Pin (title, caption, destination, board, alt text, manual AI, Ad-only), closes it with **Cancel** and returns `match`. It saves a screenshot as `tmp/pinterest-public-<ID>-<date>.png` and **never writes the plan**. Compare the screenshot with the prepared PNG, then record the result with a new, reviewed, dated step. `tmp/record-public-nov03.cjs` and `tmp/record-public-nov08.cjs` are one-offs for their ten IDs and must not be rerun; derive a reviewed, dated copy for the next set.

**Queue date format:** Pinterest's queue shows unpadded days (`Wed, 11/4`). `scheduleVerifySaved` previously required `11/04` and failed after a successful save of 057 on 3 November; it now compares the date numerically. After any verifier failure, the Pin stays in `scheduled_pending_readback` with its in-memory guards, so rerun only `scheduleVerifySaved <ID>` in the same driver session; do not resubmit.

Do not run `tmp/build-board-schedule-plan.cjs` as a resume command. It was a one-time planner and rewrites the plan from scratch, which would erase subsequently recorded board and schedule progress. Read and update only verified target records in the existing plan.

**Builder load stall (8 November):** the first `scheduleOpenDraft 067` timed out because `/pin-builder/` rendered only its header, with no upload input. Nothing was uploaded, and the in-memory guard correctly refused a second draft. After confirming `planned_not_submitted` in the plan and an empty queue, a clean `close` plus driver relaunch cleared the guard; the retry and `pinterest-schedule-batch-client.cjs 067` (resume at configuration) then succeeded. Use a restart this way only when nothing was uploaded or submitted.

Do not rerun the dated one-offs **`tmp/record-public-nov03.cjs`**, **`tmp/rebase-backlog-nov03.cjs`**, **`tmp/build-receipts-nov03.cjs`**, **`tmp/sync-pinterest-local-nov03.cjs`** or their **`-nov08`** counterparts. The rebase refuses a second run on the same date, but a later date would shift the backlog again. The sync is hard-wired to the 3 November receipts. Derive any later receipt or local sync from them only after review. Do not run **`tmp/finalize-pinterest-setup-receipt.cjs`**: it has stale fixed 13/10/52 counts. Do not reuse **`tmp/record-public-oct28.cjs`** after this checkpoint: it is a one-off which resets active IDs to 052/038. **`tmp/finalize-pinterest-setup-oct28.cjs`** produced the current receipt once; it is not a general future refill command. Later receipts must be derived from newly reconciled public and future states, preserving historical scheduling records.

## Native scheduling limits and rolling continuation

Pinterest's official help, rechecked **27 October 2026**, permits **10 future Pins total**, dates up to **30 days ahead**, and one scheduling submission at a time. The help describes editing scheduled copy/date/board/link, but the actual queue Actions menu in this session exposed **Publish now** and **Delete**, with no saved edit controls found. Do not use either as an editing workaround. Scheduled images cannot be replaced. Recheck the current help and actual interface when resuming. [Pinterest: Schedule Pins](https://help.pinterest.com/en/business/article/schedule-pins)

The full 62-Pin calendar cannot be placed in the native queue simultaneously under that limit. The initial checkpoint recorded ten scheduling submissions and 52 **planned local backlog** entries. Those scheduling receipts remain historical when Pins publish: do not count them as ten current future Pins forever. The 28 October continuation reconciled 014 and 064 as public and refilled two free slots with 052 and 038, giving 15 public, ten future and 50 planned, with 12 historical submissions. The 3 November continuation found the queue empty, reconciled the ten queued Pins as public, rebased the backlog +3 days and refilled all ten slots, giving 25 public, ten future and 40 planned, with 22 historical submissions. The 8 November continuation repeated that cycle with a +1-day rebase, giving **35 public, ten future and 30 planned**, with 32 historical submissions. This is not an installed background automation: Claude or another authorized operator must revisit and refill available future slots after queued Pins publish.

The first ten historical scheduling assignments, in calendar order, are below. The current native future queue may contain fewer or different entries after publication/refill; read the final receipt and live queue.

| Order | ID | Asia/Karachi (UTC+05:00) | UTC | Board |
| ---: | --- | --- | --- | --- |
| 1 | 014 | 28 Oct 2026 10:00 | 28 Oct 05:00 | 1 |
| 2 | 064 | 28 Oct 2026 15:00 | 28 Oct 10:00 | 4 |
| 3 | 051 | 28 Oct 2026 20:00 | 28 Oct 15:00 | 2 |
| 4 | 043 | 29 Oct 2026 10:00 | 29 Oct 05:00 | 3 |
| 5 | 069 | 29 Oct 2026 15:00 | 29 Oct 10:00 | 1 |
| 6 | 066 | 29 Oct 2026 20:00 | 29 Oct 15:00 | 5 |
| 7 | 068 | 30 Oct 2026 10:00 | 30 Oct 05:00 | 3 |
| 8 | 036 | 30 Oct 2026 15:00 | 30 Oct 10:00 | 2 |
| 9 | 049 | 30 Oct 2026 20:00 | 30 Oct 15:00 | 1 |
| 10 | 034 | 31 Oct 2026 10:00 | 31 Oct 05:00 | 4 |

The first refill assignments, **052** and **038** (31 October), published. The second refill (3 November, after the +3-day rebase), **057–053** for 4–7 November, also published. On 8 November, after the +1-day rebase, the third refill saved **067, 073** (8 Nov), **040, 050, 019** (9 Nov), **031, 017, 055** (10 Nov) and **023, 072** (11 Nov 10:00/15:00). The next backlog slot is **056, 11 November 20:00 Asia/Karachi / 15:00 UTC, board 4**. The calendar now runs through **21 November 2026**, with two final-day Pins. It intentionally mixes different keywords, locations, boards and photo families within each day and avoids consecutive equal headlines. Do not replace this sequence with simple numeric order.

When resuming:

1. Read the current client date/time, existing receipt and live scheduled queue. Confirm the browser timezone used by Pinterest; never assume the host clock, account locale or Windows display implies Asia/Karachi. Use the explicit UTC instants in the JSON plan for conversion and read back the saved date/time after submitting.
2. Reconcile queued Pins that have published. Open each resulting public URL, check the image and reload saved fields, then record the actual posted date and verification scope. Do not recreate an already-published asset.
3. Count current future Pins before uploading. If there are 10, stop queue mutations and record the next planned ID and the next opening. Existing standing authorization to schedule does not increase the platform limit.
4. If slots are free, choose the earliest unsubmitted plan entry whose target instant is future and within 30 days. If a backlog date has passed, rebase only the unsubmitted backlog, preferably by whole days so the validated daily groupings survive (as on 3 November), keep at most three per day, keep the originals in `original_planned_publication_local/utc`, and document the replacement local/UTC instants in `schedule_policy.rebase_history`. Do not publish those overdue Pins immediately or silently modify already verified schedules.
5. Prepare and submit one Pin at a time through the new guarded schedule helper or the native standard-Pin interface. Confirm the saved scheduled record before advancing the cursor.
6. Stop after filling available native capacity. Persist the exact next backlog slot, queued IDs, saved schedule instants and verification evidence. Update local/archive/cloud records with the distinction between planned, scheduled and published.

## Exact scheduling/readback requirements

Use regular organic **Create Pin** at `/pin-builder/`. The legacy `/pin-creation-tool/` previously redirected to `/idea-pin-builder/`, an Idea-ad flow. Confirm the current interface instead of assuming an old route is still valid. Keep **Ad-only Off** and select **Publish at a later date**.

For each selected creative, use its original PNG and exact prepared title, full description including three hashtags, complete UTM and alt text. Titles are at most 100 characters and descriptions 100–500 characters. Set Title and Link first, enter Description last using native input, blur and compare the entire value. Historical `.fill()` on the editable caption appended a duplicate, and later Link entry once truncated the caption. A filled form alone does not prove a saved result.

Unique tracking format, preserving the creative ID:

```text
https://villafabulosa.com/?utm_source=pinterest&utm_medium=organic_social&utm_campaign=villa_fabulosa_75_pins&utm_content=pin_057
```

Do not reuse a UTM ID for a different image. Every campaign ID through 075 is allocated; the next unused creative ID is 076 and outside this campaign. Existing published Pin 009 uses `samples/pin-009-v2.png`; its older original remains unposted.

Before the Schedule click, verify exact title, entire caption/hashtags, destination, alt text, matching uploaded image, exact target public board, local and UTC schedule, regular organic flow, **Ad-only Off**, **manual AI disclosure Off**, and **AI-generated person unchecked**. The actual 75 campaign images contain no generated people. Use relevant native related topics only if offered; typed hashtags are a separate field, and an unavailable selector is not a successful topic selection.

After the click, return to the future queue, reload and open the saved scheduled record. Read back its ID, target board, exact title, complete caption, UTM, alt text where exposed, saved time/timezone and settings. Verify the image. Record any unexposed field as not verified rather than claiming it passed. Capture a durable record before the next upload. If submission errors or times out, inspect both the queue and Created/Public profile before retrying. An attempted/uncertain submission must retain its guard until reconciled.

After actual publication, open the individual public URL, fully reload, open Edit Pin and compare exact saved fields. Preserve the public URL when correcting copy or moving boards. Do not duplicate a Pin to repair its description.

The owner's preference is **manual AI disclosure Off**. Pinterest can independently apply an automatic **AI modified** badge; the original 13 Pins displayed one at their own historical checks. **No badge was observed on public 014/064 at the 28 October check**; that observation does not guarantee a badge will never appear. Future queued/prepared records have no observed public badge yet. Record manual disclosure and automatic badge separately. Never promise badge removal, strip provenance metadata or alter an image to evade detection. [Pinterest: Gen AI labels](https://help.pinterest.com/en/article/gen-ai-labels)

Copy accuracy remains mandatory: Villa Fabulosa is in **Temecula Wine Country, Riverside County, Southern California**. Los Angeles and Orange County titles address travelers **from** those areas. Do not locate the estate in those counties/cities. Unsupported `#1`, savings, platform-fee and best-rate guarantees were replaced in the approved assets; do not restore them from the original brief.

## Cloud tracker and documentation

Google Sheet: https://docs.google.com/spreadsheets/d/14MKMtjdMdPHqVvackdM6Gcn34C0YWOY4fBVUTh9VtTE/edit

Google Doc: https://docs.google.com/document/d/1B-CN1gnRRRtuwjpHpgpw_hlzG7vL3c6LucCg4sGoaUU

The original keyword sheet is a source, not the posting tracker: https://docs.google.com/spreadsheets/d/1aNHMxeokyUFZGjOtK_Lg17W-U17oKpwzr7LLXfcSvcs/edit . Exact green cells/keywords are retained in [CAMPAIGN-REFERENCE.md](CAMPAIGN-REFERENCE.md).

The verified native Sheet now has five tabs:

| Tab | Sheet ID | Verified range | Records at checkpoint |
| --- | --- | --- | --- |
| Pins | 1772117377 | A1:V36 | 35 public Pins |
| Performance | 173001004 | A1:J36 | 35 public Pins, all measurements blank |
| Prepared Queue | 1436571161 | A1:Z65 | Original 64-asset archive: 24 published, ten scheduled, 30 prepared |
| Boards | 1304598349 | A1:L6 | Five public boards |
| Schedule | 1904913508 | A1:AB63 | Calendar's 62 records: 22 published, ten scheduled, 30 planned; D:E rebased instants, AA:AB pre-rebase originals |

Find each exact Pin ID before choosing an update range; the calendar order is interleaved. Preserve prior rows, saved copy, links, formatting, native dates and sharing. Leave unmeasured analytics blank. The Sheet's existing sharing remains owner plus `anyone/reader`; the rules Doc remains owner-only. Do not change sharing. Use current connected Google tools where available; no copied Google cookies or password handling.

**Synced on 8 November:** `Pins`/`Performance` gained the twenty public rows (051, 043, 069, 066, 068, 036, 049, 034, 052, 038, 057, 039, 075, 045, 041, 030, 048, 070, 059, 053; metrics blank); `Prepared Queue` is 24 Published / 10 Scheduled / 30 Prepared; `Schedule` is 22 Published / 10 Scheduled / 30 Planned with the original instants in AA:AB; `Boards` counts match `setup-2026-11-08.json`. Schedule and Boards store dates and 19-digit schedule IDs as text: write them with typed `updateCells` string values, never `update_values` (which would parse them). For the next checkpoint, derive rows from the same sources, read back, and record a new receipt.

[setup-cloud-sync-2026-11-08.json](setup-cloud-sync-2026-11-08.json) is the current cloud receipt (3,894 compared Sheet cells, 0 mismatches; Doc table cells 250 to 530; hyperlink runs 30 to 50). Earlier, [setup-cloud-sync-2026-10-28.json](setup-cloud-sync-2026-10-28.json) confirmed **3,912 cells matched** across these tabs. The native Doc preserved its previous **222 table cells**, added 28 for a total of **250**, and verified **38 paragraph groups**; all 22 named headings and 30 link occurrences were checked. Visual checks used native formatting metadata, with no claim of Google-rendered page fit. The cloud operation changed no sharing and collected no performance data.

Update `WORKFLOW.md`, `POSTING-LOG.md`, per-Pin metadata/Markdown, the master queue/archive and the native tracker consistently from saved Pinterest evidence. A board move changes the board record, not the original posted date or URL. A scheduled record changes scheduling status/instant, not the public posted-date field. Recheck the final cloud readback receipts before claiming synchronization succeeded.

## Git and local helper preservation

The observed local branch is **`main`**, at **`1fc573066ed827a9ee2c9dc683d5b754e6f4bc0a`**, with origin **`https://github.com/hassanjrao/villafab.git`**. No commit or push was performed for this setup, and the remote HEAD was **not queried**. The working tree contains campaign changes and preexisting unrelated changes; it is not clean. Recheck before a later selective commit rather than assuming these setup updates are already pushed.

`tmp/pinterest-browser-live.cjs`, `tmp/pinterest-live-actions.cjs` and `tmp/pinterest-live-client.cjs` are tracked in this checkout. The new `tmp/pinterest-setup-actions.cjs`, `tmp/pinterest-schedule-actions.cjs`, `tmp/pinterest-schedule-finalize.cjs` and `tmp/pinterest-schedule-batch-client.cjs` were **untracked** at the observation. They exist in this workspace and support resuming here, but a fresh clone will need a reviewed copy or a later selective commit of appropriate nonsecret helpers. Do not claim all helpers were pushed.

This Windows checkout currently needs a command-scoped Git `safe.directory` exception because the recorded owner SID differs from the execution identity. Use the exact known workspace as the exception; do not add a global wildcard. For a later read-only check:

```powershell
Set-Location 'D:\laravel\villafab-laravel'
git -c safe.directory=D:/laravel/villafab-laravel status --short
git -c safe.directory=D:/laravel/villafab-laravel branch --show-current
git -c safe.directory=D:/laravel/villafab-laravel rev-parse HEAD
git -c safe.directory=D:/laravel/villafab-laravel ls-files docs/pinterest tmp/pinterest-browser-live.cjs tmp/pinterest-live-client.cjs tmp/pinterest-live-actions.cjs tmp/pinterest-setup-actions.cjs tmp/pinterest-schedule-actions.cjs tmp/pinterest-schedule-finalize.cjs
```

Never commit `.env`, browser profile data, cookies, session/storage exports, credentials, private backups or unrelated temporary claim-access scripts. Preserve **`.claude/settings.local.json`** and all other preexisting unrelated dirty files. Do not reset, discard, stage or rewrite them while saving campaign work. Git changes and pushes need to follow the owner's current authorization; this handoff itself does not assert that the latest campaign checkpoint was pushed.

## Recorded verification

- **8 November 2026:** [setup-2026-11-08.json](setup-2026-11-08.json) records the live queue read at 0 future Pins, ten reconciled public Pins (057, 039, 075, 045, 041, 030, 048, 070, 059, 053), the +1-day backlog rebase, ten new saved schedules and the final ten-item queue readback. [batch-2026-11-08.json](batch-2026-11-08.json) records each public URL with full saved-field readback (closed with Cancel), the visual image match and badge Not observed. Posted dates are the scheduled dates. New schedules verified title, full caption, destination, board, date, time and timezone; alt text, manual AI Off, no generated person and Ad-only Off were checked before submission only. [setup-local-sync-2026-11-08.json](setup-local-sync-2026-11-08.json) passed with all protected hashes unchanged. The Google Sheet/Doc were then synced in place ([cloud receipt](setup-cloud-sync-2026-11-08.json)). No commit or push was made, and unrelated dirty files were untouched.

- **3 November 2026:** [setup-2026-11-03.json](setup-2026-11-03.json) records the live queue read at 0 future Pins, ten reconciled public Pins, the +3-day backlog rebase, ten new saved schedules and the final ten-item queue readback. [batch-2026-11-03.json](batch-2026-11-03.json) records each public URL, exact saved title, full caption, UTM, board, alt text, manual AI Off and Ad-only Off from Edit Pin after full reload (closed with Cancel). It also records the visual image match and badge Not observed. Posted dates are the scheduled dates; exact timestamps are unavailable. New schedules verified title, full caption, destination, board, date, time and timezone; alt text, manual AI Off, no generated person and Ad-only Off were checked before submission only. [setup-local-sync-2026-11-03.json](setup-local-sync-2026-11-03.json) passed with all artwork/source/prompt/review/batch hashes unchanged. Cloud sync is **pending**. No commit or push was made, and unrelated dirty files were untouched.

**Earlier checkpoint (28 October):**


- [setup-2026-10-28.json](setup-2026-10-28.json) records the claimed domain, five public boards, 13 URL-preserving moves, 15 public Pins, ten future Pins and 50 planned backlog entries, with the final native queue readback at **28 October 15:13 Asia/Karachi**. It includes all ten owner-only preview URLs, exact local/UTC schedule instants, saved copy and the explicit field-verification scope.
- [batch-2026-10-28.json](batch-2026-10-28.json) records public 014 and 064. Their exact saved title, full caption/hashtags, destination, alt text, board, manual AI Off and Ad-only Off were verified after public reload, and their images were visually checked. The actual publication timestamp was not exposed; the observed public date is 28 October.
- The future saved UI verified title, full caption, destination, board, date/time and timezone. **Alt text, manual AI Off, no AI-generated person and Ad-only Off were checked before submission only**, because those controls were unavailable in the saved scheduled UI. Check them again after publication instead of reporting them reload-verified now.
- Local QA passed 75 unique IDs, keyword/location pairs and UTMs; 15 assignments per board; and exact equality of the original 13 Pins' other saved fields before/after their board moves. Local QA does not replace platform readback.
- The browser/controller was **cleanly closed**, confirmed by RPC `closed: true`. No background refill service is installed. The active scheduling array is empty.
- Git observations above are local only; no current-setup commit/push or remote-HEAD comparison was performed.
- [setup-cloud-sync-2026-10-28.json](setup-cloud-sync-2026-10-28.json) confirms native Sheet/Doc synchronization and exact readback with unchanged sharing, as detailed above. The local workflow, posting log, campaign reference and tracker/rules receipts have been updated.
- [setup-local-sync-2026-10-28.json](setup-local-sync-2026-10-28.json) passed. All 64 archived records match their metadata: four published, ten scheduled and 50 prepared. SHA-256 checks confirm all 75 artwork PNGs, actual source photos, 64 prompt files, 64 review files and old publication batches are unchanged. Original public URLs, blank future posted dates/public URLs, unmeasured metrics and requested-versus-saved AI distinctions are preserved. Gallery filters, description copying and mobile layout passed with no JavaScript errors or fake public links. The main setup receipt links both completed local/cloud receipts.

## Copy/paste prompt for Claude

```text
Continue Villa Fabulosa's authorized Pinterest campaign in D:\laravel\villafab-laravel. Read docs/pinterest/CLAUDE-HANDOFF.md, setup-2026-11-08.json and the latest workflow/log first. The verified 8 November checkpoint is 35 published, ten future and 30 planned; the dedicated browser is closed and active scheduling IDs are empty. Reconcile the current native queue and due public Pins before changing anything. The earliest expected opening follows 067's 8 November 15:00 Asia/Karachi slot; the next unsubmitted calendar entry is 056, 11 November 20:00 Asia/Karachi (after the 3 and 8 November whole-day rebases). Refill only available native slots through an explicit bounded active batch, retaining the ten-future/30-day limits, all duplicate guards, public URLs, exact copy, UTMs and board mapping. Use one dedicated driver/controller; never reuse stale one-off finalizers, regenerate artwork, publish overdue backlog immediately, launch ads or access secrets. Verify saved fields/times, update local records and handoff, sync the Google Sheet/Doc in place with the Sheets/Docs connectors (last synced 8 November), and report actual counts and next slot. Preserve unrelated dirty files, including .claude/settings.local.json. If login is needed, the owner signs in directly.
```
