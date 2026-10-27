const fs=require('fs'); const path=require('path'); const root=path.resolve(__dirname,'..');
const file=path.join(root,'docs/pinterest/batch-2026-10-25.json');
const old=fs.existsSync(file)?JSON.parse(fs.readFileSync(file,'utf8')):null;
if(old?.posts.some(p=>p.published_url)) throw Error('Existing publication found: reconcile before preparing a replacement batch.');
const archive=file.replace('.json','-superseded-prepared.json');
if(old&&!fs.existsSync(archive)) fs.copyFileSync(file,archive);
const plans=[
 {id:'008',keyword:'group vacation rentals',target_location:'Southern California',title:'Group Vacation Rentals in Southern California | Villa Fabulosa',description:'Bring your group together at Villa Fabulosa in Temecula Wine Country. Unwind on the covered patio beside the fire table, with the pool and outdoor spaces close by. Explore this Southern California estate and check availability at VillaFabulosa.com. #TemeculaWineCountry #GroupGetaway #OutdoorLiving',hashtags:['#TemeculaWineCountry','#GroupGetaway','#OutdoorLiving']},
 {id:'009',keyword:'luxury holiday rentals',target_location:'Temecula Wine Country',title:'Luxury Holiday Rentals in Temecula Wine Country | Villa Fabulosa',description:'Make time to unwind at Villa Fabulosa in Temecula Wine Country. Discover inviting bedrooms, comfortable gathering spaces and a private setting for your next holiday together. View the villa and check availability at VillaFabulosa.com. #TemeculaWineCountry #LuxuryHoliday #VillaStay',hashtags:['#TemeculaWineCountry','#LuxuryHoliday','#VillaStay']},
 {id:'010',keyword:'large house to rent',target_location:'Riverside County',title:'Large House to Rent in Riverside County | Villa Fabulosa',description:'Looking for a large house to rent in Riverside County? Villa Fabulosa in Temecula offers space to share meals and spend time together, with indoor dining opening toward the outdoor living area. Explore the property and check availability at VillaFabulosa.com. #RiversideCounty #GroupVacation #TemeculaWineCountry',hashtags:['#RiversideCounty','#GroupVacation','#TemeculaWineCountry']},
 {id:'011',keyword:'luxury villa holidays',target_location:'Orange County (travelers from; property in Temecula)',title:'Luxury Villa Holidays | Temecula Escape from Orange County | Villa Fabulosa',description:'Plan a Temecula Wine Country escape from Orange County at Villa Fabulosa. Take in the courtyard, blue-lit pool and surrounding hills from this private estate setting. Explore the villa and check availability for your next stay at VillaFabulosa.com. #TemeculaWineCountry #VillaHoliday #OrangeCountyGetaway',hashtags:['#TemeculaWineCountry','#VillaHoliday','#OrangeCountyGetaway']}
];
const posts=plans.map(p=>{
 const creative=JSON.parse(fs.readFileSync(path.join(root,`docs/pinterest/samples/pin-${p.id}.json`),'utf8'));
 if(p.title.length>100||p.description.length>500||p.description.length<100||!creative.alt_text||!fs.existsSync(path.join(root,creative.image))) throw Error('Invalid creative/copy '+p.id);
 return {...creative,...p,board:'Top Vacation Rental in Temecula Wine Country',destination:`https://villafabulosa.com/?utm_source=pinterest&utm_medium=organic_social&utm_campaign=villa_fabulosa_75_pins&utm_content=pin_${p.id}`,published_url:'',posted_date:'',status:'prepared',verified:false,manual_ai_disclosure:false,requested_manual_ai_disclosure:false,tag_update_status:'prepared',topic_tags:[]};
});
fs.writeFileSync(file,JSON.stringify({date:'2026-10-25',timezone:'Asia/Karachi',new_pin_ids:plans.map(p=>p.id),posts},null,2)+'\n','utf8');
console.log(JSON.stringify(posts.map(p=>({id:p.id,image:p.image,titleLength:p.title.length,descriptionLength:p.description.length}))));
