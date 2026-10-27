const fs = require('fs');
const path = require('path');
const root = path.resolve(__dirname, '..');
const common = {
  board: 'Top Vacation Rental in Temecula Wine Country',
  dimensions: { width: 1024, height: 1536, aspect_ratio: '2:3', note: 'Expected size of the AI-generated asset; record the actual size after generation.' },
  method: 'Pending: owner chose AI-generated designs (built-in image generation with the source photo and pin-001.png as reference images), matching Pins 001–007. A non-AI composite draft was rendered and declined on 2026-10-25; it is kept only at tmp/composite-drafts-2026-10-25/.',
  creative_status: 'awaiting AI generation',
  generated_people: false,
  style_reference: 'docs/pinterest/samples/pin-001.png',
  manual_ai_disclosure: false, requested_manual_ai_disclosure: false,
  published_url: '', posted_date: '', status: 'prepared', verified: false, tag_update_status: 'prepared', topic_tags: [],
  timezone: 'Asia/Karachi',
};
const plans = [
  {
    id: '008', keyword: 'rent luxury houses', keyword_cell: 'A10', target_location: 'Southern California',
    headline: 'Imagine yourself here!', headline_bank_note: 'Original headline 9.',
    source: 'public/frontend/imgs/photos-for-vrbo/villa-fabulosa-13-view.webp',
    title: 'Rent Luxury Houses in Southern California Wine Country | Villa Fabulosa',
    description: 'Planning to rent luxury houses in Southern California? Imagine evenings at Villa Fabulosa, a private Temecula Wine Country estate with a pool, covered lounges and hillside views. Explore the property and check availability at VillaFabulosa.com. #TemeculaWineCountry #SoCalGetaway #LuxuryVilla',
    hashtags: ['#TemeculaWineCountry', '#SoCalGetaway', '#LuxuryVilla'],
    alt_text: 'Ivory, navy and gold Villa Fabulosa graphic reading “Imagine yourself here!” A dusk photo taken from an upper level of the white modern villa looks down on a rectangular pool, loungers on artificial turf, a patio dining set and a white covered pavilion, with hills under a pink and purple sky. The footer reads “Private Pool • Southern California” and “Explore VillaFabulosa.com.”',
  },
  {
    id: '009', keyword: 'large vacation rental', keyword_cell: 'A12', target_location: 'Riverside County',
    headline: 'Temecula Wine Country Luxury Escape', headline_bank_note: 'Original headline 11. Headline 10 skipped: the site does not describe master suites.',
    source: 'public/frontend/imgs/photos-for-vrbo/villa-fabulosa-23-patio.webp',
    title: 'Large Vacation Rental in Temecula, Riverside County | Villa Fabulosa',
    description: 'Find a large vacation rental for your group in Temecula, Riverside County. Villa Fabulosa pairs a covered patio and fire table with a private pool, lawn games and wine country sunsets. See the estate and check availability at VillaFabulosa.com. #TemeculaWineCountry #GroupVacation #RiversideCounty',
    hashtags: ['#TemeculaWineCountry', '#GroupVacation', '#RiversideCounty'],
    alt_text: 'Ivory, navy and gold Villa Fabulosa graphic reading “Temecula Wine Country Luxury Escape.” A dusk photo from a covered patio shows wicker sofas around a lit fire table, with the pool, loungers, a white pavilion, a lawn game court and a putting green under a purple sky. The footer reads “Covered Patio • Temecula, Riverside County” and “Explore VillaFabulosa.com.”',
  },
  {
    id: '010', keyword: 'luxury villa holidays', keyword_cell: 'A13', target_location: 'Orange County (travelers from; property in Temecula)',
    headline: 'Stay in the Heart of SoCal Wine Country', headline_bank_note: 'Original headline 12.',
    source: 'public/frontend/imgs/photos-for-vrbo/villa-fabulosa-13-dining.webp',
    amenity_evidence: 'resources/views/frontend/gallery/floorplan.blade.php:28 (dining table marked for 16 seats); resources/views/frontend/home.blade.php:1001 (outdoor kitchen)',
    title: 'Luxury Villa Holidays | Temecula Wine Country Getaway from Orange County | Villa Fabulosa',
    description: 'Plan luxury villa holidays with a getaway from Orange County to Villa Fabulosa in Temecula Wine Country. Gather around a dining table for 16 that opens onto the covered patio and outdoor kitchen. Check availability at VillaFabulosa.com. #TemeculaWineCountry #OrangeCountyGetaway #GroupDinner',
    hashtags: ['#TemeculaWineCountry', '#OrangeCountyGetaway', '#GroupDinner'],
    alt_text: 'Ivory, navy and gold Villa Fabulosa graphic reading “Stay in the Heart of SoCal Wine Country.” A photo shows a long glass-topped dining table set with plates, blue napkins, wine glasses and bottles, beside open sliding doors to a covered patio and outdoor kitchen. The footer reads “Group Dining • Temecula Wine Country” and “Explore VillaFabulosa.com.”',
  },
];
// Same structure as the Pin 007 prompt: image 1 = actual photo (edit target), image 2 = pin-001.png style only.
const prompt = (photo, headline, subline, invariants) => `Use case: compositing.
Asset type: ONE polished editorial Pinterest campaign graphic, portrait 2:3, 1024 by 1536 pixels.
Primary request: Create a new Villa Fabulosa Pin using the actual photograph from image 1 as a faithful rectangular landscape insert. Match the warm ivory, navy and muted gold editorial typography and CTA treatment of image 2.
Input images: Image 1 (${photo}) is the actual property photograph and EDIT TARGET for the photo panel. Preserve its geometry and visual content. Image 2 (pin-001.png) is ONLY a style reference for fonts, design colors, spacing, brand and CTA. Never borrow its sky, photo lighting, pool view or architectural details.
Composition: At the top, warm ivory field with small centered widely tracked navy brand, thin gold rule and a large high-contrast navy serif headline on balanced lines. Place the full actual photograph in a full-width rectangular middle panel at its original wide aspect ratio, with no invented extension. Use an ivory lower field with gold rule, centered subline with a small gold dot separator, and dark navy rectangular CTA framed by thin gold, white sans-serif CTA text. Large legible type, generous breathing room and safe margins. Prefer larger ivory text bands over extending or altering the actual photograph.
Text (verbatim, exactly these four strings):
"VILLA FABULOSA"
"${headline}"
"${subline}"
"Explore VillaFabulosa.com"
Photo invariants: ${invariants} Keep existing relative positions, counts, camera angle, perspective, original lighting and shadows. Do not redesign, simplify, relocate or duplicate any of these elements.
Constraints: Make the marketing layout around the actual source photo, rather than reimagining the property. No new features, new buildings, new landscaping, people or decorative props. No ranking, capacity, award, pricing or booking guarantee claims. No extra words, watermark, invented logo, montage, collage or variants. Generate exactly ONE finished opaque graphic.`;
plans[0].prompt = prompt('villa-fabulosa-13-view.webp', plans[0].headline, 'Private Pool • Southern California',
  'Retain the elevated dusk view from the upper level of the white modern villa: the cantilevered white roof and black-framed window on the right, the flat white roof on the left, the rectangular pool with in-pool white loungers, navy loungers on artificial turf, the patio dining table with blue vases, the white covered pavilion with dark wicker seating, the glass railing, distant hills and the pink and purple dusk sky.');
