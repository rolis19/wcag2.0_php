var JSON_glyphInfo = {
    explanation:'When reading an icon assisistive technology may not find any content to read out to a user or it may  read the unicode equivalent, which could not match up to what the icon means in context, or worse is just plain confusing.',
    instruction: [
        '<h3>Instruction How to fix</h3>',
        'Ensure the purpose of your icon',
        'If it for pure decoration, re-emphasize or add styling to content already present in your ' +
        'HTML it does not need to be repeated to an assistive technology-using user. You can make sure ' +
        'this is not read by adding the <code>aria-hidden="true"</code>',
        'If you\'re using an icon to convey meaning (rather than only as a decorative element), ensure that ' +
        'this meaning is also conveyed to assistive technologies'
    ],
    tag:'<a class="btn btn-default btn-tag" href="#">Level A</a> <a class="btn btn-warning btn-tag" href="#">Level AA</a> <a class="btn btn-primary btn-tag" href="#">Perceivable</a>',
    technique:[
        '<a href="#">H93</a>: Ensuring that id attributes are unique on a web page'
    ],
    official: '<h2>4. Icons</h2>'+
            '<p class="subtitle">4.1.1 Parsing</p>'+
            '<p>'+
            'In content implemented using markup languages, elements have complete start and end tags, elements are nested'+
            'according to their specifications, elements do not contain duplicate attributes, and any IDs are unique,'+
            'except where the specifications allow these features.'+
            '</p>'+
            '<a href="https://www.w3.org/WAI/WCAG20/quickref/?showtechniques=411" target="_blank" class="pull-right">Source</a>'
};