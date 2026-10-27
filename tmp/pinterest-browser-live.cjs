const { chromium } = require('../node_modules/playwright');
const fs = require('fs');
const os = require('os');
const path = require('path');
const base = __dirname;
const commandFile = path.join(base, 'pinterest-live-command.json');
const responseFile = path.join(base, 'pinterest-live-response.json');
const actionFile = path.join(base, 'pinterest-live-actions.cjs');
const profile = path.join(os.tmpdir(), 'codex-pinterest-villa-fabulosa-dedicated');
const delay = ms => new Promise(resolve => setTimeout(resolve, ms));
let context;
(async () => {
  context = await chromium.launchPersistentContext(profile, { channel: 'chrome', headless: false, viewport: { width: 1365, height: 950 } });
  const page = context.pages()[0] || await context.newPage();
  await page.goto('https://www.pinterest.com/', { waitUntil: 'domcontentloaded', timeout: 30000 });
  const session = { context, page, draftId: null, uploadedId: null, batchPath: path.resolve(base, '../docs/pinterest/batch-2026-10-27.json') };
  let last = fs.existsSync(commandFile) ? JSON.parse(fs.readFileSync(commandFile, 'utf8')).request_id : null;
  console.log(JSON.stringify({ event: 'browser_ready', url: page.url(), dedicatedProfile: true }));
  while (!session.closed) {
    try {
      if (fs.existsSync(commandFile)) {
        const command = JSON.parse(fs.readFileSync(commandFile, 'utf8'));
        if (command.request_id && command.request_id !== last) {
          last = command.request_id;
          let result;
          try { delete require.cache[require.resolve(actionFile)]; result = await require(actionFile)(session, command); }
          catch (error) { result = { error: error.message, url: page.url() }; }
          const response = { request_id: last, ...result };
          const staging = responseFile + '.new';
          fs.writeFileSync(staging, JSON.stringify(response, null, 2), 'utf8');
          fs.renameSync(staging, responseFile);
          console.log(JSON.stringify({ event: 'command_finished', action: command.action, error: Boolean(result.error) }));
        }
      }
    } catch (error) { console.log(JSON.stringify({ event: 'driver_error', error: error.message })); }
    await delay(100);
  }
})().catch(error => { console.log(JSON.stringify({ error: error.message })); process.exitCode = 1; }).finally(async () => { if (context) await context.close(); });
