const fs=require('fs'),path=require('path');
const root=path.resolve(__dirname,'..'),planPath=path.join(root,'docs/pinterest/board-schedule-plan-2026-10-27.json');
module.exports=async(session,c)=>{
 const page=session.page,plan=JSON.parse(fs.readFileSync(planPath,'utf8'));
 const localToday=()=>new Intl.DateTimeFormat('en-CA',{timeZone:plan.timezone,year:'numeric',month:'2-digit',day:'2-digit'}).format(new Date());
 if(c.action==='scheduleReconcilePublic'){
  const urls={'014':'https://www.pinterest.com/pin/743868063501327808/','064':'https://www.pinterest.com/pin/743868063501330490/'};
  const item=plan.pins.find(x=>x.id===c.id);if(!urls[c.id]||!item?.saved_schedule_verified||new Date(item.saved_publication_utc)>new Date())throw Error('Not an observed due scheduled Pin');
  await page.goto(urls[c.id],{waitUntil:'domcontentloaded'});
  await page.getByRole('button',{name:'More actions',exact:true}).first().waitFor({state:'visible',timeout:25000});
  const body=await page.locator('body').innerText(),images=await page.locator('img').evaluateAll(els=>els.map(e=>({alt:e.alt,src:e.src})).filter(x=>x.src.includes('pinimg')));
  const screenshot=path.join(__dirname,'pinterest-public-'+c.id+'-oct28.png');await page.screenshot({path:screenshot,fullPage:false});
  await page.getByRole('button',{name:'More actions',exact:true}).first().click();await page.getByRole('menuitem',{name:'Edit Pin',exact:true}).click();
  const dialog=page.getByRole('dialog').filter({has:page.locator('#TitleField')});await dialog.waitFor({state:'visible',timeout:25000});await dialog.getByText(item.planned_board,{exact:true}).waitFor({state:'visible'});
  const fields={title:await dialog.locator('#TitleField').inputValue(),description:(await dialog.locator('[contenteditable="true"][role="combobox"]').innerText()).trim(),destination:await dialog.locator('#WebsiteField').inputValue(),board:item.planned_board,manualAI:await dialog.locator('#edit-pin-ai-disclosure-switch-standard,#edit-pin-ai-disclosure-switch-idea').first().isChecked(),alt_text:await dialog.locator('#AltTextField').count()?await dialog.locator('#AltTextField').inputValue():null,ad_only:await dialog.locator('#ads-only-pin-status-switch').count()?await dialog.locator('#ads-only-pin-status-switch').isChecked():null};
  if(fields.title!==item.title||fields.description!==item.description||fields.destination!==item.destination||fields.manualAI||(fields.alt_text!==null&&fields.alt_text!==item.alt_text)||fields.ad_only===true)throw Error('Published saved fields mismatch');
  const cancel=dialog.getByRole('button',{name:'Cancel',exact:true});if(await cancel.count())await cancel.click();else await dialog.getByRole('button',{name:'Dismiss button',exact:true}).click();
  Object.assign(item,{platform_schedule_state:'published_reconciled',published_url:urls[c.id],posted_date:'2026-10-28',live_verified:true,public_verified_at:new Date().toISOString(),published_saved_fields:fields,public_ai_badge:/AI[- ]modified/i.test(body)?'AI-modified':'not_observed',posted_date_basis:'Observed public on 2026-10-28 after the native scheduled slot; exact actual publication timestamp is not exposed.',public_image_observed:true,public_image_visual_review_pending:true});
  fs.writeFileSync(planPath,JSON.stringify(plan,null,2)+'\n');
  return {id:item.id,published_url:item.published_url,posted_date:item.posted_date,fields,images,public_ai_badge:item.public_ai_badge,screenshot,body:body.slice(0,6000)};
 }
 if(c.action==='scheduleVerifyPublic'){
  // Generic read-only check of a due scheduled Pin at an explicitly observed public URL.
  // It never saves the editor and never writes the plan; record results separately.
  const item=plan.pins.find(x=>x.id===c.id),url=String(c.url||'');
  if(!/^https:\/\/www\.pinterest\.com\/pin\/\d+\/$/.test(url))throw Error('Observed public Pin URL required');
  if(!item?.saved_schedule_verified||item.published_url||new Date(item.saved_publication_utc)>new Date())throw Error('Not an unrecorded due scheduled Pin');
  if(plan.pins.some(x=>x.published_url===url))throw Error('Public URL already assigned to another Pin');
  await page.goto(url,{waitUntil:'domcontentloaded'});await page.reload({waitUntil:'domcontentloaded'});
  await page.getByRole('button',{name:'More actions',exact:true}).first().waitFor({state:'visible',timeout:25000});await page.waitForTimeout(1200);
  const body=await page.locator('body').innerText(),images=await page.locator('img').evaluateAll(els=>els.map(e=>({alt:e.alt,src:e.src})).filter(x=>x.src.includes('pinimg')));
  const screenshot=path.join(__dirname,'pinterest-public-'+c.id+'-'+localToday()+'.png');await page.screenshot({path:screenshot,fullPage:false});
  await page.getByRole('button',{name:'More actions',exact:true}).first().click();await page.getByRole('menuitem',{name:'Edit Pin',exact:true}).click();
  const dialog=page.getByRole('dialog').filter({has:page.locator('#TitleField')});await dialog.waitFor({state:'visible',timeout:25000});await page.waitForTimeout(800);
  const dialogText=await dialog.innerText();
  const fields={title:await dialog.locator('#TitleField').inputValue(),description:(await dialog.locator('[contenteditable="true"][role="combobox"]').innerText()).trim(),destination:await dialog.locator('#WebsiteField').inputValue(),board_shown:dialogText.includes(item.planned_board)?item.planned_board:null,manualAI:await dialog.locator('#edit-pin-ai-disclosure-switch-standard,#edit-pin-ai-disclosure-switch-idea').first().isChecked(),alt_text:await dialog.locator('#AltTextField').count()?await dialog.locator('#AltTextField').inputValue():null,ad_only:await dialog.locator('#ads-only-pin-status-switch').count()?await dialog.locator('#ads-only-pin-status-switch').isChecked():null};
  const cancel=dialog.getByRole('button',{name:'Cancel',exact:true});if(await cancel.count())await cancel.click();else await dialog.getByRole('button',{name:'Dismiss button',exact:true}).click();
  const checks={title:fields.title===item.title,description:fields.description===item.description,destination:fields.destination===item.destination,board:fields.board_shown===item.planned_board,manualAI_off:fields.manualAI===false,alt_text:fields.alt_text===null?'not_exposed':fields.alt_text===item.alt_text,ad_only_off:fields.ad_only===null?'not_exposed':fields.ad_only===false};
  return {readOnly:true,id:item.id,url,match:Object.values(checks).every(v=>v===true||v==='not_exposed'),checks,fields,public_ai_badge:/AI[- ]modified/i.test(body)?'AI-modified':'not_observed',images,screenshot,body:body.slice(0,3000)};
 }
 if(c.action==='scheduleReadProfile'){
  await page.goto('https://www.pinterest.com/VillaFabulosa/',{waitUntil:'domcontentloaded'});
  await page.locator('a[href*="/pin/"]').first().waitFor({state:'visible',timeout:25000});await page.waitForTimeout(1000);
  return {readOnly:true,url:page.url(),text:(await page.locator('body').innerText()).slice(0,16000),links:await page.locator('a').evaluateAll(els=>els.filter(e=>/\/pin\/|created|saved/.test(e.href)).map(e=>({href:e.href,text:e.innerText,aria:e.getAttribute('aria-label'),images:[...e.querySelectorAll('img')].map(i=>i.alt)})).slice(0,70))};
 }
 if(c.action==='scheduleReadQueue'){
  await page.goto('https://www.pinterest.com/VillaFabulosa/scheduled-pins/',{waitUntil:'domcontentloaded'});
  await page.getByText('Scheduled Pins',{exact:true}).first().waitFor({state:'visible',timeout:25000});
  await page.waitForTimeout(1200);
  return {readOnly:true,url:page.url(),timezone:await page.evaluate(()=>Intl.DateTimeFormat().resolvedOptions().timeZone),text:await page.locator('body').innerText(),cards:await page.locator('a[href*="/scheduled-pin/"]').evaluateAll(els=>els.map(e=>({href:e.href,text:e.innerText})))};
 }
 const p=plan.pins.find(p=>p.id===c.id);
 if(!p||!(plan.schedule_policy.active_scheduling_ids||plan.schedule_order.slice(0,10)).includes(p.id)||session.scheduleDraftId!==p.id||session.uploadedId!==p.id)throw Error('No matching authorized scheduled draft');
 const b=plan.boards.find(b=>b.id===p.planned_board_id);
 if(c.action==='scheduleInspectQueue'){
  await page.goto('https://www.pinterest.com/VillaFabulosa/scheduled-pins/',{waitUntil:'domcontentloaded'});
  await page.locator('a[href*="/scheduled-pin/"]').first().waitFor({state:'visible',timeout:25000});
  return {id:p.id,text:(await page.locator('body').innerText()).slice(0,10000),controls:await page.locator('button,[role="button"],a[href*="/scheduled-pin/"]').evaluateAll(els=>els.map(e=>({tag:e.tagName,role:e.getAttribute('role'),name:e.getAttribute('aria-label'),text:e.innerText,href:e.href,html:e.outerHTML.slice(0,800)})).slice(0,90))};
 }
 if(c.action==='scheduleOpenSaved'){
  const links=await page.locator('a[href*="/scheduled-pin/"]').evaluateAll(els=>els.map(e=>({href:e.href,text:e.innerText})));
  const matches=links.filter(x=>x.text.includes(p.title)&&x.text.includes(b.name));
  if(matches.length!==1)throw Error('Scheduled queue card not unique');
  session.scheduleSavedPreview=matches[0].href;
  await page.goto(matches[0].href,{waitUntil:'domcontentloaded'});await page.waitForTimeout(1200);
  return {id:p.id,url:page.url(),text:(await page.locator('body').innerText()).slice(0,11000),controls:await page.locator('button,input,textarea,[role="button"]').evaluateAll(els=>els.map(e=>({tag:e.tagName,role:e.getAttribute('role'),name:e.getAttribute('aria-label'),text:e.innerText,id:e.id,value:e.value})).slice(0,80))};
 }
 if(c.action==='scheduleInspectSaved')return {id:p.id,url:page.url(),text:(await page.locator('body').innerText()).slice(0,11000),controls:await page.locator('button,input,textarea,[role="button"]').evaluateAll(els=>els.map(e=>({tag:e.tagName,role:e.getAttribute('role'),name:e.getAttribute('aria-label'),text:e.innerText,id:e.id,value:e.value})).slice(0,90))};
 if(c.action==='scheduleOpenSavedMenu'){
  await page.getByRole('button',{name:'More',exact:true}).click();
  return {id:p.id,text:(await page.locator('body').innerText()).slice(0,8500),items:await page.getByRole('menuitem').allTextContents()};
 }
 if(c.action==='scheduleQueueActions'){
  const card=page.locator('a[href*="/scheduled-pin/"]').filter({hasText:p.title});
  if(await card.count()!==1)throw Error('Not one matching card');
  await card.getByRole('button',{name:'Actions',exact:true}).click();
  return {id:p.id,text:(await page.locator('body').innerText()).slice(0,8500),items:await page.getByRole('menuitem').allTextContents()};
 }
 if(c.action==='scheduleVerifySaved'){
  await page.goto('https://www.pinterest.com/VillaFabulosa/scheduled-pins/',{waitUntil:'domcontentloaded'});
  const card=page.locator('a[href*="/scheduled-pin/"]').filter({hasText:p.title});
  await card.waitFor({state:'visible',timeout:25000});
  if(await card.count()!==1)throw Error('Not one matching saved scheduled card');
  const queueText=await card.innerText(),preview=await card.getAttribute('href');
  const [date,time]=p.planned_publication_local.split('T'),[year,month,day]=date.split('-'),hour=Number(time.slice(0,2));
  const d={date:`${month}/${day}/${year}`,time:`${String(hour%12||12).padStart(2,'0')}:${time.slice(3,5)} ${hour<12?'AM':'PM'}`};
  // The queue shows unpadded days (e.g. "Wed, 11/4"); match the card's date token exactly.
  const shownDate=queueText.match(/\b(\d{1,2})\/(\d{1,2})\b/);
  if(!queueText.includes(b.name)||!queueText.includes(d.time)||!shownDate||Number(shownDate[1])!==Number(month)||Number(shownDate[2])!==Number(day))throw Error('Saved queue fields differ');
  const previewUrl=new URL(preview,'https://www.pinterest.com').href;
  await page.goto(previewUrl,{waitUntil:'domcontentloaded'});
  await page.getByText(p.title,{exact:true}).first().waitFor({state:'visible',timeout:25000});
  const fields=await page.locator('a').evaluateAll(els=>els.map(e=>({text:e.innerText,href:e.href})));
  const body=await page.locator('body').innerText();
  const visit=fields.filter(a=>a.text.trim().startsWith('Visit'));
  const images=await page.locator('img').evaluateAll(els=>els.map(e=>({alt:e.alt,src:e.src})).filter(e=>e.src.includes('pinimg')));
  const zone=await page.evaluate(()=>Intl.DateTimeFormat().resolvedOptions().timeZone);
  if(!body.includes(p.title)||!body.includes(p.description)||visit.length!==1||visit[0].href!==p.destination||zone!==plan.timezone)throw Error('Saved preview copy/link/timezone differs');
  const nativeId=previewUrl.match(/\/scheduled-pin\/(\d+)\//)?.[1];if(!nativeId)throw Error('No native schedule ID');
  const existing=plan.pins.filter(x=>x.id!==p.id&&x.scheduled_pin_id===nativeId);if(existing.length)throw Error('Duplicate native ID');
  Object.assign(p,{platform_schedule_state:'scheduled_verified',scheduled_pin_id:nativeId,scheduled_preview_url:previewUrl,scheduled_in_pinterest_at:new Date().toISOString(),saved_schedule_verified:true,schedule_verified_date:localToday(),saved_publication_local:p.planned_publication_local,saved_publication_utc:p.planned_publication_utc,saved_schedule_fields:{title:p.title,description:p.description,destination:visit[0].href,board:b.name,date:d.date,time:d.time,timezone:zone},saved_schedule_queue_text:queueText,schedule_verification_scope:{reloaded_saved_fields:['title','description','destination','board','date','time'],pre_submission_only:['alt_text','manualAI','person','adOnly'],unavailable_in_saved_ui:['alt_text','manualAI','person','adOnly'],image:'original asset uploaded and queue preview visually present; saved image not replaceable'}});
  fs.writeFileSync(planPath,JSON.stringify(plan,null,2)+'\n');
  session.scheduleDraftId=null;session.scheduleDraft=null;session.draftId=null;session.uploadedId=null;session.scheduleSavedPreview=null;
  return {id:p.id,verified:true,nativeId,previewUrl,queueText,fields:p.saved_schedule_fields,verification_scope:p.schedule_verification_scope};
 }
 const dateField=()=>page.locator('input[id^="pin-draft-schedule-date-field-"]');
 const timeField=()=>page.locator('input[id^="pin-draft-schedule-time-field-"]');
 const caption=()=>page.locator('[contenteditable="true"][role="combobox"]').first();
 const desired=()=>{const [date,time]=p.planned_publication_local.split('T');const [year,month,day]=date.split('-');const hour=Number(time.slice(0,2)),minute=time.slice(3,5);return {date:`${month}/${day}/${year}`,time:`${String(hour%12||12).padStart(2,'0')}:${minute} ${hour<12?'AM':'PM'}`};};
 const readDraft=async()=>({title:await page.locator('textarea[id^="pin-draft-title-"]').inputValue(),description:(await caption().innerText()).trim(),destination:await page.locator('textarea[id^="pin-draft-link-"]').inputValue(),alt_text:await page.locator('textarea[id^="pin-draft-alttext-"]').inputValue(),board:await page.locator('[data-test-id="board-dropdown-select-button"]').innerText(),date:await dateField().inputValue(),time:await timeField().inputValue(),scheduled:await page.getByRole('radio',{name:'Publish at a later date',exact:true}).isChecked(),manualAI:await page.getByRole('checkbox',{name:/Mark as AI-Modified/}).isChecked(),person:await page.getByRole('checkbox',{name:'This Pin includes an AI-generated person',exact:true}).isChecked(),adOnly:await page.locator('input[id$="--ads-only-pin-switch"]').isChecked()});
 const checkDraft=async()=>{const f=await readDraft(),d=desired();const checks={title:f.title===p.title,description:f.description===p.description,destination:f.destination===p.destination,alt_text:f.alt_text===p.alt_text,board:f.board===b.name,date:f.date===d.date,time:f.time.toUpperCase()===d.time.toUpperCase(),scheduled:f.scheduled,manualAI:!f.manualAI,person:!f.person,adOnly:!f.adOnly,image:session.uploadedId===p.id};return {id:p.id,match:Object.values(checks).every(Boolean),checks,fields:f};};
 if(c.action==='scheduleInspectControls'){
  const d=page.locator('input[id^="pin-draft-schedule-date-field-"]');
  return {dateMarkup:await d.evaluate(e=>e.parentElement.parentElement.outerHTML),dateValue:await d.inputValue(),dateVisible:await d.isVisible()};
 }
 if(c.action==='scheduleConfigure'){
  if(!b?.public||b.creation_status!=='created_verified_public')throw Error('Public board not verified');
  const zone=await page.evaluate(()=>Intl.DateTimeFormat().resolvedOptions().timeZone);
  if(zone!==plan.timezone)throw Error('Browser/plan timezone differ; convert explicitly before continuing');
  if(new Date(p.planned_publication_local).toISOString()!==p.planned_publication_utc||new Date(p.planned_publication_utc)<=new Date())throw Error('Invalid or past planned instant');
  const select=page.locator('[data-test-id="board-dropdown-select-button"]');
  if(await select.innerText()!==b.name){
   await select.click();
   await page.getByRole('dialog',{name:'Popover',exact:true}).getByText(b.name,{exact:true}).click();
  }
  const d=desired();await dateField().fill(d.date);await dateField().press('Tab');await timeField().click();await page.getByRole('menuitem',{name:d.time,exact:true}).click();
  await page.locator('textarea[id^="pin-draft-title-"]').fill(p.title);await page.locator('textarea[id^="pin-draft-title-"]').press('Tab');
  await page.locator('textarea[id^="pin-draft-link-"]').fill(p.destination);await page.locator('textarea[id^="pin-draft-link-"]').press('Tab');
  await caption().click();await page.keyboard.press('ControlOrMeta+A');await page.keyboard.press('Backspace');await page.keyboard.insertText(p.description);await page.keyboard.press('Tab');
  const check=await checkDraft();if(!check.match)return check;
  session.scheduleDraft.stage='configured_unsent';plan.schedule_policy.browser_timezone=zone;plan.schedule_policy.browser_locale=await page.evaluate(()=>Intl.DateTimeFormat().resolvedOptions().locale);fs.writeFileSync(planPath,JSON.stringify(plan,null,2)+'\n');
  return {...check,submitted:false,timezone:zone,utc:p.planned_publication_utc};
 }
 if(c.action==='scheduleCheckDraft')return await checkDraft();
 if(c.action==='scheduleSubmit'){
  if(p.platform_schedule_state!=='planned_not_submitted'||p.saved_schedule_verified||p.scheduled_pin_id||session.scheduleDraft?.submitted||session.scheduleDraft?.stage!=='configured_unsent')throw Error('Already attempted or unconfigured; inspect existing outcome');
  const validation=await checkDraft();if(!validation.match)return validation;
  p.platform_schedule_state='submitted_pending_verification';p.schedule_submission_date=localToday();p.submitted_schedule_fields=validation.fields;session.scheduleDraft.submitted=true;
  fs.writeFileSync(planPath,JSON.stringify(plan,null,2)+'\n');
  await page.locator('[data-test-id="board-dropdown-save-button"]').click();
  await page.getByRole('dialog').first().waitFor({state:'visible',timeout:30000}).catch(()=>{});
  await page.waitForTimeout(1200);
  return {id:p.id,attempted:true,url:page.url(),text:(await page.locator('body').innerText()).slice(-6500),dialogs:await page.getByRole('dialog').allTextContents(),links:await page.locator('a[href*="/pin/"]').evaluateAll(els=>els.map(e=>({text:e.innerText,aria:e.getAttribute('aria-label'),href:e.href})).slice(0,30))};
 }
 if(c.action==='scheduleOpenQueue'){
  const dialog=page.getByRole('dialog',{name:'Your scheduled pin.',exact:true});
  await dialog.waitFor({state:'visible'});const text=await dialog.innerText();
  if(!text.includes('Pin Scheduled')||!text.includes(desired().time))throw Error('Expected native schedule confirmation missing');
  p.schedule_confirmation_text=text;p.platform_schedule_state='scheduled_pending_readback';fs.writeFileSync(planPath,JSON.stringify(plan,null,2)+'\n');
  await dialog.getByText('See Scheduled Pins',{exact:true}).click();
  await page.waitForTimeout(1600);
  return {id:p.id,url:page.url(),text:(await page.locator('body').innerText()).slice(0,6500),links:await page.locator('a').evaluateAll(els=>els.filter(e=>/pin|schedul/i.test((e.href||'')+' '+e.innerText)).map(e=>({href:e.href,text:e.innerText,aria:e.getAttribute('aria-label')})).slice(0,35))};
 }
 throw Error('Unknown schedule finalization action');
};