plans[1].prompt = prompt('villa-fabulosa-23-patio.webp', plans[1].headline, 'Covered Patio • Temecula, Riverside County',
  'Retain the covered patio with its ceiling fan and recessed lights, the white column, two wicker sofas with blue cushions around the lit rectangular fire table, the pool and navy loungers on the left, the white pavilion, the table-tennis table, the lawn game court, the putting green with a flag, the glass railing and the purple dusk sky.');
plans[2].prompt = prompt('villa-fabulosa-13-dining.webp', plans[2].headline, 'Group Dining • Temecula Wine Country',
  'Retain the long glass-topped dining table with grey leather chairs, white plates, blue napkins, wine glasses and bottles and small centerpieces; the high white wall with three blue artworks and upper windows; the open black sliding doors onto the covered patio with ceiling fan, outdoor kitchen and patio dining set; the reflective glass panel on the right and the dusk light.');
const file = path.join(root, 'docs/pinterest/batch-2026-10-25.json');
const existing = fs.existsSync(file) ? JSON.parse(fs.readFileSync(file, 'utf8')) : null;
const posts = plans.map(plan => {
  const previous = existing?.posts.find(p => p.id === plan.id);
  if (previous?.published_url) return previous;
  if (plan.title.length > 100 || plan.description.length > 500 || plan.description.length < 100 || plan.alt_text.length > 500) throw Error(`Invalid text length for ${plan.id}`);
  return { ...common, ...plan, image: `docs/pinterest/samples/pin-${plan.id}.png`,
    destination: `https://villafabulosa.com/?utm_source=pinterest&utm_medium=organic_social&utm_campaign=villa_fabulosa_75_pins&utm_content=pin_${plan.id}` };
});
fs.writeFileSync(file, JSON.stringify({ date: '2026-10-25', timezone: 'Asia/Karachi', new_pin_ids: ['008', '009', '010'], posts }, null, 2) + '\n', 'utf8');
console.log(JSON.stringify(posts.map(p => ({ id: p.id, title: p.title.length, description: p.description.length, alt: p.alt_text.length, published: Boolean(p.published_url) }))));
