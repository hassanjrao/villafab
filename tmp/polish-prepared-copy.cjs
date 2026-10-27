const fs = require('fs');
const path = require('path');
const base = path.resolve('docs/pinterest/prepared');
const fields = ['title', 'description', 'hashtags', 'alt_text', 'headline_adaptation'];
const intros = {
  'luxury villa rental': ['Looking for a luxury villa rental', 'Picture your next luxury villa rental', 'Searching for a luxury villa rental'],
  'luxury vacation home rentals': ['Comparing luxury vacation home rentals', 'Searching for luxury vacation home rentals', 'Planning a stay and exploring luxury vacation home rentals'],
  'luxury villa vacation rentals': ['Looking for luxury villa vacation rentals', 'Comparing luxury villa vacation rentals for your next trip', 'Exploring luxury villa vacation rentals for time together'],
  'exclusive villa rentals': ['Considering exclusive villa rentals', 'Searching for exclusive villa rentals', 'Exploring exclusive villa rentals for a private escape'],
  'rent luxury houses': ['Looking to rent luxury houses', 'Planning to rent luxury houses', 'Want to rent luxury houses'],
  'large vacation rental': ['Looking for a large vacation rental', 'Need a large vacation rental for your next shared stay', 'Searching for a large vacation rental'],
  'luxury villa holidays': ['Dreaming of luxury villa holidays', 'Planning luxury villa holidays', 'Considering luxury villa holidays for your next escape'],
  'large family vacation rentals': ['Comparing large family vacation rentals', 'Searching for large family vacation rentals', 'Exploring large family vacation rentals for time together'],
  'large group vacation rentals': ['Looking for large group vacation rentals', 'Comparing large group vacation rentals', 'Planning a shared trip and exploring large group vacation rentals'],
  'large house to rent': ['Looking for a large house to rent', 'Need a large house to rent for a shared escape', 'Searching for a large house to rent'],
  'rent a mansion for a weekend': ['Hoping to rent a mansion for a weekend', 'Looking to rent a mansion for a weekend', 'Planning to rent a mansion for a weekend'],
  'luxury holiday rentals': ['Considering luxury holiday rentals', 'Comparing luxury holiday rentals', 'Searching for luxury holiday rentals'],
  'private villas to rent': ['Looking for private villas to rent', 'Exploring private villas to rent', 'Searching for private villas to rent for your next escape'],
  'group vacation rentals': ['Comparing group vacation rentals', 'Searching for group vacation rentals', 'Planning a shared stay and exploring group vacation rentals'],
  'large villa holidays': ['Planning large villa holidays', 'Dreaming of large villa holidays', 'Considering large villa holidays for time together']
};
const scenes = {
  1: ['Unwind beside the illuminated private pool and enjoy the open courtyard.', 'Make poolside relaxation part of your stay in the white estate courtyard.'],
  2: ['Settle into the bright living room with cream sofas and blue accents.', 'Reconnect in the double-height living room between days out in wine country.'],
  3: ['Enjoy the covered outdoor lounge, with wicker seating for relaxed conversations.', 'Slow down in the covered courtyard lounge and spend time together outdoors.'],
  4: ["Make time for a friendly round on the estate's miniature golf course.", 'Add a little friendly competition with miniature golf during your estate stay.'],
  5: ['Picture an unhurried afternoon beside the private pool and its shallow lounge ledges.', 'Recharge by the private pool, with loungers and courtyard space for an easy afternoon.'],
  6: ['Take a playful break in the game room with arcade cabinets and indoor games.', 'Bring the group together for arcade games, foosball or air hockey at the estate.'],
  7: ['Explore the estate layout, from the pool courtyard to the outdoor recreation spaces.', 'Plan time together around the private pool and outdoor gathering areas.'],
  8: ['Unwind on the covered patio with wicker seating and a fire table.', 'Enjoy an evening conversation in the covered patio lounge overlooking the courtyard.'],
  9: ['Retreat to an inviting bedroom with blue accents when it is time to slow down.', 'Recharge in a comfortable bedroom after a day spent exploring wine country.'],
  10: ['Share a meal around the long glass dining table beside the courtyard doors.', 'Gather around the dining table, with blue-accented place settings and courtyard views.'],
  11: ['Take in the blue-lit pool, covered dining area and hills from this elevated courtyard view.', 'Discover the courtyard from above, with its pool, loungers and outdoor dining spaces.'],
  12: ['Gather around the kitchen island and enjoy space to prepare and share meals.', 'Start a relaxed day in the bright kitchen with its island and blue accent lighting.'],
  13: ['Recharge in a bright two-bed bedroom with glass doors toward the courtyard.', 'Find a comfortable place to unwind in a bedroom with blue covers and courtyard access.'],
  14: ['Make time for the sport court and putting greens during your shared escape.', 'Explore the outdoor recreation spaces, with a blue sport court beside the putting greens.'],
  15: ['Step through the contemporary foyer into bright interiors with blue accents.', 'Discover a welcoming estate entrance with a striking black door and colorful artwork.']
};
const reasons = {
  3: 'Replaced "Perfect Venue" with "A Private Stay" to describe accommodation without implying event permission.',
  5: 'Replaced the unsupported "#1 Vacation Rental in California" ranking with "A California Estate Escape".',
  10: 'Replaced "Master Suites" with "Bedrooms" because multiple master suites are unconfirmed.',
  13: 'Replaced "Minutes from Temecula Wineries" with "in Temecula Wine Country" because a specific winery travel time is unverified.',
  16: 'Replaced "Book Direct at VillaFabulosa.com & Save" with "Explore VillaFabulosa.com for Your Next Stay" because a savings claim is unsupported.',
  17: 'Replaced "Skip Platform Fees | Book Direct" with "Discover Your Stay | VillaFabulosa.com" because the fee exemption is unverified.',
  18: 'Replaced "Best Rates Guaranteed at VillaFabulosa.com" with "Plan Your Villa Fabulosa Escape" because no documented rate guarantee supports that claim.',
  20: 'Replaced "Book Direct & Save" with "Explore Your Next Wine Country Stay" because a savings claim is unsupported.'
};
const ctas = ['See the estate and check availability at VillaFabulosa.com.', 'Explore the property and available dates at VillaFabulosa.com.', 'Plan your next stay at VillaFabulosa.com.', 'Find property details and check dates at VillaFabulosa.com.'];
const anchors = ['Meet Villa Fabulosa, a private estate for your next shared escape.', 'Consider Villa Fabulosa for a stay with family or friends.', 'Discover the private estate setting at Villa Fabulosa.', 'Get to know Villa Fabulosa and make room for time together.'];
const manifestPath = path.join(base, 'manifest.json');
const manifest = JSON.parse(fs.readFileSync(manifestPath, 'utf8'));
const originals = new Map();
const results = [];
for (let num = 12; num <= 75; num++) {
  const id = String(num).padStart(3, '0');
  const folder = path.join(base, `pin-${id}`);
  const metaPath = path.join(folder, 'metadata.json');
  const m = JSON.parse(fs.readFileSync(metaPath, 'utf8'));
  originals.set(id, JSON.parse(JSON.stringify(m)));
  const feeder = ['Los Angeles', 'Orange County'].includes(m.target_location);
  const loc = feeder ? `for a getaway from ${m.target_location}` : `in ${m.target_location === 'Riverside County' ? 'Temecula, Riverside County' : m.target_location}`;
  const intro = `${intros[m.keyword][num % 3]} ${loc}?`;
  const anchor = feeder ? ['Discover Villa Fabulosa in Temecula Wine Country.', 'Plan a stay at Villa Fabulosa in Temecula Wine Country.', 'Consider Villa Fabulosa, a private estate in Temecula Wine Country.'][num % 3] : anchors[num % anchors.length];
  const weekend = m.keyword === 'rent a mansion for a weekend';
  const cta = weekend ? 'Check available dates and stay requirements at VillaFabulosa.com.' : ctas[num % ctas.length];
  m.description = `${intro} ${anchor} ${scenes[m.source_family][num % 2]} ${cta} ${m.hashtags.join(' ')}`;
  if (feeder) m.title = m.title.replace(' | Temecula from ', ' | Temecula Getaway from ');
  m.headline_adaptation = num === 73 ? 'Shortened "Scenic Views & Private Estate Luxury" to "Private Estate Luxury" to focus on the selected covered-patio lounge photograph.' : (reasons[m.headline_bank_number] || '');
  if (m.title.length > 100 || m.description.length < 100 || m.description.length > 500) throw new Error(`${id} length: title=${m.title.length}; description=${m.description.length}`);
  const tags = m.description.match(/#[A-Za-z0-9_]+/g) || [];
  if (tags.length !== 3 || JSON.stringify(tags) !== JSON.stringify(m.hashtags)) throw new Error(`${id} hashtag mismatch`);
  if (!m.description.toLowerCase().includes(m.keyword)) throw new Error(`${id} keyword missing`);
  if (feeder && !m.description.includes(`from ${m.target_location}`)) throw new Error(`${id} feeder wording missing`);
  if (/\b(#1|guaranteed|save money|skip platform fees|minutes from)\b/i.test(m.description)) throw new Error(`${id} unsupported claim`);
  const old = originals.get(id);
  for (const k of Object.keys(old)) if (!fields.includes(k) && JSON.stringify(old[k]) !== JSON.stringify(m[k])) throw new Error(`${id} forbidden mutation: ${k}`);
  fs.writeFileSync(metaPath, JSON.stringify(m, null, 2) + '\n');
  let posting = fs.readFileSync(path.join(folder, 'posting.md'), 'utf8');
  for (const [heading, value] of [['Title', m.title], ['Description (includes hashtags)', m.description], ['Alt text', m.alt_text]]) {
    const start = `## ${heading}\n\n`;
    const begin = posting.indexOf(start);
    if (begin < 0) throw new Error(`${id} missing posting section ${heading}`);
    const end = posting.indexOf('\n\n## ', begin + start.length);
    if (end < 0) throw new Error(`${id} unterminated posting section ${heading}`);
    posting = posting.slice(0, begin + start.length) + value + posting.slice(end);
  }
  const note = '- Headline adaptation: ';
  posting = posting.split('\n').filter(line => !line.startsWith(note)).join('\n');
  if (m.headline_adaptation) posting = posting.replace(`- Overlay headline: ${m.headline}`, `- Overlay headline: ${m.headline}\n${note}${m.headline_adaptation}`);
  fs.writeFileSync(path.join(folder, 'posting.md'), posting);
  const manifestPin = manifest.pins.find(p => p.id === id);
  if (!manifestPin) throw new Error(`${id} missing manifest record`);
  for (const field of fields) manifestPin[field] = m[field];
  results.push({id, title_chars: m.title.length, description_chars: m.description.length, hashtags: tags.length});
}
fs.writeFileSync(manifestPath, JSON.stringify(manifest, null, 2) + '\n');
const report = { reviewed_date: '2026-10-26', count: results.length, fields_edited: fields, title_limit_passed: true, description_limit_passed: true, three_hashtags_passed: true, keyword_present_passed: true, feeder_location_wording_passed: true, noncopy_metadata_fields_unchanged: true, prompts_and_images_unchanged: true, rows: results };
fs.writeFileSync(path.join(base, 'copy-audit.json'), JSON.stringify(report, null, 2) + '\n');
console.log(JSON.stringify({count: results.length, min_description: Math.min(...results.map(r => r.description_chars)), max_description: Math.max(...results.map(r => r.description_chars)), max_title: Math.max(...results.map(r => r.title_chars)), all_checks_passed: true}));
