# Accessibility changes and deployment checks

The public Laravel frontend has been updated toward WCAG 2.2 AA and deployed to https://villafabulosa.com through the requested Git push/pull workflow. Automated results are evidence of the tested states, not proof of complete WCAG conformance or ADA compliance. The supplied AccessibilityChecker signup link opens an account flow; its separate public scanner supports individual pages. Post-deployment account scan instructions are below.

## Pa11y CI review — 13 October 2026

The locally installed Pa11y CI 5.0.0 with Pa11y 10.0.0 ran both HTML_CodeSniffer and axe against all 54 requested live URLs on desktop and mobile, using `WCAG2AA`. Warnings and notices were included; no accessibility rule was disabled. The full first run is retained, with targeted genuine repeats for changed pages and failed loads. These reports contain issue counts rather than a numeric compliance score.

HTML_CodeSniffer identified image-only winery links whose images had empty alternatives, a password label pointing to the wrong input ID, and the existing hidden calendar input without a name. The 55 linked winery images now carry their links' meaningful destination names, the password label targets `login-password`, and the existing calendar input has `aria-label="Selected booking dates"`. No new fields were added. Revision `8edfd383e87818b4e89a81b5b312f4e3d288cd53` was pushed, pulled into production and compiled with `php artisan view:cache`.

