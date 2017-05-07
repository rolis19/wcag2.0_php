var JSON_titleInfo = {
    explanation:'Title of document',
    instruction: [
        '<h3>Instruction</h3>',
        'Use the lang attribute for pages served as HTML.',
        'and the xml:lang attribute for pages served as XML',
        'For XHTML 1.x and HTML5 polyglot documents, use both together.'
    ],
    technique:[
        '<a href="https://www.w3.org/TR/WCAG20-TECHS/H57.html" target="_blank">H57</a>:Using language attributes on the html element ',
        '<a href="https://www.w3.org/TR/WCAG20-TECHS/H58.html" target="_blank">H58</a>:Using language attributes to identify changes in the human language '
    ],
    tag:'<a class="btn btn-default btn-tag" href="#">Level A</a> <a class="btn btn-danger btn-tag" href="#">Level AAA</a> <a class="btn btn-success btn-tag" href="#">Operable</a>',
    official: '<h2>4. Robust</h2>'+
    '<p class="subtitle">4.1.1 Parsing</p>'+
    '<p>'+
    'In content implemented using markup languages, elements have complete start and end tags, elements are nested'+
    'according to their specifications, elements do not contain duplicate attributes, and any IDs are unique,'+
    'except where the specifications allow these features.'+
    '</p>'+
    '<a href="https://www.w3.org/WAI/WCAG20/quickref/?showtechniques=411" target="_blank" class="pull-right">Source</a>'
};