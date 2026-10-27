const fs=require('fs'); const path=require('path');
module.exports = async function(session, command) {
  let page = session.page;
  if(command.action==='health') return {pageClosed:page.isClosed(),browserConnected:session.context.browser()?.isConnected(),pages:session.context.pages().filter(p=>!p.isClosed()).map(p=>({pinterest:/^https:\/\/(?:www\.)?pinterest\.com\//.test(p.url())}))};
  if(command.action==='recoverPage') {
    if(!session.context.browser()?.isConnected())return {browserClosed:true};
    page=await session.context.newPage();session.page=page;
    await page.goto('https://www.pinterest.com/',{waitUntil:'domcontentloaded'});
    return {url:page.url(),restored:true};
  }
  if(command.action==='activateOct27Batch') {
    const batchPath=path.resolve(__dirname,'../docs/pinterest/batch-2026-10-27.json');
    const batch=JSON.parse(fs.readFileSync(batchPath,'utf8'));
    if(batch.date!=='2026-10-27'||batch.posts.map(p=>p.id).join(',')!=='012,013')throw Error('Batch scope mismatch');
    session.batchPath=batchPath;session.draftId=null;session.uploadedId=null;session.publishAttempted=null;
    return {batchDate:batch.date,authorizedIds:batch.posts.map(p=>p.id)};
  }
  page.setDefaultTimeout(12000);
  if (command.action === 'close') { session.closed = true; return { closed: true }; }
  const url = page.url();
  if (!/^https:\/\/(?:www\.)?pinterest\.com\//.test(url)) return { url, needsManualSignIn: true };
  const data=()=>JSON.parse(fs.readFileSync(session.batchPath,'utf8'));
  const post=()=>{const p=data().posts.find(p=>p.id===command.id);if(!p||!['012','013'].includes(p.id))throw Error('Unknown authorized pin ID');return p;};
  const save=record=>{const d=data();Object.assign(d.posts.find(p=>p.id===record.id),record);fs.writeFileSync(session.batchPath,JSON.stringify(d,null,2)+'\n','utf8');};
  const description=()=>page.locator('[contenteditable="true"][role="combobox"]').first();
  const classic=()=>page.url().includes('/pin-builder/');
  const titleField=()=>page.locator(classic()?'textarea[id^="pin-draft-title-"]':'#storyboard-selector-title');
  const linkField=()=>page.locator(classic()?'textarea[id^="pin-draft-link-"]':'#WebsiteField');
  const altField=()=>classic()?page.locator('textarea[id^="pin-draft-alttext-"]'):page.getByRole('textbox',{name:'Alt Text',exact:true});
  const draftFields=async()=>({title:await titleField().inputValue(),description:(await description().innerText()).trim(),destination:await linkField().inputValue(),alt_text:await altField().inputValue(),manualAI:await page.getByRole('checkbox',{name:/Mark as AI-Modified/}).isChecked(),person:await page.getByRole('checkbox',{name:'This Pin includes an AI-generated person',exact:true}).isChecked(),scheduled:classic()?await page.getByRole('radio',{name:'Publish at a later date',exact:true}).isChecked():await page.getByRole('checkbox',{name:'Publish at a later date',exact:true}).isChecked(),adOnly:classic()?await page.locator('input[id$="--ads-only-pin-switch"]').isChecked():false,board:await page.locator('[data-test-id="board-dropdown-select-button"]').innerText()});
  const check=async()=>{const p=post();const f=await draftFields();const checks={title:f.title===p.title,description:f.description===p.description,destination:f.destination===p.destination,alt_text:f.alt_text===p.alt_text,manualAI:!f.manualAI,person:!f.person,scheduled:!f.scheduled,adOnly:!f.adOnly,board:f.board.includes(p.board),image:session.uploadedId===p.id};return {id:p.id,match:Object.values(checks).every(Boolean),checks,fields:f};};
  if(command.action==='openCreator'){
    const p=post();if(p.published_url)throw Error('Published URL already recorded; duplicate blocked');
    if(page.url().includes('/pin-creation-tool/'))throw Error('A draft is already open; finish it before opening another');
    if(session.draftId)throw Error('Finish the current dedicated draft first');
    await page.goto('https://www.pinterest.com/pin-builder/',{waitUntil:'domcontentloaded'});
    await page.locator('input[type="file"]').first().waitFor({state:'attached'});session.draftId=p.id;session.uploadedId=null;session.currentAlt='';
    return {id:p.id,url:page.url(),draftOpened:true};
  }
  if(command.action==='upload'){
    const p=post();if(p.published_url||session.draftId!==p.id)throw Error('Draft mismatch or already published');
    const root=path.resolve(__dirname,'..');const image=path.resolve(root,p.image);
    if(!image.startsWith(path.join(root,'docs','pinterest','prepared','pin-'+p.id)+path.sep)||!image.endsWith('.png'))throw Error('Unexpected upload path');
    await page.locator(classic()?'input[type="file"]':'#storyboard-upload-input').first().setInputFiles(image);
    await page.waitForTimeout(1200);
    session.uploadedId=p.id;return {id:p.id,image:p.image,uploaded:true};
  }
  if(command.action==='fillDraft'){
    const p=post();if(session.draftId!==p.id||session.uploadedId!==p.id)throw Error('Upload first');
    await titleField().fill(p.title);await linkField().fill(p.destination);await linkField().press('Tab');
    if(!await description().count())await page.getByRole('button',{name:/^Description/}).first().click();
    await description().click();await page.keyboard.press('ControlOrMeta+A');await page.keyboard.press('Backspace');await page.keyboard.insertText(p.description);await page.keyboard.press('Tab');
    const actual=(await description().innerText()).trim();if(actual!==p.description)throw Error('Caption did not match after native replacement; nothing published');
    return {id:p.id,descriptionExact:true,title:await titleField().inputValue(),destination:await linkField().inputValue()};
  }
  if(command.action==='finishDraft'){
    const p=post();
    for(const name of [/Mark as AI-Modified/,'This Pin includes an AI-generated person'])await page.getByRole('checkbox',{name,exact:typeof name==='string'}).setChecked(false);
    if(classic()){await page.getByRole('radio',{name:'Publish immediately',exact:true}).check();await page.locator('input[id$="--ads-only-pin-switch"]').setChecked(false);}
    else await page.getByRole('checkbox',{name:'Publish at a later date',exact:true}).setChecked(false);
    const alt=altField();
    if(!await alt.isVisible()) { if(classic()) await page.getByRole('button',{name:'Add alt text',exact:true}).click(); else await page.locator('[data-test-id="storyboard-show-more-options-button"]').click(); }
    await alt.fill(p.alt_text);await alt.press('Tab');return await check();
  }
  if(command.action==='checkDraft')return await check();
  if(command.action==='topicSearch'){
    post();await page.locator('#combobox-storyboard-interest-tags').fill(command.query||'Vacation');
    await page.waitForTimeout(600);return {suggestions:await page.getByRole('option').allTextContents(),text:(await page.locator('body').innerText()).slice(-2000)};
  }
  if(command.action==='recordTopic'){
    const p=post();const body=await page.locator('body').innerText();if(!command.topic||!body.includes(command.topic))throw Error('Topic not visible in form');
    save({id:p.id,topic_tags:[command.topic],topic_edit_status:'Selected in creation form; subsequent saved-state readback pending'});return {id:p.id,topic:command.topic};
  }
  if(command.action==='publish'){
    const p=post();if(p.published_url)throw Error('Already published; duplicate blocked');const validation=await check();if(!validation.match)return validation;
    if(session.publishAttempted===p.id)throw Error('A publication was already attempted. Inspect its outcome instead of retrying.');
    session.publishAttempted=p.id;
    if(classic()){
      await page.locator('[data-test-id="board-dropdown-save-button"]').click();
      const confirmation=page.getByRole('dialog',{name:'Your saved Pin.',exact:true});
      await confirmation.waitFor({state:'visible',timeout:40000});
      const created=confirmation.getByRole('link',{name:'See your Pin',exact:true});
      const href=await created.getAttribute('href');
      const confirmedUrl=new URL(href,'https://www.pinterest.com').href;
      if(/^https:\/\/www\.pinterest\.com\/pin\/[0-9]+\/$/.test(confirmedUrl)){
        save({id:p.id,published_url:confirmedUrl,posted_date:'2026-10-27',status:'published'});
        session.draftId=null;session.uploadedId=null;await page.goto(confirmedUrl,{waitUntil:'domcontentloaded'});
        return {id:p.id,publicationConfirmed:true,url:confirmedUrl};
      }
      const current=page.url();
      if(/^https:\/\/www\.pinterest\.com\/pin\/[0-9]+\/$/.test(current)){
        save({id:p.id,published_url:current,posted_date:'2026-10-27',status:'published'});session.draftId=null;session.uploadedId=null;
        return {id:p.id,publicationConfirmed:true,url:current};
      }
      return {id:p.id,publicationAttempted:true,url:current,text:(await page.locator('body').innerText()).slice(-3500),links:await page.locator('a[href*="/pin/"]').evaluateAll(els=>els.map(e=>({text:e.innerText,label:e.getAttribute('aria-label'),href:e.href})))};
    }
    await page.getByRole('button',{name:'Publish',exact:true}).click();
    await page.getByText('Your Pin has been published!',{exact:true}).waitFor({state:'visible',timeout:20000});
    const link=page.getByRole('link',{name:'Navigate to created Pin',exact:true});
    if(!await link.count())return {id:p.id,publicationConfirmed:true,urlPending:true};
    const href=await link.getAttribute('href');const publicUrl=new URL(href,'https://www.pinterest.com').href;
    if(!/^https:\/\/www\.pinterest\.com\/pin\/[0-9]+\/$/.test(publicUrl))throw Error('Published confirmation URL needs inspection; do not republish');
    save({id:p.id,published_url:publicUrl,posted_date:'2026-10-27',status:'published'});
    await page.goto(publicUrl,{waitUntil:'domcontentloaded'});session.draftId=null;session.uploadedId=null;return {id:p.id,publicationConfirmed:true,url:publicUrl};
  }
  if(command.action==='recordPublication'){
    const p=post();const current=page.url();if(!/^https:\/\/www\.pinterest\.com\/pin\/[0-9]+\/$/.test(current))throw Error('No individual published Pin is open');
    if(!(await page.locator('body').innerText()).includes(p.title))throw Error('The current Pin title does not match');
    if(p.published_url&&p.published_url!==current)throw Error('Conflicting publication URL');
    save({id:p.id,published_url:current,posted_date:'2026-10-27',status:'published'});session.draftId=null;session.uploadedId=null;return {id:p.id,url:current,publicationConfirmed:true};
  }
  if(command.action==='verify'){
    const p=post();if(!p.published_url)throw Error('No recorded publication');
    await page.goto(p.published_url,{waitUntil:'domcontentloaded'});await page.reload({waitUntil:'domcontentloaded'});
    await page.getByRole('button',{name:'More actions',exact:true}).first().waitFor({state:'visible'});
    const badge=await page.getByText('AI modified',{exact:true}).first().waitFor({state:'visible',timeout:8000}).then(()=>true).catch(()=>false);
    await page.getByRole('button',{name:'More actions',exact:true}).first().click();await page.getByRole('menuitem',{name:'Edit Pin',exact:true}).click();
    const dialog=page.getByRole('dialog').filter({has:page.locator('#TitleField')});await dialog.waitFor({state:'visible'});
    await dialog.getByText(p.board,{exact:true}).first().waitFor({state:'visible',timeout:15000}).catch(()=>{});
    const desc=dialog.locator('[contenteditable="true"][role="combobox"]');await desc.waitFor({state:'attached'});
    const hasAlt=await dialog.locator('#AltTextField').count();const hasAdOnly=await dialog.locator('#ads-only-pin-status-switch').count();
    const f={title:await dialog.locator('#TitleField').inputValue(),description:(await desc.innerText()).trim(),destination:await dialog.locator('#WebsiteField').inputValue(),manualAI:await dialog.locator('#edit-pin-ai-disclosure-switch-standard, #edit-pin-ai-disclosure-switch-idea').first().isChecked(),alt_text:hasAlt?await dialog.locator('#AltTextField').inputValue():null,adOnly:hasAdOnly?await dialog.locator('#ads-only-pin-status-switch').isChecked():false,boardMatches:(await dialog.innerText()).includes(p.board)};
    const checks={title:f.title===p.title,description:f.description===p.description,destination:f.destination===p.destination,manualAI:!f.manualAI,alt_text:!hasAlt||f.alt_text===p.alt_text,adOnly:!f.adOnly,board:f.boardMatches};const match=Object.values(checks).every(Boolean);
    if(match)save({id:p.id,verified:true,verification_date:'2026-10-27',verification_fields:['title','description','destination','manual_ai_disclosure','board',...(hasAlt?['alt_text']:[]),...(hasAdOnly?['ad_only']:[])],manual_ai_disclosure:false,ad_only:false,public_ai_label_present:badge,tag_update_status:'verified',alt_text_verification:hasAlt?'Exact saved field checked after full reload':'Exact field checked before publication; not checked after final reload',topic_edit_status:'Native topic selector unavailable in regular Pin builder and Edit Pin; description hashtags saved and verified'});
    const cancel=dialog.getByRole('button',{name:'Cancel',exact:true});
    if(await cancel.count())await cancel.click();else await dialog.getByRole('button',{name:'Dismiss button',exact:true}).click();
    return {id:p.id,match,checks,publicAILabel:badge,fields:f,url:p.published_url,boardDebug:match?undefined:(await page.locator('body').innerText()).slice(-2000)};
  }
  if(command.action==='publicEvidence'){
    const p=post();if(!p.published_url||!p.verified)throw Error('Verify the saved pin first');
    await page.goto(p.published_url,{waitUntil:'domcontentloaded'});
    await page.locator('img[src*="i.pinimg.com"]').first().waitFor({state:'visible'});
    await page.waitForTimeout(1200);
    const screenshot=path.resolve(__dirname,'pinterest-live-pin-'+p.id+'.png');
    await page.screenshot({path:screenshot});
    return {id:p.id,url:page.url(),screenshot,text:(await page.locator('body').innerText()).slice(0,1300)};
  }
  if(command.action==='click'){
    if(/^(Publish|Delete|Create board)$/i.test(command.name||''))throw Error('Use guarded publication; deletion and board creation unavailable');
    const target=command.selector?page.locator(command.selector):page.getByRole(command.role||'button',{name:command.name,exact:command.exact!==false});
    await target.first().click();await page.waitForTimeout(500);return {clicked:command.name||command.selector,url:page.url()};
  }
  if(command.action==='reload'){await page.reload({waitUntil:'domcontentloaded'});return {url:page.url(),reloaded:true};}
  if(command.action!=='inspect')throw Error('Unknown action');
  const text = (await page.locator('body').innerText()).slice(0, 6000);
  if (/\/login\/?|\/signup\/?/.test(url) || /Welcome to Pinterest\n|Log in to see more/.test(text)) return { url, needsManualSignIn: true };
  return { url, title: await page.title(), text: text.slice(0, 3500), controls: await page.locator('input,textarea,button,[role="button"],[role="dialog"],[role="menuitem"],[role="combobox"],[role="checkbox"]').evaluateAll(els => els.map(e => ({tag:e.tagName,role:e.getAttribute('role'),id:e.id,name:e.getAttribute('aria-label'),type:e.getAttribute('type'),placeholder:e.getAttribute('placeholder'),text:e.innerText?.slice(0,90),testId:e.getAttribute('data-test-id')})).slice(0,80)) };
};