The [separate public Pa11y JSON report](https://villafabulosa.com/accessibility/reports/2026-10-13/villa-fabulosa-pa11y.json) preserves every issue's severity, rule, message, selector and manual-review flag. It excludes HTML snippets, private filesystem paths and payment-test data. An axe item marked `needsFurtherReview` retains its original reported severity and is counted separately from a confirmed error. Warnings and notices remain for assessment; zero confirmed errors does not settle them. The broad scans block form submissions and payment-intent creation, so the initialized Stripe iframe remains covered by the separate direct test below.

The latest merged observations cover 108 states, all HTTP 200 with no browser script errors and zero confirmed errors. The report retains 768 warnings, 11,572 notices and 24 axe manual-review items. Its source-run metadata distinguishes the original full scan, the 14-state targeted repeat and the one additional booking-page load repeat. The two initial mobile connection closures and subsequent 90-second navigation timeout are retained; genuine repeats passed rather than treating those missing audits as successes.

Reproduce with Node.js compatible with the installed Pa11y CI version and Chrome:

```powershell
node tests/pa11y-accessibility.cjs tests/pa11y-configs/villa-fabulosa.json
node tests/pa11y-accessibility.cjs tests/pa11y-configs/modern-luxury-builders.json
node tests/pa11y-accessibility.cjs tests/pa11y-configs/villa-magnifica.json
```

The harness uses the installed `pa11y-ci` JavaScript API with its matching Puppeteer dependency. Set `PA11Y_CI_PATH` to the installed package directory when it differs from `C:/nvm4w/nodejs/node_modules/pa11y-ci`, or `CHROME_PATH` to select another Chrome executable. Reports are written to the ignored output directories specified in each configuration. `node tests/export-pa11y-results.cjs` regenerates the dated public export from the original completed runs and targeted rechecks, rather than running new tests.

## Booking controls — 13 October 2026

Removed the added “Enter dates directly” fieldsets from the home booking widget and booking date editor at the owner's request. The original visual calendars remain, with date buttons supporting keyboard activation, arrow movement within the displayed months, Escape, and focus restoration. Existing minimum-stay, booked-date and server quote checks remain in place. No additional form fields were introduced.

The current review covers every public content route, booking with selected dates, the booking result page and the public login page. Lighthouse accessibility scores are measured separately from AccessibilityChecker's proprietary score; neither score establishes full legal compliance. Use the account's authorized scan allowance for AccessibilityChecker, without bypassing its scan limits.

| Live check, 13 October | Result |
| --- | --- |
| Lighthouse 13.5.0 desktop | All 54 requested URLs/states scored 100/100, HTTP 200, no failed accessibility audits or load warnings |
| Lighthouse 13.5.0 mobile | All 54 requested URLs/states scored 100/100, HTTP 200, no failed accessibility audits or load warnings |
| Final desktop axe | All 53 URLs/states passed, no violations or browser errors |
| Verified mobile axe | All 53 URLs/states passed after a booking-page network-failure recheck |
| Live keyboard and interactive states | Seven behavior checks and four open-state axe audits passed |

Application changes were deployed through Git push/pull at `616eeb8286000177173cb95d2859c202fa8bda96` and `f0e61bb7f762dbdf88ebbe888f6f7e65dfc5bab6`, with Blade views recompiled. The added native date controls are absent from production. The login/result main headings, login-footer contrast and malformed winery address link were corrected. Unused CKEditor samples are no longer served (the live host returns 404); functional editor preview assets remain HTTP 200.

The mobile run initially recorded `ERR_CONNECTION_RESET` for Bootstrap on `/book-now`, causing two initialization errors. Its targeted axe repeat and three independent browser loads passed with Bootstrap present. The initial 53-state report and clean repeat are retained, with per-row sources recorded in `storage/app/accessibility/oct13-verified-axe-mobile-summary.json`. Final desktop evidence is `oct13-final-desktop-report.json`. Missing game-video requests and caption-review items remain unresolved; this is not a resource-completeness or media-accessibility certification.

Full local Lighthouse evidence is in `storage/app/accessibility/oct13-fabulosa-lighthouse/` and `oct13-fabulosa-lighthouse-mobile/`. After the Stripe configuration deployment, all three booking URLs were checked again on desktop/mobile in `oct13-fabulosa-booking-final/`, adding the owner's exact URL to the inventory. All six latest booking audits scored 100, returned HTTP 200 and had no failed accessibility audits or load warnings. The combined [per-page scores for all three sites](live-accessibility-scores.csv) and [public Fabulosa URL list](public-pages.txt) record the latest evidence for each state. The [published CSV](https://villafabulosa.com/accessibility/reports/2026-10-13/live-accessibility-scores.csv) uses public HTTPS links to sanitized per-site summaries; local `storage/app` paths are not public URLs.

## Stripe iframe finding — 13 October 2026

The owner supplied an AccessibilityChecker score of 72/100 for `/book-now?checkin=2026-11-19&checkout=2026-11-22&guests=1`. Its one critical finding was `aria-required-children` at `.p-PaymentMethodSelector[role="tablist"]` inside a private Stripe iframe. Broad scans that block payment-intent creation do not render this initialized iframe and therefore cannot validate it.

Both Payment Element initialization paths now use Stripe's [documented accordion layout](https://docs.stripe.com/payments/payment-element#layout) with `defaultCollapsed: false` and `radios: 'never'`. Application revision `c581b18b4dd0b05b56a33ccccd79ec9bf5ad5526` was pushed, pulled into production and compiled with `php artisan view:cache`. No additional form fields or payment methods were introduced.

Direct checks of the actual initialized live Stripe iframe on the owner's exact URL passed at desktop and mobile sizes: zero automatically detected WCAG A/AA violations and no payment-method tab lists. Axe still recorded manual-review items for `aria-valid-attr-value` (six elements) and `bypass` (one element); zero violations does not resolve those items. The existing five site fields and 16 visible Stripe fields remained unchanged in count. Before the change this browser saw three valid tab children and did not reproduce the service's failure, so the initial problem may depend on timing or Stripe's dynamic method selection. The supported layout change removes the reported tab-list structure instead of altering third-party DOM or suppressing an audit rule.

One unconfirmed initialization intent was reused for the checks and canceled afterward. No card details were entered and no payment was confirmed. Evidence is `storage/app/accessibility/stripe-frame-check/{before,after-desktop,after-mobile}.json` with screenshots. An updated AccessibilityChecker score has not been verified. One normal public-form submission of the exact booking URL stopped in the service's JavaScript with `rudderanalytics is not defined`, after its console reported that bot detection had skipped tracker initialization. There was no audit navigation or score, and no account/quota message. No identity spoofing, IP rotation or quota bypass was attempted. Evidence is `storage/app/accessibility/accessibilitychecker-2026-10-13/booking-exact-submit-once.json` with a screenshot. Rerun the exact URL in a normal browser using the service's authorized allowance.

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

## Lighthouse score reproduction

The 13 October audit uses Lighthouse 13.5.0 with Node.js 22.19 or newer and Chrome. Install the auditor into the ignored tool directory; application packages and lockfiles remain unchanged:

```powershell
npm install --prefix storage/app/accessibility/lighthouse-tools --no-package-lock --no-save lighthouse@13.5.0
node tests/lighthouse-accessibility.cjs storage/app/accessibility/fabulosa-lighthouse-config.json
```

The JSON configuration contains `base`, `routes`, `profiles` (`desktop` and/or `mobile`), `minimum` (90), and `output`. The current full inventory has 54 requested URLs/states: the 49 public frontend routes, two selected-date booking URLs, `/booking/success`, `/login`, and `/index.php`. Use `maxWaitForLoad` for a longer real load when rechecking a loading warning. The runner saves full Lighthouse JSON, a per-page CSV, and an HTML index. It runs the accessibility category without disabling any accessibility audit. Each run starts a fresh Chrome profile, caches assets between pages, and blocks payment-intent submissions and analytics collection. The initialized Stripe iframe is verified separately as described above.

Unused CKEditor demonstration pages under `/js/plugins/ckeditor/samples/` are denied by Apache. Editor assets and functional preview helpers remain available. Demonstrations, JSON APIs, POST actions and authenticated admin routes are not public visitor pages. Token-dependent card updates and real payment confirmations require a controlled booking/payment test session.

## Work still needed before claiming full compliance

- Restore and review the ten game videos referenced under `public/frontend/video`: those files are absent from this checkout and production. Accurate captions, transcripts and descriptions cannot be authored or verified without the source media. Review the linked YouTube instruction/tour videos for accurate captions and descriptions as well. Do not rely on an automated scan to establish media accessibility.
- Have a person test with a screen reader and keyboard, including 200% text enlargement, 400% zoom/reflow, error recovery and the complete booking flow in Stripe test mode. Check image-description accuracy and the meaning conveyed by the floor-plan descriptions.
- Manually verify the live Stripe and reCAPTCHA interfaces and the token-protected card-update flow. Protected card-update messaging was improved, but that flow was not scanned with a real booking token. Admin/authenticated pages were outside the public-page scan.
- Review every `incomplete` item in the axe reports. Zero automatically detected violations does not resolve those items.

The technical reference is the [W3C WCAG overview](https://www.w3.org/WAI/standards-guidelines/wcag/) and its linked success criteria.
