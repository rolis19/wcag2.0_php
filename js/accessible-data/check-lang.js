var JSON_langInfo = {
    explanation:'Language of the document allows braille translation software to substitute control codes for ' +
    'accented characters, and insert control codes necessary to prevent erroneous creation of Grade 2 braille contractions. ' +
    'And many other benefits',
    instruction: [
        '<h3>Instruction</h3>',
        'Use the lang attribute for pages served as HTML.',
        'and the xml:lang attribute for pages served as XML',
        'For XHTML 1.x and HTML5 polyglot documents, use both together.'
    ],
    technique:[
        '<a href="https://www.w3.org/TR/WCAG20-TECHS/H57.html" target="_blank">H57</a>: Using language attributes on the html element ',
        '<a href="https://www.w3.org/TR/WCAG20-TECHS/H58.html" target="_blank">H58</a>: Using language attributes to identify changes in the human language '
    ],
    tag:'<a class="btn btn-default btn-tag">Level A</a> <a class="btn btn-warning btn-tag">Level AA</a> <a class="btn btn-info btn-tag">Understandable</a>',
    official: '<h4 class="subtitle">Algorithm on how to check language</h4>'+
    '<ol>'+
    '<li>In content implemented using markup languages, elements have</li>'+
    '<li>complete start and end tags, elements are nested</li>'+
    '<li>according to their specifications, elements do not contain</li>'+
    '<li>except where the specifications allow these features.</li>'+
    '</ol>'+
    '<a href="#" target="_blank">Accessibility for Language</a>'
};