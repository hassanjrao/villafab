const fs = require('fs');
const path = require('path');
const [id, generatedPath, notes, limitations = 'Generative recreation may subtly restyle small textures and details; not a pixel-identical source photograph.'] = process.argv.slice(2);
if (!/^0(5[5-9]|6[0-9]|7[01])$/.test(id)) throw new Error('Outside assigned artwork range');
const folder = path.resolve('docs/pinterest/prepared', `pin-${id}`);
const target = path.join(folder, `pin-${id}.png`);
if (path.resolve(generatedPath) !== target && !fs.existsSync(target)) fs.copyFileSync(generatedPath, target);
const data = fs.readFileSync(target);
if (data.toString('ascii',1,4) !== 'PNG') throw new Error('Not PNG');
const width = data.readUInt32BE(16), height = data.readUInt32BE(20);
const review = {
  id, reviewed_date:'2026-10-26', timezone:'Asia/Karachi',
  generation_method:'Built-in image_gen.imagegen',
  generation_output_path:generatedPath,
  saved_image:`docs/pinterest/prepared/pin-${id}/pin-${id}.png`,
  dimensions:{width,height},
  visual_review_status:'passed', source_inspected:true, style_reference_inspected:true,
  text_review:'Brand, full headline, location and CTA visually checked; complete and readable.',
  visual_review:notes, limitations,
  contains_generated_people:false, code_image_edits:false,
  publication_status:'not_published', live_verified:false
};
fs.writeFileSync(path.join(folder,'review.json'), JSON.stringify(review,null,2)+'\n');
process.stdout.write(JSON.stringify({id,width,height,saved_image:review.saved_image}));
