// Publish existing audit summaries; this script does not run new audits.
const fs = require('fs');
const path = require('path');

const root = path.resolve(__dirname, '..');
const date = '2026-10-13';
const publicPath = `accessibility/reports/${date}`;
const publicBase = `https://villafabulosa.com/${publicPath}`;
const output = path.join(root, 'public', publicPath);
const read = file => JSON.parse(fs.readFileSync(path.join(root, file), 'utf8').replace(/^\uFEFF/, ''));
const sites = [
    {
        site: 'Villa Fabulosa', slug: 'villa-fabulosa', expected: 54,
        sources: [
            'storage/app/accessibility/oct13-fabulosa-lighthouse/summary.json',
            'storage/app/accessibility/oct13-fabulosa-lighthouse-mobile/summary.json',
            'storage/app/accessibility/oct13-fabulosa-booking-final/summary.json',
        ],
    },
    {
        site: 'Modern Luxury Builders', slug: 'modern-luxury-builders', expected: 13,
        sources: [
            'storage/app/projects/modernluxurybuilders/.audit-artifacts/lighthouse-2026-10-13/summary.json',
            'storage/app/projects/modernluxurybuilders/.audit-artifacts/lighthouse-home-90s-2026-10-13/summary.json',
        ],
    },
    {
        site: 'Villa Magnifica', slug: 'villa-magnifica', expected: 91,
        sources: ['storage/app/projects/villamagnifica/.audit-artifacts/oct13-lighthouse-summary.json'],
    },
];

const csvRows = [];
const summaries = [];
for (const site of sites) {
    const states = new Map();
    for (const source of site.sources) {
        const summary = read(source);
        for (const item of summary.results) {
            // Later genuine rechecks replace earlier results for the same state.
            states.set(`${item.profile} ${item.url}`, {
                profile: item.profile,
                url: item.url,
                finalUrl: item.finalUrl,
                httpStatus: item.httpStatus,
                score: item.score,
                lighthouseVersion: item.lighthouseVersion,
                failures: item.failures,
                warnings: item.warnings || [],
                sourceSummaryGeneratedAt: summary.generated,
            });
        }
    }
    if (states.size !== site.expected * 2) throw new Error(`${site.site}: unexpected audit count`);
    const urls = [...new Set([...states.values()].map(item => item.url))];
    const evidenceUrl = `${publicBase}/${site.slug}-summary.json`;
    for (const url of urls) {
        const desktop = states.get(`desktop ${url}`);
        const mobile = states.get(`mobile ${url}`);
        for (const state of [desktop, mobile]) {
            if (!state || state.httpStatus !== 200 || !Number.isFinite(state.score) || state.score < 90 || state.failures.length) {
                throw new Error(`${site.site}: unresolved audit for ${url}`);
            }
            if (state.warnings.some(warning => /too slowly|incomplete/i.test(warning))) {
                throw new Error(`${site.site}: unresolved load warning for ${url}`);
            }
        }
        csvRows.push({
            site: site.site, url,
            desktopScore: desktop.score, mobileScore: mobile.score,
            desktopFinalUrl: desktop.finalUrl, mobileFinalUrl: mobile.finalUrl,
            desktopStatus: desktop.httpStatus, mobileStatus: mobile.httpStatus,
            lighthouseVersion: desktop.lighthouseVersion,
            desktopEvidence: evidenceUrl, mobileEvidence: evidenceUrl,
        });
    }
    summaries.push({
        filename: `${site.slug}-summary.json`,
        data: {
            site: site.site,
            auditDate: date,
            auditor: 'Lighthouse accessibility',
            publicUrlCount: urls.length,
            auditCount: states.size,
            minimumScore: Math.min(...[...states.values()].map(item => item.score)),
            scope: 'Public requested URLs and selected page states, desktop and mobile. Broad scans block payment-intent creation; the initialized Stripe iframe was audited separately. These scores do not establish full WCAG or ADA compliance.',
            results: [...states.values()],
        },
    });
}

const csv = [
    Object.keys(csvRows[0]).join(','),
    ...csvRows.map(row => Object.values(row).map(value => `"${String(value).replace(/"/g, '""')}"`).join(',')),
].join('\n') + '\n';
fs.mkdirSync(output, { recursive: true });
for (const summary of summaries) {
    fs.writeFileSync(path.join(output, summary.filename), JSON.stringify(summary.data, null, 2) + '\n');
}
fs.writeFileSync(path.join(root, 'docs/live-accessibility-scores.csv'), csv);
fs.writeFileSync(path.join(output, 'live-accessibility-scores.csv'), csv);
console.log(JSON.stringify(summaries.map(({ filename, data }) => ({
    site: data.site, urls: data.publicUrlCount, audits: data.auditCount,
    minimumScore: data.minimumScore, evidenceUrl: `${publicBase}/${filename}`,
})), null, 2));
