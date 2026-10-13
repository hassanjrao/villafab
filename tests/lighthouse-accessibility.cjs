// Run actual Lighthouse accessibility audits against a reviewed live URL list.
// Install Lighthouse separately in the ignored audit tooling directory.
const fs = require('fs');
const path = require('path');
const { pathToFileURL } = require('url');

(async () => {
    const configPath = process.argv[2];
    if (!configPath) throw new Error('Usage: node tests/lighthouse-accessibility.cjs config.json');
    const config = JSON.parse(fs.readFileSync(configPath, 'utf8').replace(/^\uFEFF/, ''));
    const tools = process.env.LIGHTHOUSE_TOOLS || path.resolve(__dirname, '../storage/app/accessibility/lighthouse-tools/node_modules');
    const { default: lighthouse } = await import(pathToFileURL(path.join(tools, 'lighthouse/core/index.js')).href);
    const chromeLauncher = await import(pathToFileURL(path.join(tools, 'chrome-launcher/dist/index.js')).href);
    const output = path.resolve(config.output);
    fs.mkdirSync(output, { recursive: true });
    const results = [];
    const reportFile = path.join(output, 'summary.json');
    const previous = config.resume && fs.existsSync(reportFile) ? JSON.parse(fs.readFileSync(reportFile)).results : [];
    const chrome = await chromeLauncher.launch({
        chromePath: process.env.CHROME_PATH || 'C:/Program Files/Google/Chrome/Application/chrome.exe',
        chromeFlags: ['--headless=new', '--disable-gpu', '--no-first-run'],
    });
    function save() {
        fs.writeFileSync(reportFile, JSON.stringify({ generated: new Date().toISOString(), base: config.base, minimum: config.minimum || 90, profiles: config.profiles || ['desktop', 'mobile'], results }, null, 2));
        const csv = ['profile,url,final_url,http_status,score,failed_audits,error', ...results.map(r => [r.profile, r.url, r.finalUrl, r.httpStatus, r.score, (r.failures || []).map(a => a.id).join(';'), r.error || ''].map(s => '"' + String(s ?? '').replace(/"/g, '""') + '"').join(','))].join('\n');
        fs.writeFileSync(path.join(output, 'scores.csv'), csv);
        const esc = text => String(text ?? '').replace(/[&<>"']/g, c => ({ '&':'&amp;', '<':'&lt;', '>':'&gt;', '"':'&quot;', "'":'&#39;' }[c]));
        const rows = results.map(r => `<tr><td>${esc(r.profile)}</td><td><a href="${esc(r.url)}">${esc(r.url)}</a></td><td>${esc(r.httpStatus)}</td><td>${esc(r.score)}</td><td>${esc((r.failures || []).map(a => a.title).join('; ') || r.error || '')}</td><td>${r.report ? `<a href="${esc(r.report)}">Lighthouse JSON</a>` : ''}</td></tr>`).join('\n');
        fs.writeFileSync(path.join(output, 'index.html'), `<!doctype html><html lang="en"><meta charset="utf-8"><title>Live accessibility scores</title><style>body{font:16px system-ui;margin:2rem;color:#222}table{border-collapse:collapse}td,th{border:1px solid #777;padding:.6rem;text-align:left}a{color:#0645ad}</style><h1>Live Lighthouse accessibility scores</h1><p>Generated ${esc(new Date().toISOString())}. Target: ${config.minimum || 90}/100. Scores apply to automated accessibility audits; manual accessibility checks remain necessary. POST payment submissions were blocked during scanning.</p><table><thead><tr><th>Profile</th><th>Requested URL</th><th>HTTP status</th><th>Score</th><th>Failed audits</th><th>Evidence</th></tr></thead><tbody>${rows}</tbody></table></html>`);
    }
    try {
        for (const profile of config.profiles || ['desktop', 'mobile']) {
            for (const [index, route] of config.routes.entries()) {
                const url = new URL(route, config.base).href;
                const existing = previous.find(r => r.profile === profile && r.url === url && !r.error && r.score >= (config.minimum || 90));
                if (existing) { results.push(existing); save(); continue; }
                let result;
                try {
                    const desktop = profile === 'desktop';
                    const run = await lighthouse(url, {
                        port: chrome.port,
                        onlyCategories: ['accessibility'],
                        formFactor: profile,
                        screenEmulation: { mobile: !desktop, width: desktop ? 1280 : 375, height: desktop ? 900 : 812, deviceScaleFactor: 1, disabled: false },
                        throttlingMethod: 'provided',
                        maxWaitForLoad: 45000,
                        pauseAfterLoadMs: 1200,
                        disableStorageReset: true,
                        blockedUrlPatterns: ['*/booking/payment-intent', '*/g/collect*'],
                    });
                    const lhr = run.lhr;
                    if (lhr.runtimeError) throw new Error(lhr.runtimeError.code + ': ' + lhr.runtimeError.message);
                    const failures = lhr.categories.accessibility.auditRefs.map(ref => lhr.audits[ref.id]).filter(a => a && a.scoreDisplayMode === 'binary' && a.score === 0).map(a => ({ id: a.id, title: a.title, details: a.details }));
                    const report = `${profile}-${String(index + 1).padStart(3, '0')}.json`;
                    fs.writeFileSync(path.join(output, report), JSON.stringify(lhr, null, 2));
                    const document = (run.artifacts?.DevtoolsLog || []).filter(entry => entry.method === 'Network.responseReceived' && entry.params.type === 'Document' && entry.params.response.url === (lhr.finalDisplayedUrl || lhr.finalUrl)).pop();
                    result = { profile, route, url, finalUrl: lhr.finalDisplayedUrl || lhr.finalUrl, httpStatus: document?.params.response.status || null, score: Math.round(lhr.categories.accessibility.score * 100), lighthouseVersion: lhr.lighthouseVersion, failures, warnings: lhr.runWarnings, report };
                } catch (error) {
                    result = { profile, route, url, score: null, error: error.message };
                }
                results.push(result);
                save();
                console.log(profile, `${index + 1}/${config.routes.length}`, url, result.error || result.score, (result.failures || []).map(a => a.id).join(','));
            }
        }
    } finally { await chrome.kill(); }
    if (results.some(r => r.error || r.score < (config.minimum || 90) || r.httpStatus >= 400)) process.exitCode = 1;
})().catch(error => { console.error(error); process.exitCode = 1; });
