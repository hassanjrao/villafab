const fs = require('fs');
const path = require('path');
const root = path.resolve(__dirname, '..');
const plans = [
  {
    id: '005', keyword: 'private villas to rent', target_location: 'Los Angeles (travelers from; property in Temecula)',
    title: 'Private Villas to Rent | Temecula Getaway from Los Angeles | Villa Fabulosa',
    description: 'Looking for private villas to rent for a getaway from Los Angeles? Discover Villa Fabulosa in Temecula Wine Country, with a private pool and courtyard for relaxed time together. Explore the estate and check availability at VillaFabulosa.com. #TemeculaWineCountry #PrivateVilla #LosAngelesGetaway',
    hashtags: ['#TemeculaWineCountry', '#PrivateVilla', '#LosAngelesGetaway'],
  },
  {
    id: '006', keyword: 'exclusive villa rentals', target_location: 'Orange County (travelers from; property in Temecula)',
    title: 'Exclusive Villa Rentals | Temecula Getaway from Orange County | Villa Fabulosa',
    description: 'Discover Villa Fabulosa, a private Temecula Wine Country estate for your next group getaway from Orange County. Enjoy the arcade room between outings and relaxed time together at the villa. Explore the property and check availability at VillaFabulosa.com. #TemeculaWineCountry #GroupGetaway #ArcadeRoom',
    hashtags: ['#TemeculaWineCountry', '#GroupGetaway', '#ArcadeRoom'],
  },
  {
    id: '007', keyword: 'luxury villa vacation rentals', target_location: 'Temecula Wine Country / Riverside County',
    title: 'Luxury Villa Vacation Rentals in Temecula Wine Country | Villa Fabulosa',
    description: 'Explore luxury villa vacation rentals in Temecula Wine Country with a closer look at Villa Fabulosa. This private Riverside County estate brings a pool, spa and space to gather in one setting. View the property and check availability at VillaFabulosa.com. #TemeculaWineCountry #LuxuryVilla #PoolAndSpa',
    hashtags: ['#TemeculaWineCountry', '#LuxuryVilla', '#PoolAndSpa'],
  },
];
const file = path.join(root, 'docs/pinterest/batch-2026-10-20.json');
const existing = fs.existsSync(file) ? JSON.parse(fs.readFileSync(file, 'utf8')) : null;
const posts = plans.map(plan => {
  const creativeFile = path.join(root, 'docs/pinterest/samples', `pin-${plan.id}.json`);
  const creative = fs.existsSync(creativeFile) ? JSON.parse(fs.readFileSync(creativeFile, 'utf8')) : {};
  const previous = existing?.posts.find(p => p.id === plan.id);
  if (previous?.published_url) return previous;
  if (plan.title.length > 100 || plan.description.length > 500 || plan.description.length < 100) throw Error(`Invalid text length for ${plan.id}`);
  return { ...creative, ...plan,
    image: `docs/pinterest/samples/pin-${plan.id}.png`,
    alt_text: creative.alt_text || '',
    board: 'Top Vacation Rental in Temecula Wine Country',
    destination: `https://villafabulosa.com/?utm_source=pinterest&utm_medium=organic_social&utm_campaign=villa_fabulosa_75_pins&utm_content=pin_${plan.id}`,
    published_url: '', posted_date: '', status: 'prepared', verified: false,
    manual_ai_disclosure: false, requested_manual_ai_disclosure: false,
    tag_update_status: 'prepared', topic_tags: [],
  };
});
fs.writeFileSync(file, JSON.stringify({date: '2026-10-20', timezone: 'Asia/Karachi', new_pin_ids: ['005','006','007'], posts}, null, 2) + '\n', 'utf8');
console.log(JSON.stringify(posts.map(p => ({ id: p.id, titleLength: p.title.length, descriptionLength: p.description.length, creativeReady: Boolean(p.alt_text), published: Boolean(p.published_url) }))));
