const {spawn}=require('child_process');
const fs=require('fs'),path=require('path');
const root=path.resolve(__dirname,'..'),file=path.join(root,'docs/pinterest/board-schedule-plan-2026-10-27.json');
function call(action,id){return new Promise((resolve,reject)=>{const c=spawn(process.execPath,[path.join(__dirname,'pinterest-live-client.cjs'),action,id],{cwd:root,windowsHide:true});let out='',err='';c.stdout.on('data',x=>out+=x);c.stderr.on('data',x=>err+=x);c.on('error',reject);c.on('close',code=>{try{const r=JSON.parse(out.trim());if(code||r.error||r.match===false)throw Error(JSON.stringify(r));resolve(r);}catch(e){reject(Error(action+' '+id+': '+e.message+' '+err));}});});}
(async()=>{
 const plan=JSON.parse(fs.readFileSync(file));
 for(const id of (plan.schedule_policy.active_scheduling_ids||plan.schedule_order.slice(0,10))){
  const p=JSON.parse(fs.readFileSync(file)).pins.find(p=>p.id===id);
  if(p.saved_schedule_verified){console.log(JSON.stringify({id,skip:'saved verified'}));continue;}
  if(p.platform_schedule_state!=='planned_not_submitted')throw Error('An unresolved attempt requires inspection for '+id);
  const actions=process.argv[2]===id?['scheduleConfigure','scheduleSubmit','scheduleOpenQueue','scheduleVerifySaved']:['scheduleOpenDraft','scheduleConfigure','scheduleSubmit','scheduleOpenQueue','scheduleVerifySaved'];
  for(const action of actions){
   const r=await call(action,id);
   console.log(JSON.stringify({id,action,ok:true,verified:r.verified,nativeId:r.nativeId}));
  }
 }
 console.log(JSON.stringify({completed:true,count:JSON.parse(fs.readFileSync(file)).pins.filter(p=>p.saved_schedule_verified).length}));
})().catch(e=>{console.error(e.message);process.exitCode=1;});
