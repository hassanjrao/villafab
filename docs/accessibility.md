# Accessibility changes and deployment checks

The public Laravel frontend has been updated toward WCAG 2.2 AA and deployed to https://villafabulosa.com through the requested Git push/pull workflow. Automated results are evidence of the tested states, not proof of complete WCAG conformance or ADA compliance. AccessibilityChecker requires an account; the requested post-deployment scan instructions are below.

## Booking controls — 13 October 2026

Removed the added “Enter dates directly” fieldsets from the home booking widget and booking date editor at the owner's request. The original visual calendars remain, with date buttons supporting keyboard activation, arrow movement within the displayed months, Escape, and focus restoration. Existing minimum-stay, booked-date and server quote checks remain in place. No additional form fields were introduced.

The current review covers every public content route, booking with selected dates, the booking result page and the public login page. Lighthouse accessibility scores are measured separately from AccessibilityChecker's proprietary score; neither score establishes full legal compliance. Use the account's authorized scan allowance for AccessibilityChecker, without bypassing its scan limits.

## Results — 11 October 2026

| Check | Result |
| --- | --- |
| Desktop public-page scan | 50 rendered page states; zero axe violations or browser script errors |
| Mobile scan at 375 × 812 | Seven representative page states; zero axe violations or browser script errors |
| Interactive browser checks | Seven keyboard/behavior checks passed; four open-dialog/menu/editor states had zero axe violations |
| Laravel smoke tests | Two tests passed |
| Blade compilation and JavaScript syntax | Passed |

The desktop scan includes 49 public routes plus booking with selected dates. The interactive date-editor audit also identified and corrected unnamed calendar month controls and weekday contrast. Its final check passed after those corrections.

## Production validation — 11 October 2026

Application revision `4f6fa38188f72d5a16a312de6729849e44cddcd7` was pushed to `origin/main`, pulled with `git pull --ff-only origin main` in `/home/dh_2f8vmn/villafabulosa-new`, and compiled with `php artisan view:cache`. The domain was verified to serve that checkout's `public` directory. The deployed home page includes the new skip link, native date controls and accessibility script.

| Live check | Result |
| --- | --- |
| Desktop at 1280 × 720 | 50 page states; all HTTP 200; zero axe violations or browser script errors |
| Mobile at 375 × 812 | Seven page states; all HTTP 200; zero axe violations, browser script errors or failed network requests in the final scan |
| Keyboard and interactive states | Seven behavior checks passed; four expanded dialog/menu/editor audits had zero axe violations |

Live tests loaded assets from the production server. The desktop report was generated at 11:46 UTC and the final mobile report at 11:47 UTC. Reports are `storage/app/accessibility/live-axe-report.json`, `live-axe-mobile-report.json` and `live-keyboard-report.json`; the open mobile menu screenshot is `live-mobile-navigation.png` in the same directory. These generated artifacts are ignored by Git.

The initial mobile run encountered jQuery loading errors on `/wineries`. A targeted repeat and then the entire seven-state mobile scan passed; the repeat recorded no failed resource requests. The initial report is retained locally as `live-mobile-initial-report.json`. The cause of that first failure was not established.

The desktop scan still flags manual-review items: home-page color contrast, the map iframe, and captions on ten game-video pages. The referenced game videos are absent from both the checkout and the production server. These findings remain unresolved even though the automatic violation count is zero.

## Changes

- Added a keyboard skip link, main landmark, named navigation and current-page announcements.
- Added visible focus outlines, reduced-motion support and stopped automatic carousel playback.
- Corrected contrast, link underlines, heading structure, image descriptions and icon-only link names.
- Made photo tiles keyboard operable. Photo viewers announce their image and position, contain focus, isolate the background and restore focus when closed. Nested photo viewers close independently of the parent photo tour.
- Made the original visual calendars keyboard operable. The native date fields added on 11 October were removed on 13 October. Dates still pass through the existing server availability and price checks. Stale home-page quotes cannot enable booking for a superseded date selection.
- Associated form errors with their fields and announced validation, payment and availability messages. Corrected required-field semantics and focus for missing booking names.
- Added written descriptions of the upstairs and downstairs floor plans.
- Kept mobile navigation scrollable when enlarged and improved small link/control targets.

## Reproduce local tests

