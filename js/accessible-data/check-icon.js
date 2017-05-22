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
    technique:[
        'Identifying informative non-text content (future link), Guideline 1.1.1 and 1.4.5'
    ],
    tag:'<a class="btn btn-default btn-tag">Level A</a> <a class="btn btn-warning btn-tag">Level AA</a> <a class="btn btn-primary btn-tag">Perceivable</a>',
    official: '<h4 class="subtitle">Algorithm on how to check Icon</h4>'+
    '<ol>'+
    '<li>Identifying informative non-text content (future link)</li>'+
    '</ol>'+
    '<a href="#" target="_blank">Accessibility for Icon</a>'
};