// Pa11y CI's reporter factory receives callbacks from the local audit harness.
module.exports = options => ({
    results: options.results,
    error: options.error,
});
