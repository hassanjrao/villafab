// Renders Pins 008–010 as 1000 × 1500 PNGs: the approved ivory/navy/gold layout
// composed around the unmodified property photo (cropped to the panel, never redrawn).
const { chromium } = require('../node_modules/playwright');
const fs = require('fs');
const path = require('path');
const root = path.resolve(__dirname, '..');
const photos = path.join(root, 'public/frontend/imgs/photos-for-vrbo');
const pins = [
  { id: '008', photo: 'villa-fabulosa-13-view.webp', headline: 'Imagine yourself here!', subline: ['Private Pool', 'Southern California'], focus: '50% 50%' },
  { id: '009', photo: 'villa-fabulosa-23-patio.webp', headline: 'Temecula Wine Country Luxury Escape', subline: ['Covered Patio', 'Temecula, Riverside County'], focus: '45% 50%' },
  { id: '010', photo: 'villa-fabulosa-13-dining.webp', headline: 'Stay in the Heart of SoCal Wine Country', subline: ['Group Dining', 'Temecula Wine Country'], focus: '40% 50%' },
];
const only = process.argv.slice(2);
const page = pin => {
  const src = 'data:image/webp;base64,' + fs.readFileSync(path.join(photos, pin.photo)).toString('base64');
  return `<!doctype html><html><head><meta charset="utf-8">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500&family=Jost:wght@400;500&display=block" rel="stylesheet">
<style>
  * { box-sizing: border-box; margin: 0; }
  body { width: 1000px; height: 1500px; background: #f7f1e6; color: #0f1d3a; font-family: Jost, 'Segoe UI', sans-serif;
         display: flex; flex-direction: column; align-items: center; overflow: hidden; }
  .brand { margin-top: 64px; font-size: 27px; font-weight: 500; letter-spacing: 0.42em; padding-left: 0.42em; }
  .rule { width: 250px; height: 3px; background: linear-gradient(90deg, #c9a45c, #e2c98f, #c9a45c); }
  .top .rule { margin-top: 28px; }
  h1 { font-family: 'Playfair Display', Georgia, serif; font-weight: 500; font-size: 92px; line-height: 1.04;
       text-align: center; letter-spacing: -0.01em; padding: 0 70px; text-wrap: balance; }
  .top { display: flex; flex-direction: column; align-items: center; height: 520px; }
  .head { flex: 1; display: flex; align-items: center; padding-bottom: 34px; }
  .photo { width: 1000px; height: 640px; object-fit: cover; object-position: ${pin.focus}; display: block; }
  .bottom { flex: 1; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 34px; }
  .sub { font-size: 36px; letter-spacing: 0.06em; display: flex; align-items: center; gap: 22px; }
  .dot { width: 10px; height: 10px; border-radius: 50%; background: #c9a45c; }
  .cta { width: 820px; height: 100px; background: #0f1d3a; border: 3px solid #c9a45c; color: #fff;
         font-size: 46px; letter-spacing: 0.05em; display: flex; align-items: center; justify-content: center; }
</style></head><body>
  <div class="top"><div class="brand">VILLA FABULOSA</div><div class="rule"></div><div class="head"><h1>${pin.headline}</h1></div></div>
  <img class="photo" src="${src}" alt="">
  <div class="bottom"><div class="rule"></div>
    <div class="sub"><span>${pin.subline[0]}</span><span class="dot"></span><span>${pin.subline[1]}</span></div>
    <div class="cta">Explore VillaFabulosa.com</div></div>
</body></html>`;
};
(async () => {
  const browser = await chromium.launch({ channel: 'chrome' });
  const tab = await browser.newPage({ viewport: { width: 1000, height: 1500 }, deviceScaleFactor: 1 });
  for (const pin of pins.filter(p => !only.length || only.includes(p.id))) {
    await tab.setContent(page(pin), { waitUntil: 'networkidle' });
    await tab.evaluate(() => document.fonts.ready);
    const fonts = await tab.evaluate(() => ['Playfair Display', 'Jost'].map(f => document.fonts.check(`40px "${f}"`)));
    const overflow = await tab.evaluate(() => document.querySelector('.top h1').getBoundingClientRect().bottom > 520);
    const out = path.join(root, `docs/pinterest/samples/pin-${pin.id}.png`);
    await tab.screenshot({ path: out, clip: { x: 0, y: 0, width: 1000, height: 1500 } });
    console.log(JSON.stringify({ id: pin.id, out: path.relative(root, out), fontsLoaded: fonts, headlineOverflow: overflow }));
  }
  await browser.close();
})().catch(e => { console.error(e); process.exitCode = 1; });
