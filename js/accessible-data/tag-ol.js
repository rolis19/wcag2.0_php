var JSON_olInfo = {
    explanation:'Ensure the use of <code>&lt;ol&gt;</code> not for decorative purpose, but it must convey meaning. When markup is used that ' +
    'visually formats items as a list but does not indicate the list relationship, users may have difficulty in navigating ' +
    'the information.',
    instruction: [
        '<h3>Instruction How to fix</h3>',
        'Ensure that ordered list not used for decorative purpose'
    ],
    technique:[
        '<a href="https://www.w3.org/TR/WCAG20-TECHS/T2.html" target="_blank">T2</a>: Using standard text formatting conventions for lists',
        '<a href="https://www.w3.org/TR/WCAG20-TECHS/H48.html" target="_blank">H48</a>: Using ol, ul and dl for lists or groups of links'
    ],
    tag:'<a class="btn btn-default btn-tag">Level A</a> <a class="btn btn-primary btn-tag">Perceivable</a>',
    official: '<h4 class="subtitle">Algorithm on how to check List</h4>'+
    '<ol>'+
    '<li>Identifying informative non-text content (future link)</li>'+
    '</ol>'+
    '<a href="#" target="_blank">Accessibility for list</a>'
};