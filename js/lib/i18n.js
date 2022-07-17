/**
 * Collection of translation strings passed from WP
 */

/**
 * Returns the translations for the app.
 * @returns object
 */
export function i18n() {
    /* global stockMan, Object passed via EP Enqueue */
    return stockMan.i18n;
}