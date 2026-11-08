const fs = require('fs');
const path = require('path');

const root = path.resolve(__dirname, '..');
const planPath = path.join(root, 'docs/pinterest/board-schedule-plan-2026-10-27.json');

module.exports = async function scheduleActions(session, c) {
  if(c.action!=='scheduleOpenDraft') {
    delete require.cache[require.resolve('./pinterest-schedule-finalize.cjs')];
    return await require('./pinterest-schedule-finalize.cjs')(session,c);
  }
  if (c.action !== 'scheduleOpenDraft') throw Error('Unknown scheduling action; submission is unavailable');
  const page = session.page;
  if (!page || page.isClosed()) throw Error('Dedicated Pinterest page is unavailable');
  if (!/^https:\/\/(?:www\.)?pinterest\.com\//.test(page.url())) throw Error('Open the signed-in Pinterest page first');

  const plan = JSON.parse(fs.readFileSync(planPath, 'utf8'));
  if (plan.plan_date !== '2026-10-27' || !Array.isArray(plan.schedule_order)) throw Error('Unexpected scheduling plan');
  const authorized = plan.schedule_policy.active_scheduling_ids || plan.schedule_order.slice(0, 10);
  if (new Set(authorized).size !== authorized.length || !authorized.includes(c.id)) throw Error('Pin is outside the bounded active scheduling batch');
  const p = plan.pins.find(item => item.id === c.id);
  if (!p || p.current_status_at_plan !== 'prepared' || p.published_url || p.posted_date || p.saved_schedule_verified || p.scheduled_pin_id || p.scheduled_in_pinterest_at || p.platform_schedule_state !== 'planned_not_submitted') {
    throw Error('Published, previously attempted, or already scheduled Pin blocked; inspect saved state first');
  }
  if (session.draftId || session.scheduleDraftId || session.scheduleDraft || session.uploadedId || session.publishAttempted) {
    throw Error('A dedicated draft or previous publication attempt already exists; inspect it instead of creating a duplicate');
  }
  if (/\/(?:pin-builder|pin-creation-tool|pidea-pin-builder)\//.test(page.url())) throw Error('A creator may already contain a draft; inspect before opening another');
  await page.goto('https://www.pinterest.com/VillaFabulosa/scheduled-pins/',{waitUntil:'domcontentloaded'});
  await page.getByText('Scheduled Pins',{exact:true}).first().waitFor({state:'visible',timeout:25000});await page.waitForTimeout(1000);
  const queue=await page.locator('a[href*="/scheduled-pin/"]').evaluateAll(els=>els.map(e=>e.href));
  if(queue.length>=10)throw Error('Native future queue is full; nothing uploaded');
  if(queue.some(url=>!plan.pins.some(x=>x.scheduled_preview_url===url&&x.saved_schedule_verified&&!x.published_url)))throw Error('Live queue contains an unreconciled item; inspect before uploading');

  const folder = path.join(root, 'docs', 'pinterest', 'prepared', 'pin-' + p.id);
  const image = path.resolve(root, p.image);
  if (path.dirname(image) !== folder || path.basename(image) !== 'pin-' + p.id + '.png' || fs.realpathSync(image) !== image || !fs.statSync(image).isFile()) {
    throw Error('Unexpected approved image path');
  }
  const metadata = JSON.parse(fs.readFileSync(path.join(folder, 'metadata.json'), 'utf8'));
  if (metadata.id !== p.id || metadata.status !== 'prepared' || metadata.published_url || metadata.posted_date || metadata.live_verified || metadata.scheduled_date) {
    throw Error('Prepared metadata indicates an existing publication/schedule or unexpected status');
  }
  for (const field of ['title', 'description', 'alt_text', 'destination', 'image']) {
    if (!p[field] || metadata[field] !== p[field]) throw Error('Plan and prepared metadata differ: ' + field);
  }
  const destination = new URL(p.destination);
  if (destination.origin !== 'https://villafabulosa.com' || destination.searchParams.get('utm_content') !== 'pin_' + p.id) throw Error('Unexpected tracking destination');
  if (p.title.length > 100 || p.description.length < 100 || p.description.length > 500) throw Error('Prepared copy is outside Pinterest length limits');

  // Retain an in-memory attempt guard before navigation. Never persist a scheduled
  // status here: this action only prepares an unsent native creator form.
  session.scheduleDraftId = p.id;
  session.scheduleDraft = { id: p.id, stage: 'opening', submitted: false };
  session.draftId = p.id;
  session.uploadedId = null;
  const deadline = Date.now() + 48000;
  const timeout = (maximum = 8000) => {
    const remaining = deadline - Date.now() - 200;
    if (remaining < 500) throw Error('Draft preparation time guard reached; inspect the existing draft instead of retrying');
    return Math.min(maximum, remaining);
  };
  page.setDefaultTimeout(8000);

  await page.goto('https://www.pinterest.com/pin-builder/', { waitUntil: 'domcontentloaded', timeout: timeout(30000) });
  if (!page.url().includes('/pin-builder/')) throw Error('Regular organic Pin builder was not loaded; nothing submitted');
  const upload = page.locator('input[type="file"]').first();
  await upload.waitFor({ state: 'attached', timeout: timeout(12000) });
  await upload.setInputFiles(image, { timeout: timeout(12000) });
  session.uploadedId = p.id;
  session.scheduleDraft.stage = 'uploaded';
  await page.waitForTimeout(1200);

  const title = page.locator('textarea[id^="pin-draft-title-"]');
  const link = page.locator('textarea[id^="pin-draft-link-"]');
  const alt = page.locator('textarea[id^="pin-draft-alttext-"]');
  const description = page.locator('[contenteditable="true"][role="combobox"]').first();
  const manualAI = page.getByRole('checkbox', { name: /Mark as AI-Modified/ });
  const person = page.getByRole('checkbox', { name: 'This Pin includes an AI-generated person', exact: true });
  const adOnly = page.locator('input[id$="--ads-only-pin-switch"]');
  const scheduled = page.getByRole('radio', { name: 'Publish at a later date', exact: true });

  await title.waitFor({ state: 'visible', timeout: timeout(12000) });
  await title.fill(p.title, { timeout: timeout() });
  await title.press('Tab', { timeout: timeout() });
  await link.fill(p.destination, { timeout: timeout() });
  await link.press('Tab', { timeout: timeout() });
  await manualAI.setChecked(false, { timeout: timeout() });
  await person.setChecked(false, { timeout: timeout() });
  await adOnly.setChecked(false, { timeout: timeout() });
  if (!await alt.isVisible()) await page.getByRole('button', { name: 'Add alt text', exact: true }).click({ timeout: timeout() });
  await alt.fill(p.alt_text, { timeout: timeout() });
  await alt.press('Tab', { timeout: timeout() });
  await scheduled.check({ timeout: timeout() });

  // Caption is the final field edit. Native replacement avoids Pinterest's
  // contenteditable append/truncation behavior observed in earlier batches.
  await description.waitFor({state:'visible',timeout:timeout(8000)}).catch(()=>{});
  if (!await description.count()) await page.getByRole('button', { name: /^Description/ }).first().click({ timeout: timeout() });
  await description.click({ timeout: timeout() });
  timeout();
  await page.keyboard.press('ControlOrMeta+A');
  await page.keyboard.press('Backspace');
  await page.keyboard.insertText(p.description);
  await page.keyboard.press('Tab');

  const fields = {
    title: await title.inputValue({ timeout: timeout() }),
    description: (await description.innerText({ timeout: timeout() })).trim(),
    destination: await link.inputValue({ timeout: timeout() }),
    alt_text: await alt.inputValue({ timeout: timeout() }),
    manualAI: await manualAI.isChecked({ timeout: timeout() }),
    person: await person.isChecked({ timeout: timeout() }),
    adOnly: await adOnly.isChecked({ timeout: timeout() }),
    scheduled: await scheduled.isChecked({ timeout: timeout() }),
    board: await page.locator('[data-test-id="board-dropdown-select-button"]').innerText({ timeout: timeout() })
  };
  const checks = {
    title: fields.title === p.title,
    description: fields.description === p.description,
    destination: fields.destination === p.destination,
    alt_text: fields.alt_text === p.alt_text,
    manualAI: !fields.manualAI,
    person: !fields.person,
    adOnly: !fields.adOnly,
    scheduled: fields.scheduled,
    image: session.uploadedId === p.id
  };
  if (!Object.values(checks).every(Boolean)) throw Error('Prepared draft readback did not match; nothing submitted: ' + JSON.stringify(checks));
  session.scheduleDraft.stage = 'prepared_unsent';
  const visibleControls = await page.locator('input,textarea,select,[role="combobox"]').evaluateAll(elements => elements.filter(element => {
    const rectangle = element.getBoundingClientRect();
    const style = getComputedStyle(element);
    return rectangle.width > 0 && rectangle.height > 0 && style.visibility !== 'hidden' && style.display !== 'none';
  }).map(element => ({
    tag: element.tagName,
    type: element.getAttribute('type'),
    id: element.id,
    name: element.getAttribute('name'),
    role: element.getAttribute('role'),
    label: element.getAttribute('aria-label') || Array.from(element.labels || []).map(label => label.innerText).join(' '),
    placeholder: element.getAttribute('placeholder'),
    value: typeof element.value === 'string' ? element.value : element.innerText,
    checked: typeof element.checked === 'boolean' ? element.checked : null,
    min: element.getAttribute('min'), max: element.getAttribute('max'), step: element.getAttribute('step'),
    readOnly: element.readOnly || false,
    testId: element.getAttribute('data-test-id')
  })));
  const browser = await page.evaluate(() => ({
    timezone: Intl.DateTimeFormat().resolvedOptions().timeZone,
    locale: Intl.DateTimeFormat().resolvedOptions().locale,
    language: navigator.language,
    offsetMinutes: new Date().getTimezoneOffset(),
    localNow: new Date().toString(),
    utcNow: new Date().toISOString()
  }));
  return {
    id: p.id, url: page.url(), draftPrepared: true, submitted: false,
    boardSelectedByThisAction: false, plannedBoard: p.planned_board,
    plannedPublicationLocal: p.planned_publication_local,
    plannedPublicationUTC: p.planned_publication_utc,
    fields, checks, visibleControls, browser,
    text: (await page.locator('body').innerText({ timeout: timeout() })).slice(-7000)
  };
};