Use Node.js 18 or newer and a working Chrome installation. The testing packages are temporary development tools; production dependencies and the existing lockfile were not changed.

```powershell
npm install --no-save --package-lock=false playwright@1.48.2 axe-core
php artisan serve --host=127.0.0.1 --port=8099
```

In a separate terminal:

```powershell
node tests/accessibility.cjs --all
node tests/accessibility.cjs --mobile / /book-now /the-pool /instructions /wineries /team-bonding "/book-now?checkin=2026-11-20&checkout=2026-11-24&guests=2"
node tests/accessibility-keyboard.cjs
```

Set `ACCESSIBILITY_BASE_URL` to change the server URL, and `CHROME_PATH` to change the Chrome executable. The fixtures use future November 2026 dates; change them when reproducing tests after those dates.

The scanner runs axe-core rules tagged WCAG A/AA through 2.2, plus best-practice checks. It also records browser script errors, failed resource requests and rules requiring manual review. Reports are written to `storage/app/accessibility/axe-report.json`, `axe-mobile-report.json` and `keyboard-report.json`. Local static assets are served directly from `public` by the test harness, avoiding the PHP development server's single-request queue. Missing assets receive a 404; no replacement images or artificial alt text are injected by the tests. Live assets are fetched from the server, and live report filenames start with `live-`. Payment-intent requests are blocked. Keyboard tests mock availability responses to verify date handling without creating a reservation.

To repeat against production, set `$env:ACCESSIBILITY_BASE_URL='https://villafabulosa.com'` before running the same commands.

## AccessibilityChecker after deployment

1. Deploy the changed Blade views, `public/frontend/style.css`, and the JavaScript in `public/frontend/js`. Clear or rebuild Laravel's compiled views with `php artisan view:clear` or `php artisan view:cache`. Purge any CDN/page cache so the scanner receives the updated pages.
2. Verify the deployed public URL is reachable without a login. Confirm the skip link, focus outlines and original calendar keyboard controls work. No additional date-entry fieldsets should appear.
3. Open the [AccessibilityChecker link supplied for this task](https://www.accessibilitychecker.org/sign-up/?sign_action=checkout&redirect_to=https%3A%2F%2Fwww.accessibilitychecker.org%2Fmembership-account%2Fdomains%2F%23show-buy-subscription-popup). It opens an account-registration page. Use your existing account or complete registration yourself; no account or subscription was created during this task.
4. Add `https://villafabulosa.com` as the domain and run the available WCAG 2.2 AA scan. Check the domain-wide/page coverage in the selected service plan. Follow any ownership-verification steps shown by the service.
5. Include the home page, `/book-now` both with and without selected dates, all gallery pages, `/floorplan`, `/instructions`, `/your-hosts`, `/wineries`, `/team-bonding`, game pages and retreat pages. Supply the sitemap if the service supports it. A single home-page scan does not cover the site.
6. Review all failures and manual-review items, correct them, and rerun the scan. Save the dated report, tested URLs and deployed revision. Use interactive testing, where available, for open menus, photo viewers, validation errors, date changes and terms dialogs.

The [AccessibilityChecker homepage](https://www.accessibilitychecker.org/) also offers a public scan entry point. The account-registration link itself does not produce a scan result.

## Work still needed before claiming full compliance

- Restore and review the ten game videos referenced under `public/frontend/video`: those files are absent from this checkout and production. Accurate captions, transcripts and descriptions cannot be authored or verified without the source media. Review the linked YouTube instruction/tour videos for accurate captions and descriptions as well. Do not rely on an automated scan to establish media accessibility.
- Have a person test with a screen reader and keyboard, including 200% text enlargement, 400% zoom/reflow, error recovery and the complete booking flow in Stripe test mode. Check image-description accuracy and the meaning conveyed by the floor-plan descriptions.
- Verify the live Stripe and reCAPTCHA interfaces and the token-protected card-update flow. Protected card-update messaging was improved, but that flow was not scanned with a real booking token. Admin/authenticated pages were outside the public-page scan.
- Review every `incomplete` item in the axe reports. Zero automatically detected violations does not resolve those items.

The technical reference is the [W3C WCAG overview](https://www.w3.org/WAI/standards-guidelines/wcag/) and its linked success criteria.
