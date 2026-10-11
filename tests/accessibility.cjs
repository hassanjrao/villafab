const { chromium } = require('playwright');
const fs = require('fs');
const path = require('path');

(async () => {
    const browser = await chromium.launch({ executablePath: process.env.CHROME_PATH || 'C:/Program Files/Google/Chrome/Application/chrome.exe', headless: true });
    const page = await browser.newPage();
    await require('./accessibility-browser.cjs')(page);
    const base = process.env.ACCESSIBILITY_BASE_URL || 'http://127.0.0.1:8099';
    const live = !['127.0.0.1', 'localhost', '[::1]'].includes(new URL(base).hostname);
    const args = process.argv.slice(2);
    const mobile = args.includes('--mobile');
    if (mobile) await page.setViewportSize({ width: 375, height: 812 });
    const allRoutes = Array.from(fs.readFileSync(path.join(__dirname, '../routes/web.php'), 'utf8').matchAll(/Route::get\('([^']+)', \[FrontendController::class/g), m => m[1]);
    const routeArgs = args.filter(arg => !arg.startsWith('--'));
    const routes = args.includes('--all') ? allRoutes.concat('/book-now?checkin=2026-11-20&checkout=2026-11-24&guests=2') : routeArgs.length ? routeArgs : ['/'];
    const results = [];
    for (const route of routes) {
        const errors = [];
        const resourceFailures = [];
        const listener = error => errors.push(error.message);
        const failureListener = request => {
            const url = new URL(request.url());
            if (url.pathname === '/g/collect') return;
            resourceFailures.push({ host: url.hostname, path: url.pathname, error: request.failure().errorText });
        };
        page.on('pageerror', listener);
        page.on('requestfailed', failureListener);
        const response = await page.goto(base + route, { waitUntil: 'domcontentloaded', timeout: 60000 });
        await page.waitForTimeout(1500);
        await page.addScriptTag({ path: require.resolve('axe-core/axe.min.js') });
        const audit = await page.evaluate(async () => {
            const result = await axe.run(document, { runOnly: { type: 'tag', values: ['wcag2a', 'wcag2aa', 'wcag21a', 'wcag21aa', 'wcag22aa', 'best-practice'] } });
            return {
                violations: result.violations.map(v => ({ id: v.id, impact: v.impact, nodes: v.nodes.map(n => ({ target: n.target, summary: n.failureSummary })) })),
                incomplete: result.incomplete.map(v => ({ id: v.id, count: v.nodes.length })),
                passes: result.passes.length
            };
        });
        results.push({ route, status: response.status(), errors, resourceFailures, ...audit });
        console.log(route, response.status(), audit.violations.length ? JSON.stringify(audit.violations) : errors.length ? 'SCRIPT ERRORS: ' + JSON.stringify(errors) : 'PASS');
        page.off('pageerror', listener);
        page.off('requestfailed', failureListener);
    }
    fs.mkdirSync(path.join(__dirname, '../storage/app/accessibility'), { recursive: true });
    fs.writeFileSync(path.join(__dirname, '../storage/app/accessibility/' + (live ? 'live-' : '') + (mobile ? 'axe-mobile-report.json' : 'axe-report.json')), JSON.stringify({ generated: new Date().toISOString(), base, assetSource: live ? 'live server' : 'local checkout', viewport: mobile ? '375 x 812' : '1280 x 720', results }, null, 2));
    await browser.close();
    if (results.some(r => r.status !== 200 || r.violations.length || r.errors.length)) process.exitCode = 1;
})();
