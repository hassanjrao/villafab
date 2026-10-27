const fs = require('fs');
const path = require('path');
const base = 'docs/pinterest/prepared';
const keywords = ['luxury villa rental','luxury vacation home rentals','luxury villa vacation rentals','exclusive villa rentals','rent luxury houses','large vacation rental','luxury villa holidays','large family vacation rentals','large group vacation rentals','large house to rent','rent a mansion for a weekend','luxury holiday rentals','private villas to rent','group vacation rentals','large villa holidays'];
const locations = ['Temecula Wine Country','Riverside County','Southern California','Los Angeles','Orange County'];
const used = [[0,0],[1,0],[7,1],[8,2],[12,3],[3,4],[2,0],[13,2],[11,0],[9,1],[6,4]];
const sourceDefs = [
 ['villa-fabulosa-pool-01.webp','pool','The private pool and white courtyard offer an inviting setting for unhurried time together.','Illuminated pool and modern white courtyard at dusk, with lounge seating and surrounding hills.','#PoolsideEscape'],
 ['villa-fabulosa-6-living.webp','living','Settle into the bright living room, with generous seating and space to gather between outings.','Double-height living room with cream sofas, blue cushions, fireplace, accent-lit shelving and a glass-railed upper level.','#GroupGetaway'],
 ['villa-fabulosa-pergola.webp','patio','Enjoy the covered outdoor lounge and space to reconnect in a private estate setting.','Covered outdoor lounge with wicker seating and the actual surrounding courtyard and landscape.','#OutdoorLiving'],
 ['villa-fabulosa-golf-course-11.webp','golf','Make time for a friendly round on the estate\'s miniature golf course during your stay.','The property\'s miniature golf greens and flags, surrounded by white courtyard walls and the actual estate landscape.','#MiniGolf'],
 ['villa-fabulosa-13-14-pool.webp','pool','Picture a relaxed afternoon beside the private pool and its surrounding courtyard.','The property\'s rectangular pool, shallow ledge and lounge chairs beside white estate buildings.','#PoolsideEscape'],
 ['villa-fabulosa-5-arcade.webp','game','Discover the game room for a playful break and time together at the estate.','Game room with the source photograph\'s arcade cabinets and indoor games.','#FamilyGetaway'],
 ['villa-fabulosa-13-13-aerial.webp','aerial','Explore the private estate layout, with outdoor gathering areas and a pool for your group getaway.','Aerial view of the actual white estate, courtyard, pool, outdoor spaces and surrounding hills.','#PrivateEstate'],
 ['villa-fabulosa-23-patio.webp','patio','Unwind in the covered patio lounge, with comfortable seating for conversations after a day out.','Covered patio at dusk with wicker seating and a fire table, with pool and putting green beyond.','#OutdoorLiving'],
 ['villa-fabulosa-54-bedroom.webp','bedroom','Find a comfortable bedroom retreat when it is time to slow down after a day together.','Bedroom with a white bed, navy cover, gray blinds, blue abstract artwork and wood flooring.','#VillaStay'],
 ['villa-fabulosa-13-dining.webp','dining','Share meals around the long dining table, with doors opening toward the outdoor living area.','Double-height dining room with a long glass table, gray chairs, blue napkins and black-framed sliding doors.','#GroupGetaway'],
 ['villa-fabulosa-13-view.webp','view','Take in the courtyard, blue-lit pool and rolling hills from this elevated estate view.','Elevated dusk view of the white courtyard, blue-lit pool, loungers, covered outdoor dining and distant hills.','#WineCountryEscape'],
 ['villa-fabulosa-7-kitchen.webp','kitchen','Gather around the kitchen island and enjoy a welcoming place to prepare and share meals.','Bright white kitchen with gray island, black stools, stainless appliances, marble-look counters and blue ceiling accent lights.','#VacationHome'],
 ['villa-fabulosa-70-bedroom.webp','bedroom','Recharge in an inviting bedroom with courtyard access after a day exploring the area.','Bright bedroom with two white beds and blue covers, colorful paintings, wood floor and glass doors toward the courtyard.','#VillaStay'],
 ['villa-fabulosa-3-field.webp','sports','Enjoy the outdoor recreation spaces, with a sport court and putting greens at the estate.','Outdoor blue multi-use sport court with basketball hoops and net beside putting greens, with distant hills at dusk.','#GroupGetaway'],
 ['villa-fabulosa-13-19-foyer.webp','foyer','Step into a bright, welcoming estate with contemporary interiors and room to spend time together.','White foyer with wood stairs, black glass-panel front door, blue vase, blue rug and colorful wall art.','#PrivateEstate']
];
const bank = ['The Ultimate Group Getaway in Temecula','Spacious Luxury Estate for Large Groups','A Private Stay for Family Reunions & Retreats','Private Estate Designed for Multi-Family Stays','A California Estate Escape','Resort-Style Private Pool & Courtyard','The Ultimate Group Getaway','Luxury Wine Country Estate with Pool & Spa','Imagine yourself here!','Luxury Bedrooms & High-End Amenities','Temecula Wine Country Luxury Escape','Stay in the Heart of SoCal Wine Country','Private Estate in Temecula Wine Country','Scenic Views & Private Estate Luxury','Exclusive Southern California Vacation Home','Explore VillaFabulosa.com for Your Next Stay','Discover Your Stay | VillaFabulosa.com','Plan Your Villa Fabulosa Escape','Luxury Vacation Estate | Direct Booking','Explore Your Next Wine Country Stay'];
const layouts = [
 'Classic editorial: warm ivory upper header, centered serif headline, wide landscape photo panel in the middle, ivory footer and navy CTA with thin gold border.',
 'Photo-forward editorial: compact ivory brand and headline block in upper quarter, large edge-to-edge source photo panel below, narrow ivory location and CTA footer. Keep the entire key scene within the photo.',
 'Framed editorial: warm ivory canvas, fine muted-gold inset frame, generously spaced navy serif headline above a large source photograph with slim ivory margins, centered footer and CTA.',
 'Asymmetric editorial: navy brand line and left-aligned serif headline on ivory above a wide photographic panel, short gold divider, left-aligned location and balanced navy CTA footer. Keep text separate from the photo.',
 'Magazine editorial: warm ivory top brand, large source photograph in the upper-middle, a spacious ivory headline block beneath the photo, thin gold rule and compact navy CTA at the bottom.'
];
const sourceCounts = sourceDefs.map((_,i)=>i<11?1:0);
const perSourceVariants = sourceCounts.slice();
const existing = used.map(([k,l],i)=>({id:String(i+1).padStart(3,'0'),keyword:keywords[k],target_location:locations[l],source:sourceDefs[i][0],status:'published'}));
const titleCase = s=>s.replace(/\b\w/g,c=>c.toUpperCase());
const remaining=[];
for(let k=0;k<keywords.length;k++)for(let l=0;l<locations.length;l++)if(!used.some(x=>x[0]===k&&x[1]===l))remaining.push({k,l});
fs.mkdirSync(base,{recursive:true});
const pins=remaining.map(({k,l},index)=>{
 const id=String(index+12).padStart(3,'0');
 const bankIndex=(index+12)%20;
 let eligible=sourceDefs.map((s,i)=>({s,i,count:sourceCounts[i]})).filter(x=>x.count<5);
 const preferred=bankIndex===5||bankIndex===7?['pool','aerial','view']:bankIndex===9?['bedroom']:bankIndex===13?['view','aerial','sports','pool']:null;
 if(preferred&&eligible.some(x=>preferred.includes(x.s[1])))eligible=eligible.filter(x=>preferred.includes(x.s[1]));
 eligible.sort((a,b)=>a.count-b.count||((a.i-index+150)%15)-((b.i-index+150)%15));
 const si=eligible[0].i;
 const [filename,kind,feature,photoAlt,featureTag]=sourceDefs[si];
 const variant=++perSourceVariants[si]; sourceCounts[si]++;
 let headline=bank[bankIndex],adaptation='';
 if(bankIndex===5&&!['pool','aerial','view'].includes(kind)){headline='Resort-Style Private Estate';adaptation='Pool-specific overlay generalized to match the selected interior/recreation photo.';}
 if(bankIndex===7&&!['pool','aerial','view'].includes(kind)){headline='Luxury Wine Country Estate';adaptation='Amenity-specific overlay generalized to match the selected photo.';}
 if(bankIndex===9&&kind!=='bedroom'){headline='Luxury Interiors & High-End Amenities';adaptation='Bedroom-specific overlay generalized to match the selected photo.';}
 if(bankIndex===13&&!['view','aerial','sports','pool'].includes(kind)){headline='Private Estate Luxury';adaptation='Scenic-view wording generalized to match the selected interior photo.';}
 if([2,4,9,12,15,16,17,19].includes(bankIndex))adaptation += (adaptation?' ':'')+'Original headline bank wording adapted to avoid unsupported event permission, ranking, plural master suites, travel-time, savings, fee or rate guarantees as applicable.';
 const location=locations[l], keyword=keywords[k];
 const title=l<3?`${titleCase(keyword)} in ${location} | Villa Fabulosa`:`${titleCase(keyword)} | Temecula from ${location} | Villa Fabulosa`;
 const searchArea=l===0?'Temecula Wine Country':l===1?'Temecula, Riverside County':l===2?'Southern California':`Temecula Wine Country for a getaway from ${location}`;
 const intros={
  'rent luxury houses':`Looking to rent luxury houses in ${searchArea}? Discover Villa Fabulosa, a private estate for a stay together.`,
  'large house to rent':`Looking for a large house to rent in ${searchArea}? Consider Villa Fabulosa for your next shared escape.`,
  'rent a mansion for a weekend':`Planning to rent a mansion for a weekend in ${searchArea}? Explore Villa Fabulosa's private estate setting and check dates and stay requirements.`,
 };
 const generic=l<3?`Exploring ${keyword} in ${searchArea}? Get to know Villa Fabulosa, one private estate for time together.`:`Exploring ${keyword} for a getaway from ${location}? Discover Villa Fabulosa in Temecula Wine Country.`;
 const locationTag=['#TemeculaWineCountry','#RiversideCounty','#SouthernCalifornia','#LosAngelesGetaway','#OrangeCountyGetaway'][l];
 const hashtags=[locationTag,featureTag, l===0?'#LuxuryVilla':'#TemeculaWineCountry'];
 const description=`${intros[keyword]||generic} ${feature} View the estate and check availability at VillaFabulosa.com. ${hashtags.join(' ')}`;
 if(title.length>100||description.length>500||description.length<100)throw Error(`${id} copy bounds ${title.length}/${description.length}`);
 const source=`public/frontend/imgs/photos-for-vrbo/${filename}`;
 const folder=`${base}/pin-${id}`;
 const fullSource=path.resolve(source).replaceAll('\\','/');
 const fullStyle=path.resolve('docs/pinterest/samples/pin-001.png').replaceAll('\\','/');
 const prompt=`Use case: ads-marketing / compositing.\nAsset type: one finished vertical Pinterest Pin ${id} for Villa Fabulosa, opaque PNG, 1024 x 1536 pixels, 2:3.\nInput image 1: actual property photograph, ${fullSource}; sole photographic subject. Input image 2: ${fullStyle}; STYLE ONLY for approved warm ivory, deep navy, muted gold editorial identity. Do not import the photograph or headline from image 2.\nPrimary request: Produce one distinct, polished campaign graphic using image 1 faithfully in a photographic panel. Preserve its actual architecture, furniture, pool/court/room layout, scenery, lighting and materials. Use restrained cropping, not invented extensions. Source scene: ${photoAlt}\nLayout variant ${variant} of five for this source family: ${layouts[variant-1]}\nTypography: large elegant readable navy serif headline, letterspaced navy brand, restrained fine gold rules and generous safe margins. Photo remains large and recognizable.\nText (verbatim and only):\nBrand: "VILLA FABULOSA"\nHeadline: "${headline}"\nFooter location: "Temecula Wine Country"\nCTA: "Explore VillaFabulosa.com"\nBalance line breaks without changing any word. Keep all text complete and readable. If the source photograph contains an old white caption/banner, omit that old graphic caption from the photographic panel while preserving the property; print only the requested campaign wording.\nConstraints: no people; no new amenity, architecture, props, food, vineyard or winery; no event permission, ranking, price, rate, fee or savings claim; no badges, watermark, hashtags or duplicate text. Use the original real property's image, not a newly imagined estate. Do not enhance the time of day or invent scenery. Complete standalone graphic, not a mockup.\n`;
 const metadata={id,status:'prepared',prepared_date:'2026-10-26',timezone:'Asia/Karachi',keyword,keyword_source_cell:['A3','A5','A8','A9','A10','A12','A13','A14','A15','A16','A17','A18','A19','A20','A21'][k],target_location:location,location_rule:l<3?'Property in Temecula, Riverside County, Southern California.':`Travelers from ${location}; property is in Temecula.`,title,description,hashtags,headline,headline_bank_number:bankIndex+1,headline_adaptation:adaptation,source,source_family:si+1,creative_variant:variant,layout:layouts[variant-1],style_reference:'docs/pinterest/samples/pin-001.png',image:`${folder}/pin-${id}.png`,alt_text:`${photoAlt} The graphic reads "${headline}" and "Explore VillaFabulosa.com," with Villa Fabulosa branding and a Temecula Wine Country footer.`,board_recommendation:'Top Vacation Rental in Temecula Wine Country',destination:`https://villafabulosa.com/?utm_source=pinterest&utm_medium=organic_social&utm_campaign=villa_fabulosa_75_pins&utm_content=pin_${id}`,published_url:null,posted_date:null,scheduled_date:null,live_verified:false,manual_ai_disclosure_requested:false,manual_ai_disclosure_saved:null,public_ai_label_present:null,topic_tags:[],topic_status:'Choose relevant native topics only if offered when posting.',generation_method:'Built-in image_gen.imagegen; original output saved without code image edits.',dimensions:null,asset_review_status:'pending',performance:{impressions:null,saves:null,outbound_clicks:null,website_sessions:null,inquiries:null,bookings:null},prompt_file:`${folder}/prompt.txt`,review_file:`${folder}/review.json`};
 fs.mkdirSync(folder,{recursive:true});
 if(fs.existsSync(`${folder}/metadata.json`))throw Error(`Refusing overwrite ${id}`);
 fs.writeFileSync(`${folder}/metadata.json`,JSON.stringify(metadata,null,2)+'\n');
 fs.writeFileSync(`${folder}/prompt.txt`,prompt);
 fs.writeFileSync(`${folder}/posting.md`,`# Pin ${id}\n\nStatus: Prepared locally; not published or scheduled. Prepared 26 October 2026 (Asia/Karachi).\n\nImage: [pin-${id}.png](pin-${id}.png)\n\n## Title\n\n${title}\n\n## Description (includes hashtags)\n\n${description}\n\n## Destination\n\n${metadata.destination}\n\n## Alt text\n\n${metadata.alt_text}\n\n## Posting details\n\n- Keyword: ${keyword} (${metadata.keyword_source_cell})\n- Target: ${location}. ${metadata.location_rule}\n- Recommended existing board: ${metadata.board_recommendation}\n- Overlay headline: ${headline}\n- Source: ${source}\n- Creative variation: ${variant}; source family ${si+1}\n- Manual AI disclosure preference for later posting: Off; no saved platform setting yet. Pinterest may apply an automatic AI badge.\n- Native topics: choose relevant options if offered at publication.\n- Published URL, posted date and performance: blank until actually posted/measured.\n\nFull generation prompt: [prompt.txt](prompt.txt). Asset review: [review.json](review.json). Exact structured fields: [metadata.json](metadata.json).\n`);
 return metadata;
});
if(sourceCounts.some(c=>c!==5))throw Error('Source counts '+sourceCounts);
fs.writeFileSync(`${base}/manifest.json`,JSON.stringify({prepared_date:'2026-10-26',timezone:'Asia/Karachi',campaign_total:75,existing_published_count:11,prepared_count:64,status:'artwork_in_progress',publication_authorized:false,existing_published:existing,pins},null,2)+'\n');
fs.writeFileSync(`${base}/matrix.json`,JSON.stringify({keywords,locations,source_families:sourceDefs.map((s,i)=>({family:i+1,filename:s[0],total_campaign_variants:5})),campaign:[...existing,...pins.map(p=>({id:p.id,keyword:p.keyword,target_location:p.target_location,source:path.basename(p.source),status:p.status}))]},null,2)+'\n');
console.log(JSON.stringify({prepared:pins.length,max_title:Math.max(...pins.map(p=>p.title.length)),max_description:Math.max(...pins.map(p=>p.description.length)),sourceCounts}));
