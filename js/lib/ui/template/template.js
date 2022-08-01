'use strict';

function renderHandlebarsTemplate(templateId, targetId, data = {}) {
    let source = $(templateId).html();
    let template = Handlebars.compile(source);
    let html = template(data);

    $(targetId).html(html);
}
