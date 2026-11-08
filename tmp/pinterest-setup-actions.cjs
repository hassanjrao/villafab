const fs=require('fs'),path=require('path');
const root=path.resolve(__dirname,'..');
const planPath=path.join(root,'docs/pinterest/board-schedule-plan-2026-10-27.json');
module.exports=async(session,c)=>{
 const page=session.page;
 const plan=JSON.parse(fs.readFileSync(planPath,'utf8'));
 const board=()=>{const b=plan.boards.find(b=>b.id===c.board);if(!b)throw Error('Unknown authorized board');return b};
 const persist=()=>fs.writeFileSync(planPath,JSON.stringify(plan,null,2)+'\n');
 const settingsDialog=()=>page.getByRole('dialog',{name:'Board form',exact:true});
 const pinDialog=()=>page.getByRole('dialog').filter({has:page.locator('#TitleField')});
 const readPin=async()=>{const d=pinDialog();return {title:await d.locator('#TitleField').inputValue(),description:(await d.locator('[contenteditable="true"][role="combobox"]').innerText()).trim(),destination:await d.locator('#WebsiteField').inputValue(),manualAI:await d.locator('#edit-pin-ai-disclosure-switch-standard,#edit-pin-ai-disclosure-switch-idea').first().isChecked(),alt_text:await d.locator('#AltTextField').count()?await d.locator('#AltTextField').inputValue():null,ad_only:await d.locator('#ads-only-pin-status-switch').count()?await d.locator('#ads-only-pin-status-switch').isChecked():null};};
 const openPin=async p=>{
  await page.goto(p.published_url,{waitUntil:'domcontentloaded'});
  await page.getByRole('button',{name:'More actions',exact:true}).first().waitFor({state:'visible',timeout:20000});
  await page.getByRole('button',{name:'More actions',exact:true}).first().click();await page.getByRole('menuitem',{name:'Edit Pin',exact:true}).click();await pinDialog().waitFor({state:'visible',timeout:25000});
 };
 const movePin=async(p,pickerAlreadyOpen=false)=>{
  const b=plan.boards.find(b=>b.id===p.planned_board_id);if(!b?.public||b.creation_status!=='created_verified_public')throw Error('Target public board not verified');
  if(p.board_operation_status==='moved_and_reload_verified')return {id:p.id,alreadyVerified:true,board:b.name,url:p.published_url};
  if(!pickerAlreadyOpen){await openPin(p);await pinDialog().getByText(p.existing_board,{exact:true}).waitFor({state:'visible',timeout:20000});}
  const before=await readPin();
  if(before.title!==p.title||before.destination!==p.destination)throw Error('Existing Pin identity mismatch');
  if(!pickerAlreadyOpen)await pinDialog().getByText(p.existing_board,{exact:true}).click();
  await pinDialog().locator('[data-test-id="board-selection"]').filter({hasText:b.name}).click();
  await pinDialog().getByText(b.name,{exact:true}).waitFor({state:'visible'});
  if(JSON.stringify(before)!==JSON.stringify(await readPin()))throw Error('Board selection unexpectedly changed copy/settings');
  p.board_operation_status='submitted_pending_verification';p.board_move_before=before;persist();
  await pinDialog().getByRole('button',{name:'Save',exact:true}).click();await pinDialog().waitFor({state:'hidden',timeout:20000});
  await openPin(p);await pinDialog().getByText(b.name,{exact:true}).waitFor({state:'visible',timeout:20000});
  const after=await readPin();if(JSON.stringify(before)!==JSON.stringify(after))throw Error('Saved field changed during board move');
  if(page.url()!==p.published_url)throw Error('Pin URL changed unexpectedly');
  const cancel=pinDialog().getByRole('button',{name:'Cancel',exact:true});if(await cancel.count())await cancel.click();else await pinDialog().getByRole('button',{name:'Dismiss button',exact:true}).click();
  p.board_operation_status='moved_and_reload_verified';p.saved_board=b.name;p.saved_board_url=b.platform_board_url;p.board_verified_date='2026-10-27';p.board_move_saved_fields=after;persist();
  return {id:p.id,board:b.name,url:p.published_url,moved:true,reloadVerified:true,otherFieldsUnchanged:true};
 };
 const openSettings=async()=>{
  await page.getByRole('button',{name:'More Board options',exact:true}).click();
  await page.getByRole('menuitem',{name:'Edit info and settings',exact:true}).click();
  await settingsDialog().waitFor({state:'visible'});
 };
 const saveSettings=async b=>{
  const dialog=settingsDialog();
  if(await dialog.locator('#boardEditName').inputValue()!==b.name)throw Error('Unexpected board in settings');
  await dialog.locator('#boardEditDescription').fill(b.description);
  await dialog.locator('#secret').setChecked(false);
  await dialog.getByRole('button',{name:'Done',exact:true}).click();
  await dialog.waitFor({state:'hidden'});
  await page.reload({waitUntil:'domcontentloaded'});
  await page.getByText(b.name,{exact:true}).first().waitFor({state:'visible',timeout:20000});
  await page.getByRole('button',{name:'View public board information',exact:true}).waitFor({state:'visible'});
  await openSettings();
  const fields={name:await settingsDialog().locator('#boardEditName').inputValue(),description:await settingsDialog().locator('#boardEditDescription').inputValue(),private:await settingsDialog().locator('#secret').isChecked()};
  const match=fields.name===b.name&&fields.description===b.description&&!fields.private;
  await settingsDialog().getByRole('button',{name:'Close',exact:true}).click();
  if(!match)throw Error('Saved board settings did not match');
  b.platform_board_url=page.url();b.creation_status='created_verified_public';b.public=true;b.verified_date='2026-10-27';b.description_saved=fields.description;persist();
  return {id:b.id,name:b.name,url:b.platform_board_url,public:true,descriptionExact:true,verified:true};
 };
 if(c.action==='claimReadback'){
  await page.goto('https://www.pinterest.com/settings/claim/',{waitUntil:'domcontentloaded'});
  await page.getByRole('button',{name:'Unclaim',exact:true}).waitFor({state:'visible',timeout:20000});
  const text=await page.locator('body').innerText();
  if(!text.includes('villafabulosa.com'))throw Error('Expected claimed domain missing');
  return {domain:'villafabulosa.com',claimed:true,reloaded_readback:true,url:page.url()};
 }
 if(c.action==='boardOpenForm'){
  const b=board();
  if(await page.getByText(b.name,{exact:true}).count())return {alreadyVisible:true,name:b.name};
  await page.getByRole('button',{name:'Create board',exact:true}).click();
  const dialog=page.getByRole('dialog');await dialog.waitFor({state:'visible'});
  return {name:b.name,text:await dialog.innerText(),inputs:await dialog.locator('input,textarea,button').evaluateAll(els=>els.map(e=>({tag:e.tagName,id:e.id,type:e.type,name:e.getAttribute('aria-label'),placeholder:e.getAttribute('placeholder'),text:e.innerText})))};
 }
 if(c.action==='boardCreate'){
  const b=board();
  if(b.platform_board_url||b.creation_status==='submitted_pending_verification')throw Error('Creation already attempted; inspect instead of repeating');
  const dialog=page.getByRole('dialog').filter({has:page.locator('#boardEditName')});
  await dialog.locator('#boardEditName').fill(b.name);
  await dialog.locator('#secret').setChecked(false);
  if(await dialog.locator('#boardEditName').inputValue()!==b.name||await dialog.locator('#secret').isChecked())throw Error('Name/privacy mismatch');
  if(await dialog.locator('#CollaboratorInviteSearchField').inputValue()!=='')throw Error('Unexpected collaborator');
  b.creation_status='submitted_pending_verification';plan.status='platform_setup_in_progress';
  fs.writeFileSync(planPath,JSON.stringify(plan,null,2)+'\n');
  await dialog.getByRole('button',{name:'Create',exact:true}).click();
  await dialog.waitFor({state:'hidden',timeout:20000});
  return {name:b.name,submitted:true,url:page.url(),text:(await page.locator('body').innerText()).slice(0,4000)};
 }
 if(c.action==='boardSaveSettings')return await saveSettings(board());
 if(c.action==='boardCreateComplete'){
  const b=board();
  if(b.creation_status==='created_verified_public')return {id:b.id,alreadyVerified:true,url:b.platform_board_url};
  if(b.platform_board_url){await page.goto(b.platform_board_url,{waitUntil:'domcontentloaded'});await page.getByText(b.name,{exact:true}).first().waitFor({state:'visible',timeout:20000});await openSettings();return await saveSettings(b);}
  if(b.creation_status==='submitted_pending_verification')throw Error('Inspect uncertain previous creation before retrying');
  await page.goto('https://www.pinterest.com/VillaFabulosa/_saved/',{waitUntil:'domcontentloaded'});
  await page.getByRole('button',{name:'Create board',exact:true}).waitFor({state:'visible',timeout:20000});
  if(await page.getByText(b.name,{exact:true}).count())throw Error('A board with this exact name already exists; inspect it');
  await page.getByRole('button',{name:'Create board',exact:true}).click();
  const form=page.getByRole('dialog').filter({has:page.locator('#boardEditName')});await form.waitFor({state:'visible'});
  await form.locator('#boardEditName').fill(b.name);await form.locator('#secret').setChecked(false);
  if(await form.locator('#boardEditName').inputValue()!==b.name||await form.locator('#secret').isChecked())throw Error('Create settings mismatch');
  b.creation_status='submitted_pending_verification';persist();
  await form.getByRole('button',{name:'Create',exact:true}).click();await form.waitFor({state:'hidden',timeout:20000});
  await page.getByText(b.name,{exact:true}).first().waitFor({state:'visible',timeout:20000});
  b.platform_board_url=page.url();persist();
  const suggestions=page.getByRole('dialog',{name:'add pins to empty board modal',exact:true});
  if(await suggestions.isVisible())await suggestions.getByRole('button',{name:'Done',exact:true}).click();
  await openSettings();return await saveSettings(b);
 }
 if(c.action==='boardOpenPinEdit'){
  const p=plan.pins.find(p=>p.id===c.id&&p.current_status_at_plan==='published');
  if(!p||!p.published_url)throw Error('Unknown existing campaign Pin');
  await page.goto(p.published_url,{waitUntil:'domcontentloaded'});
  await page.getByRole('button',{name:'More actions',exact:true}).first().waitFor({state:'visible',timeout:20000});
  await page.getByRole('button',{name:'More actions',exact:true}).first().click();
  await page.getByRole('menuitem',{name:'Edit Pin',exact:true}).click();
  const dialog=page.getByRole('dialog').filter({has:page.locator('#TitleField')});await dialog.waitFor({state:'visible'});
  return {id:p.id,url:page.url(),text:await dialog.innerText(),controls:await dialog.locator('input,textarea,button,[role="button"]').evaluateAll(els=>els.map(e=>({tag:e.tagName,id:e.id,role:e.getAttribute('role'),name:e.getAttribute('aria-label'),type:e.type,text:e.innerText?.slice(0,100),testId:e.getAttribute('data-test-id')})))};
 }
 if(c.action==='boardOpenPinPicker'){
  const p=plan.pins.find(p=>p.id===c.id&&p.current_status_at_plan==='published');if(!p)throw Error('Unknown published Pin');
  const dialog=page.getByRole('dialog').filter({has:page.locator('#TitleField')});
  await dialog.getByText(p.existing_board,{exact:true}).waitFor({state:'visible',timeout:20000});
  session.boardMoveBefore={id:p.id,url:page.url(),title:await dialog.locator('#TitleField').inputValue(),description:(await dialog.locator('[contenteditable="true"][role="combobox"]').innerText()).trim(),destination:await dialog.locator('#WebsiteField').inputValue(),manualAI:await dialog.locator('#edit-pin-ai-disclosure-switch-standard,#edit-pin-ai-disclosure-switch-idea').first().isChecked()};
  if(session.boardMoveBefore.title!==p.title||session.boardMoveBefore.destination!==p.destination)throw Error('Current Pin identity fields differ');
  await dialog.getByText(p.existing_board,{exact:true}).click();
  return {id:p.id,before:session.boardMoveBefore,text:(await page.locator('body').innerText()).slice(-6000),controls:await page.locator('[role="option"],[role="dialog"] input, [data-test-id*="board"]').evaluateAll(els=>els.slice(0,35).map(e=>({tag:e.tagName,id:e.id,role:e.getAttribute('role'),text:e.innerText?.slice(0,100),testId:e.getAttribute('data-test-id')})))};
 }
 if(c.action==='boardMovePinComplete'||c.action==='boardMovePinFinish'){
  const p=plan.pins.find(p=>p.id===c.id&&p.current_status_at_plan==='published');if(!p)throw Error('Unknown published campaign Pin');
  return await movePin(p,c.action==='boardMovePinFinish');
 }
 throw Error('Unknown setup action');
};
