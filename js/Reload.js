class Reload {

    // Reload page if rendered from browser cache
    static ifPageLoadedFromCached() {
        const isCached = window.performance.getEntriesByType("navigation")[0].transferSize === 0;
        if (isCached) window.location.reload();
    }

}