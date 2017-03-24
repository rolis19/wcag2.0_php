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
    tag:'<a class="btn btn-warning btn-tag" href="#">Leve A</a> <a class="btn btn-warning btn-tag" href="#">Robust</a>',
    official: '<h2>4. Icons</h2>'+
    '<p class="subtitle">4.1.1 Parsing</p>'+
    '<p>'+
    'In content implemented using markup languages, elements have complete start and end tags, elements are nested'+
    'according to their specifications, elements do not contain duplicate attributes, and any IDs are unique,'+
    'except where the specifications allow these features.'+
    '</p>'+
    '<a href="https://www.w3.org/WAI/WCAG20/quickref/?showtechniques=411" target="_blank" class="pull-right">Source</a>'
};