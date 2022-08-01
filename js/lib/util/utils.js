'use strict';

function formatPluralValue(value, singular, plural = singular + 's') {
    return value.toLocaleString() + ' ' + (value === 1 ? singular : plural);
}

function formatReadableNumber(value, digits = 2) {
    let formatter = new Intl.NumberFormat(undefined, {minimumFractionDigits: digits, maximumFractionDigits: digits});
    return formatter.format(value);
}

function formatFileSize(value, factor, unit) {
    let str = formatReadableNumber(value/factor, factor === 1 ? 0 : 3);
    return str + " " + unit;
}
