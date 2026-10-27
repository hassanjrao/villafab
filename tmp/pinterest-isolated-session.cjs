const { chromium } = require('../node_modules/playwright');
const fs = require('fs');
const readline = require('readline');
const path = require('path');
let browser, page;
const emit = data => console.log(JSON.stringify(data));
const metadata = () => JSON.parse(fs.readFileSync(path.join(__dirname, '../docs/pinterest/batch-2026-10-19.json'), 'utf8'));
async function inspect() {
  const url = page.url();
  if (!/^https:\/\/(?:www\.)?pinterest\.com\//.test(url)) return { url, status: 'Sign-in page outside Pinterest; complete it manually.' };
  return {
    url, title: await page.title(),
    text: (await page.locator('body').innerText()).slice(0, 6000),
    controls: await page.locator('input,textarea,button,[role="button"],[role="combobox"],[role="dialog"],[role="menuitem"],[role="checkbox"]').evaluateAll(elements => elements.map(e => ({
      tag: e.tagName, role: e.getAttribute('role'), name: e.getAttribute('aria-label'),
      id: e.id, type: e.getAttribute('type'), placeholder: e.getAttribute('placeholder'),
      text: e.tagName === 'BUTTON' || ['button','menuitem','checkbox'].includes(e.getAttribute('role')) ? e.innerText?.slice(0, 100) : undefined,
      testId: e.getAttribute('data-test-id') || e.getAttribute('data-testid'),
    })).slice(0, 100))
  };
}
async function main() {
  browser = await chromium.launch({ channel: 'chrome', headless: false });
  const context = await browser.newContext({ viewport: { width: 1365, height: 950 } });
  page = await context.newPage();
  await page.goto('https://www.pinterest.com/login/', { waitUntil: 'domcontentloaded', timeout: 30000 });
  emit({ event: 'isolated_browser_ready', status: 'Manual Pinterest sign-in required. No login from the existing Chrome profile was copied.' });
  const reader = readline.createInterface({ input: process.stdin, crlfDelay: Infinity });
  for await (const line of reader) {
    if (!line.trim()) continue;
    try {
      const command = JSON.parse(line);
      if (command.action === 'close') { emit({ event: 'closed' }); break; }
      if (command.action === 'status' || command.action === 'inspect') { emit(await inspect()); continue; }
      if (!/^https:\/\/(?:www\.)?pinterest\.com\//.test(page.url())) throw new Error('Complete sign-in before Pinterest automation.');
      if (command.action === 'loadpost') {
        const post = metadata().posts.find(p => p.id === command.id);
        if (!post?.published_url) throw new Error('No recorded published pin for this ID.');
        await page.goto(post.published_url, { waitUntil: 'domcontentloaded', timeout: 30000 });
        await page.waitForTimeout(1500); emit(await inspect());
      } else if (command.action === 'click') {
        const locator = command.selector ? page.locator(command.selector) : page.getByRole(command.role || 'button', { name: command.name, exact: command.exact !== false });
        await locator.first().click({ timeout: 15000 });
        await page.waitForTimeout(command.waitMs ?? 500); emit(await inspect());
      } else if (command.action === 'fillpost') {
        const post = metadata().posts.find(p => p.id === command.id);
        if (!post || !['description','title','destination'].includes(command.field)) throw new Error('Only prepared pin text may be entered.');
        const locator = command.selector ? page.locator(command.selector) : page.getByRole(command.role || 'textbox', { name: command.name, exact: true });
        await locator.fill(post[command.field], { timeout: 15000 }); await locator.press('Tab');
        emit({ event: 'filled', pin: post.id, field: command.field });
      } else if (command.action === 'check') {
        if (command.name !== 'Mark as AI-Modified' || command.checked !== false) throw new Error('Only disabling the manual AI disclosure is permitted.');
        await page.getByRole('checkbox', { name: /Mark as AI-Modified/ }).setChecked(false);
        emit({ event: 'manual_ai_off' });
      } else if (command.action === 'readpost' || command.action === 'verify') {
        const post = metadata().posts.find(p => p.id === command.id);
        if (!post) throw new Error('Unknown pin ID.');
        const dialog = page.getByRole('dialog', { name: 'Edit Pin details', exact: true });
        const fields = await dialog.locator('input,textarea,[contenteditable="true"],[role="combobox"],[role="checkbox"]').evaluateAll(elements => elements.map(e => ({
          tag: e.tagName, role: e.getAttribute('role'), type: e.getAttribute('type'), id: e.id,
          name: e.getAttribute('aria-label'), placeholder: e.getAttribute('placeholder'),
          value: e.value ?? e.innerText, checked: e.checked ?? e.getAttribute('aria-checked')
        })));
        const values = fields.map(f => f.value);
        const checks = { title: values.includes(post.title), description: values.includes(post.description), destination: values.includes(post.destination) };
        const ai = dialog.getByRole('checkbox', { name: /Mark as AI-Modified/ });
        const manualAI = await ai.isChecked();
        const match = Object.values(checks).every(Boolean) && !manualAI;
        if (command.action === 'verify' && match) {
          const data = metadata(); const saved = data.posts.find(p => p.id === command.id);
          saved.verified = true; saved.manual_ai_disclosure = false;
          saved.tag_update_status = 'verified'; saved.verification_date = '2026-10-19';
          if (typeof command.publicAILabel === 'boolean') saved.public_ai_label_present = command.publicAILabel;
          fs.writeFileSync(path.join(__dirname, '../docs/pinterest/batch-2026-10-19.json'), JSON.stringify(data, null, 2) + '\n', 'utf8');
        }
        emit({ event: command.action, id: post.id, match, checks, manualAI, fields });
      } else if (command.action === 'reload') {
        await page.reload({ waitUntil: 'domcontentloaded', timeout: 30000 }); await page.waitForTimeout(1500); emit(await inspect());
      } else throw new Error('Unknown action.');
    } catch (error) { emit({ error: error.message }); }
  }
}
main().catch(error => { emit({ error: error.message }); process.exitCode = 1; }).finally(async () => { if (browser) await browser.close(); });
