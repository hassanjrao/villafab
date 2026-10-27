// Isolated Pinterest browser for the 2026-10-25 batch. Uses a fresh dedicated profile
// (passed as argv[2], outside the repo); the owner signs in manually. Nothing is copied
// from the owner's Chrome. A localhost-only endpoint runs driver snippets against `page`.
const { chromium } = require('../node_modules/playwright');
const http = require('http');
const profile = process.argv[2];
if (!profile) throw new Error('Pass a dedicated profile directory.');
(async () => {
  const context = await chromium.launchPersistentContext(profile, { channel: 'chrome', headless: false, viewport: { width: 1365, height: 950 } });
  let page = context.pages()[0] || await context.newPage();
  await page.goto('https://www.pinterest.com/login/', { waitUntil: 'domcontentloaded', timeout: 60000 });
  const AsyncFunction = Object.getPrototypeOf(async () => {}).constructor;
  http.createServer((req, res) => {
    let body = '';
    req.on('data', c => body += c);
    req.on('end', async () => {
      try {
        if (page.isClosed()) page = context.pages()[0] || await context.newPage();
        const result = await new AsyncFunction('page', 'context', body)(page, context);
        res.end(JSON.stringify({ ok: true, result }, null, 1));
      } catch (e) { res.end(JSON.stringify({ ok: false, error: String(e && e.message || e) })); }
    });
  }).listen(47815, '127.0.0.1', () => console.log('ready on 127.0.0.1:47815'));
  context.on('close', () => process.exit(0));
})().catch(e => { console.error(e); process.exit(1); });
