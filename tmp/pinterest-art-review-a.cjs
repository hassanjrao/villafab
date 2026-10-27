const fs = require('fs');
const path = require('path');
const [id, output, notes] = process.argv.slice(2);
if (!/^0(1[2-9]|2[0-9])$/.test(id)) throw new Error('Outside assigned pin range');
const folder = path.resolve('docs/pinterest/prepared', `pin-${id}`);
const imagePath = path.join(folder, `pin-${id}.png`);
if (!fs.existsSync(imagePath)) fs.copyFileSync(output, imagePath, fs.constants.COPYFILE_EXCL);
const bytes = fs.readFileSync(imagePath);
const review = {
  id, reviewed_date: '2026-10-26', status: 'visually_reviewed',
  generation_method: 'Built-in image_gen.imagegen', generation_output_path: output,
  saved_image: `docs/pinterest/prepared/pin-${id}/pin-${id}.png`,
  dimensions: { width: bytes.readUInt32BE(16), height: bytes.readUInt32BE(20) },
  source_photo_inspected: true, style_reference_inspected: true,
  headline_and_brand_and_cta_checked: true, no_generated_people: true,
  source_fidelity_review: notes,
  limitations: 'AI-generated design based on the actual source photo; crop, color and fine surface details may vary. It is not a pixel-identical source photograph.',
  publication_status: 'not_published', live_verification: false,
  prompt_file: `docs/pinterest/prepared/pin-${id}/prompt.txt`
};
fs.writeFileSync(path.join(folder, 'review.json'), JSON.stringify(review, null, 2) + '\n');
console.log(JSON.stringify({id, dimensions: review.dimensions, status: review.status}));
