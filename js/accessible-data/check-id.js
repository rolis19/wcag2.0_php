var JSON_idInfo = {
    explanation:'Duplicate ID in elements will cause problems for assistive technologies when they are trying to parse its content.',
    instruction: [
        '<h3>Instruction</h3>',
        'Modify the code manually so that every id will be unique'
    ],
    technique:[
        '<a href="https://www.w3.org/TR/WCAG20-TECHS/H94.html" target="_blank">H94</a>: Ensuring that elements do not contain duplicate attributes',
        '<a href="https://www.w3.org/TR/WCAG20-TECHS/H93.html" target="_blank">H93</a>: Ensuring that <samp>id</samp> attributes are unique on a Web page'
    ],
    tag:'<a class="btn btn-default btn-tag">Level A</a> <a class="btn btn-danger btn-tag">Robust</a>',
    official: '<h4 class="subtitle">Algorithm on how to check duplicate ID</h4>'+
    '<ol>'+
    '<li>Identifying informative non-text content (future link)</li>'+
    '</ol>'+
    '<a href="#" target="_blank">Accessibility for duplicate id</a>'
};