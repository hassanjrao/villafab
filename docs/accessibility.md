# Accessibility changes and deployment checks

The public Laravel frontend has been updated toward WCAG 2.2 AA. Automated results are evidence of the tested states, not proof of complete WCAG conformance or ADA compliance. The production site has not been deployed or scanned through AccessibilityChecker during this task.

## Results — 11 October 2026

| Check | Result |
| --- | --- |
| Desktop public-page scan | 50 rendered page states; zero axe violations or browser script errors |
| Mobile scan at 375 × 812 | Seven representative page states; zero axe violations or browser script errors |
| Interactive browser checks | Seven keyboard/behavior checks passed; four open-dialog/menu/editor states had zero axe violations |
| Laravel smoke tests | Two tests passed |
| Blade compilation and JavaScript syntax | Passed |

The desktop scan includes 49 public routes plus booking with selected dates. The interactive date-editor audit also identified and corrected unnamed calendar month controls and weekday contrast. Its final check passed after those corrections.

## Changes

- Added a keyboard skip link, main landmark, named navigation and current-page announcements.
- Added visible focus outlines, reduced-motion support and stopped automatic carousel playback.
- Corrected contrast, link underlines, heading structure, image descriptions and icon-only link names.
- Made photo tiles keyboard operable. Photo viewers announce their image and position, contain focus, isolate the background and restore focus when closed. Nested photo viewers close independently of the parent photo tour.
- Added native date fields alongside the visual calendar on the home and booking pages. Dates still pass through the existing server availability and price checks. Stale home-page quotes cannot enable booking for a superseded date selection.
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

The scanner runs axe-core rules tagged WCAG A/AA through 2.2, plus best-practice checks. It also records browser script errors and rules requiring manual review. Reports are written to `storage/app/accessibility/axe-report.json`, `axe-mobile-report.json` and `keyboard-report.json`. Local static assets are served directly from `public` by the test harness, avoiding the PHP development server's single-request queue. Missing assets receive a 404; no replacement images or artificial alt text are injected by the tests. Payment-intent requests are blocked. Keyboard tests mock one availability response to verify date handling without creating a reservation.

## AccessibilityChecker after deployment

1. Deploy the changed Blade views, `public/frontend/style.css`, and the JavaScript in `public/frontend/js`. Clear or rebuild Laravel's compiled views with `php artisan view:clear` or `php artisan view:cache`. Purge any CDN/page cache so the scanner receives the updated pages.
2. Verify the deployed public URL is reachable without a login. Confirm the updated skip link, focus outlines and native date controls appear.
3. Open the [AccessibilityChecker link supplied for this task](https://www.accessibilitychecker.org/sign-up/?sign_action=checkout&redirect_to=https%3A%2F%2Fwww.accessibilitychecker.org%2Fmembership-account%2Fdomains%2F%23show-buy-subscription-popup). It opens an account-registration page. Use your existing account or complete registration yourself; no account or subscription was created during this task.
4. Add `https://www.villafabulosa.com` as the domain and run the available WCAG 2.2 AA scan. Check the domain-wide/page coverage in the selected service plan. Follow any ownership-verification steps shown by the service.
5. Include the home page, `/book-now` both with and without selected dates, all gallery pages, `/floorplan`, `/instructions`, `/your-hosts`, `/wineries`, `/team-bonding`, game pages and retreat pages. Supply the sitemap if the service supports it. A single home-page scan does not cover the site.
6. Review all failures and manual-review items, correct them, and rerun the scan. Save the dated report, tested URLs and deployed revision. Use interactive testing, where available, for open menus, photo viewers, validation errors, date changes and terms dialogs.

The [AccessibilityChecker homepage](https://www.accessibilitychecker.org/) also offers a public scan entry point. The account-registration link itself does not produce a scan result.

## Work still needed before claiming full compliance

- Restore and review the ten game videos referenced under `public/frontend/video`: those files are absent from this checkout. Accurate captions, transcripts and descriptions cannot be authored or verified without the source media. Review the linked YouTube instruction/tour videos for accurate captions and descriptions as well. Do not rely on an automated scan to establish media accessibility.
- Have a person test with a screen reader and keyboard, including 200% text enlargement, 400% zoom/reflow, error recovery and the complete booking flow in Stripe test mode. Check image-description accuracy and the meaning conveyed by the floor-plan descriptions.
- Verify the live Stripe and reCAPTCHA interfaces and the token-protected card-update flow. Protected card-update messaging was improved, but that flow was not scanned with a real booking token. Admin/authenticated pages were outside the public-page scan.
- Review every `incomplete` item in the axe reports. Zero automatically detected violations does not resolve those items.

The technical reference is the [W3C WCAG overview](https://www.w3.org/WAI/standards-guidelines/wcag/) and its linked success criteria.
