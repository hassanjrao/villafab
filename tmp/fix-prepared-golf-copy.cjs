const fs=require('fs');
const base='docs/pinterest/prepared';
const old="The property's miniature golf greens and flags, surrounded by white courtyard walls and the actual estate landscape.";
const correct="Elevated view of individual green miniature-golf lanes on gray gravel, edged by dry grass, trees and surrounding hills.";
const manifest=JSON.parse(fs.readFileSync(base+'/manifest.json','utf8'));
const fixed=[];
for(const p of manifest.pins.filter(p=>p.source_family===4)){
 const folder=base+'/pin-'+p.id;
 p.alt_text=p.alt_text.replace(old,correct);
 const m=JSON.parse(fs.readFileSync(folder+'/metadata.json','utf8'));m.alt_text=m.alt_text.replace(old,correct);
 fs.writeFileSync(folder+'/metadata.json',JSON.stringify(m,null,2)+'\n');
 for(const f of ['prompt.txt','posting.md'])fs.writeFileSync(folder+'/'+f,fs.readFileSync(folder+'/'+f,'utf8').replace(old,correct));
 fixed.push(p.id);
}
fs.writeFileSync(base+'/manifest.json',JSON.stringify(manifest,null,2)+'\n');
console.log(fixed);
