// Export existing completed Pa11y CI runs, retaining warnings and manual findings.
const fs = require('fs');
const path = require('path');
const root = path.resolve(__dirname, '..');
const date = '2026-10-13';
const output = path.join(root, 'public/accessibility/reports', date);
const read = file => JSON.parse(fs.readFileSync(path.join(root, file), 'utf8').replace(/^\uFEFF/, ''));
const sites = [
    {
        name: 'Villa Fabulosa', slug: 'villa-fabulosa', expected: 108, revision: '8edfd383e87818b4e89a81b5b312f4e3d288cd53',
        sources: [
            ['initial', 'storage/app/accessibility/pa11y-2026-10-13/fabulosa-initial/report.json'],
            ['recheck', 'storage/app/accessibility/pa11y-2026-10-13/fabulosa-recheck/report.json'],
            ['selected-booking-retry', 'storage/app/accessibility/pa11y-2026-10-13/fabulosa-selected-retry/report.json'],
        ],
    },
    {
        name: 'Modern Luxury Builders', slug: 'modern-luxury-builders', expected: 26, revision: '40d09c1b5982af47db77b94fac1734c5c161314c',
        sources: [['final', 'storage/app/projects/modernluxurybuilders/.audit-artifacts/pa11y-2026-10-13/final/report.json']],
    },
    {
        name: 'Villa Magnifica', slug: 'villa-magnifica', expected: 182, revision: '79b9a338154030d73d75e0ff03147c80bc13978e',
        sources: [
            ['desktop-final', 'storage/app/projects/villamagnifica/.audit-artifacts/pa11y-2026-10-13/desktop-final/report.json'],
            ['mobile-final', 'storage/app/projects/villamagnifica/.audit-artifacts/pa11y-2026-10-13/mobile-final/report.json'],
            ['desktop-recheck', 'storage/app/projects/villamagnifica/.audit-artifacts/pa11y-2026-10-13/desktop-recheck/report.json'],
        ],
    },
];

const count = issues => ({
    confirmedErrors: issues.filter(issue => issue.type === 'error' && !issue.needsFurtherReview).length,
    warningLevelItems: issues.filter(issue => issue.type === 'warning').length,
    noticeLevelItems: issues.filter(issue => issue.type === 'notice').length,
    reportedErrorLevelItems: issues.filter(issue => issue.type === 'error').length,
    axeManualReviewItems: issues.filter(issue => issue.needsFurtherReview).length,
});

const siteExports = [];
for (const site of sites) {
    const states = new Map();
    const runs = [];
    for (const [label, source] of site.sources) {
        const run = read(source);
        if (!run.completed || run.results.length !== run.expectedStates) throw new Error(`${site.name}: unfinished ${label} run`);
        runs.push({ label, started: run.started, completed: run.completed, states: run.results.length });
        for (const row of run.results) {
            const issues = (row.issues || []).map(issue => ({
                code: issue.code, type: issue.type, runner: issue.runner,
                message: issue.message, selector: issue.selector,
                needsFurtherReview: Boolean(issue.runnerExtras?.needsFurtherReview),
            }));
            states.set(`${row.profile} ${row.url}`, {
                profile: row.profile, requestedUrl: row.url, finalUrl: row.finalUrl,
                httpStatus: row.httpStatus, documentTitle: row.documentTitle,
                browserScriptErrorCount: (row.pageErrors || []).length,
                sourceRun: label, sourceRunCompletedAt: run.completed,
                loadError: row.loadError || null,
                counts: count(issues), issues,
            });
        }
    }
    const results = [...states.values()].sort((a, b) => a.requestedUrl.localeCompare(b.requestedUrl) || a.profile.localeCompare(b.profile));
    if (results.length !== site.expected) throw new Error(`${site.name}: unexpected state count ${results.length}`);
    for (const row of results) {
        if (row.loadError || row.httpStatus !== 200 || row.counts.confirmedErrors || row.browserScriptErrorCount) throw new Error(`${site.name}: unresolved error at ${row.requestedUrl}`);
        if (row.issues.some(issue => issue.runner === 'axe' && !issue.needsFurtherReview)) {
            throw new Error(`${site.name}: confirmed axe finding at ${row.requestedUrl}`);
        }
    }
    const allIssues = results.flatMap(row => row.issues);
    const data = {
        site: site.name, auditDate: date, generated: new Date().toISOString(),
        format: 'Sanitized Pa11y CI results',
        tool: { name: 'pa11y-ci', version: '5.0.0', pa11yVersion: '10.0.0', runners: ['htmlcs', 'axe'], standard: 'WCAG2AA' },
        profiles: ['desktop', 'mobile'],
        applicationRevisionAfterFixes: site.revision,
        coverage: { publicUrls: site.expected / 2, testedStates: results.length },
        totals: count(allIssues),
        status: allIssues.length ? 'manual-review-remains' : 'no-reported-issues',
        interpretation: 'Confirmed errors exclude axe items explicitly marked needsFurtherReview. Original error, warning and notice levels are retained in each issue. No accessibility rule was disabled. Warnings/notices and needsFurtherReview items require assessment; zero confirmed errors does not establish full WCAG or ADA compliance.',
        scope: 'Live public pages on desktop and mobile. Form submissions and payment-intent creation/confirmation were blocked; the initialized Stripe iframe is covered by the separate earlier iframe audit. HTML snippets, private filesystem paths and payment-test data are excluded from this public export.',
        sourceRuns: runs,
        results,
    };
    siteExports.push({ filename: `${site.slug}-pa11y.json`, data });
}

fs.mkdirSync(output, { recursive: true });
for (const item of siteExports) {
    fs.writeFileSync(path.join(output, item.filename), JSON.stringify(item.data, null, 2) + '\n');
    console.log(JSON.stringify({ site: item.data.site, coverage: item.data.coverage, totals: item.data.totals, reportUrl: `https://villafabulosa.com/accessibility/reports/${date}/${item.filename}` }));
}
