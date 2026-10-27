const fs=require('fs');
const batchPath='docs/pinterest/batch-2026-10-27.json';
if(!fs.existsSync(batchPath)){
 const posts=['012','013'].map(id=>{
  const m=JSON.parse(fs.readFileSync(`docs/pinterest/prepared/pin-${id}/metadata.json`,'utf8'));
  if(m.status!=='prepared'||m.published_url)throw Error('Already posted: '+id);
  if(id==='013')m.description=m.description.replace('Picture your next luxury villa rental in Southern California?','Picture your next luxury villa rental in Southern California.');
  return {...m,board:m.board_recommendation,owner_review_status:'publication_authorized_2026-10-27',verified:false};
 });
 fs.writeFileSync(batchPath,JSON.stringify({date:'2026-10-27',timezone:'Asia/Karachi',new_pin_ids:['012','013'],authorization:'Owner requested publishing the next two Pins on 2026-10-27.',posts},null,2)+'\n');
}
let actions=fs.readFileSync('tmp/pinterest-live-actions.cjs','utf8');
actions=actions.replace("!['008','009','010','011'].includes(p.id)","!['012','013'].includes(p.id)");
actions=actions.replace("path.join(root,'docs','pinterest','samples')+path.sep","path.join(root,'docs','pinterest','prepared','pin-'+p.id)+path.sep");
actions=actions.replaceAll("'2026-10-25'","'2026-10-27'");
fs.writeFileSync('tmp/pinterest-live-actions.cjs',actions);
let driver=fs.readFileSync('tmp/pinterest-browser-live.cjs','utf8').replace('batch-2026-10-25.json','batch-2026-10-27.json');
fs.writeFileSync('tmp/pinterest-browser-live.cjs',driver);
console.log('Prepared authorized Oct27 batch and guarded driver for012/013.');
