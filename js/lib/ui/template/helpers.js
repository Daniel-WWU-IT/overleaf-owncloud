'use strict';

Handlebars.registerHelper('formatNumber', function (num) {
    return num.toLocaleString();
});

Handlebars.registerHelper('formatArray', function (arr, delim) {
    return arr.join(delim);
});

Handlebars.registerHelper( 'when',function(op1, operator, op2, options) {
    let operators = {
        'eq': function(l,r) { return l === r; },
        'neq': function(l,r) { return l !== r; },
        'gt': function(l,r) { return Number(l) > Number(r); },
        'or': function(l,r) { return l || r; },
        'and': function(l,r) { return l && r; },
        '%': function(l,r) { return (l % r) === 0; }
    };

    if (operators[operator](op1, op2)) {
        return options.fn(this);
    } else {
        return options.inverse(this);
    }
});
