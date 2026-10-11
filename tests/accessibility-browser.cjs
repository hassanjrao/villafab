const fs = require('fs');
const path = require('path');

// Serve the checked-in static assets directly to avoid the single-threaded PHP
// development server queueing dozens of images ahead of navigation requests.
module.exports = async function prepare(page) {
    const base = process.env.ACCESSIBILITY_BASE_URL || 'http://127.0.0.1:8099';
    const local = ['127.0.0.1', 'localhost', '[::1]'].includes(new URL(base).hostname);
    if (local) await page.route('**/frontend/**', async route => {
        const pathname = decodeURIComponent(new URL(route.request().url()).pathname);
        const publicRoot = path.resolve(__dirname, '../public');
        const asset = path.resolve(publicRoot, '.' + pathname);
        if (!asset.startsWith(publicRoot + path.sep)) return route.abort();
        if (fs.existsSync(asset) && fs.statSync(asset).isFile()) return route.fulfill({ path: asset });
        return route.fulfill({ status: 404, body: 'Asset missing from local checkout' });
    });
    await page.route('**/booking/payment-intent', route => route.fulfill({ status: 503, contentType: 'application/json', body: '{"error":"Payment submission disabled during accessibility testing."}' }));
    await page.route('**/g/collect**', route => route.abort());
};
