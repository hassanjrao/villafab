const fs = require('fs');
const path = require('path');
const { createRequire } = require('module');

const config = JSON.parse(fs.readFileSync(process.argv[2], 'utf8').replace(/^\uFEFF/, ''));
const ciPath = process.env.PA11Y_CI_PATH || 'C:/nvm4w/nodejs/node_modules/pa11y-ci';
const ciRequire = createRequire(path.join(ciPath, 'package.json'));
const pa11yCi = ciRequire(ciPath);
const puppeteer = ciRequire('puppeteer');
const chromeLaunchConfig = {
    executablePath: process.env.CHROME_PATH || 'C:/Program Files/Google/Chrome/Application/chrome.exe',
    headless: true,
};
const urls = config.urls || config.routes.map(route => new URL(route, config.base).href);
const states = (config.profiles || ['desktop', 'mobile']).flatMap(profile => urls.map(url => ({ profile, url })));
const output = path.resolve(config.output);
fs.mkdirSync(output, { recursive: true });

const report = {
    started: new Date().toISOString(), site: config.site,
    pa11yCiVersion: ciRequire('./package.json').version,
    pa11yVersion: ciRequire('pa11y/package.json').version,
    standard: 'WCAG2AA', runners: ['htmlcs', 'axe'],
    includeWarnings: true, includeNotices: true,
    expectedStates: states.length,
    scope: 'Live public pages; payment-intent creation, payment confirmation and non-GET form submissions are blocked. The initialized Stripe iframe is excluded from these broad scans.',
    results: [],
};

const persist = () => {
    const file = path.join(output, 'report.json');
    const temporary = path.join(output, `report-${process.pid}.tmp`);
    fs.writeFileSync(temporary, JSON.stringify(report, null, 2) + '\n');
    fs.renameSync(temporary, file);
};
const key = state => `${state.profile} ${state.url}`;
const counts = issues => ({
    errors: issues.filter(issue => issue.type === 'error' && !issue.runnerExtras?.needsFurtherReview).length,
    warnings: issues.filter(issue => issue.type === 'warning' && !issue.runnerExtras?.needsFurtherReview).length,
    notices: issues.filter(issue => issue.type === 'notice' && !issue.runnerExtras?.needsFurtherReview).length,
    manualReview: issues.filter(issue => issue.runnerExtras?.needsFurtherReview).length,
});

(async () => {
    const browser = await puppeteer.launch(chromeLaunchConfig);
    try {
        for (let offset = 0; offset < states.length; offset += config.batchSize || 4) {
            const batch = states.slice(offset, offset + (config.batchSize || 4));
            const live = new Map();
            const jobs = [];
            for (const state of batch) {
                const page = await browser.newPage();
                const metadata = { ...state, pageErrors: [], failedRequests: [], blockedRequests: [] };
                live.set(key(state), metadata);
                page.on('response', response => {
                    const request = response.request();
                    if (request.isNavigationRequest() && request.frame() === page.mainFrame()) {
                        metadata.httpStatus = response.status();
                        metadata.finalUrl = response.url();
                    }
                });
                page.on('pageerror', error => metadata.pageErrors.push(error.message));
                page.on('requestfailed', request => {
                    if (!metadata.blockedRequests.includes(request.url())) {
                        metadata.failedRequests.push({ url: request.url(), error: request.failure()?.errorText });
                    }
                });
                await page.setRequestInterception(true);
                page.on('request', request => {
                    const url = request.url();
                    if (/\/booking\/payment-intent(?:\?|$)|\/payment_intents\/[^/]+\/confirm(?:\?|$)|\/g\/collect(?:\?|$)/.test(url) || !['GET', 'HEAD', 'OPTIONS'].includes(request.method())) {
                        metadata.blockedRequests.push(url);
                        void request.abort();
                    } else {
                        void request.continue();
                    }
                });
                jobs.push({
                    ...state, page,
                    viewport: state.profile === 'mobile'
                        ? { width: 375, height: 812, isMobile: true, deviceScaleFactor: 1 }
                        : { width: 1280, height: 900, deviceScaleFactor: 1 },
                });
            }
            try {
                await pa11yCi(jobs, {
                    chromeLaunchConfig,
                    concurrency: config.concurrency || 2,
                    timeout: config.timeout || 90000,
                    wait: config.wait || 1200,
                    standard: report.standard, runners: report.runners,
                    includeWarnings: true, includeNotices: true,
                    threshold: 0,
                    reporters: [[path.join(__dirname, 'pa11y-capture.cjs'), {
                        results(result, job) {
                            const metadata = live.get(key(job));
                            const issues = result.issues;
                            const row = { ...metadata, finalUrl: result.pageUrl, documentTitle: result.documentTitle, counts: counts(issues), issues };
                            report.results.push(row);
                            persist();
                            console.log(`${report.results.length}/${states.length} ${job.profile} ${job.url}: ${row.counts.errors} errors, ${row.counts.warnings} warnings, ${row.counts.manualReview} manual-review items`);
                        },
                        error(error, url, job) {
                            report.results.push({ ...live.get(key(job)), loadError: error.message });
                            persist();
                            console.log(`${report.results.length}/${states.length} ${job.profile} ${url}: RUN ERROR ${error.message}`);
                        },
                    }]],
                });
            } finally {
                await Promise.all(jobs.map(job => job.page.close().catch(() => {})));
            }
        }
    } finally {
        await browser.close();
    }
    report.completed = new Date().toISOString();
    report.totals = {
        states: report.results.length,
        loadErrors: report.results.filter(row => row.loadError || row.httpStatus !== 200).length,
        errors: report.results.reduce((sum, row) => sum + (row.counts?.errors || 0), 0),
        warnings: report.results.reduce((sum, row) => sum + (row.counts?.warnings || 0), 0),
        notices: report.results.reduce((sum, row) => sum + (row.counts?.notices || 0), 0),
        manualReview: report.results.reduce((sum, row) => sum + (row.counts?.manualReview || 0), 0),
    };
    persist();
    console.log(JSON.stringify(report.totals));
    process.exitCode = report.totals.loadErrors || report.totals.errors || report.results.length !== states.length ? 2 : 0;
})().catch(error => {
    console.error(error.message);
    process.exitCode = 1;
});
