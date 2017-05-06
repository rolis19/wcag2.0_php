var JSON_onchangeInfo = {
    explanation:'It is important to note that the select item which is modified is after the trigger select element in the reading order ' +
    'of the Web page. This ensures that assistive technologies will pick up the change and users will encounter the new data when ' +
    'the modified element receives focus. This technique relies on JavaScript support in the user agent. ',
    instruction: [
        '<h3>Instruction How to fix</h3>',
        'Instruction to fix  onchange() function'
    ],
    technique:[
        '<a href="https://www.w3.org/TR/WCAG20-TECHS/SCR19.html" target="_blank">SCR19</a>: Using an onchange event on a select element without causing a change of context'
    ],
    tag:'<a class="btn btn-danger btn-tag" href="#">Level AAA</a> <a class="btn btn-info btn-tag" href="#">Understandable</a>',
    official: '<h2>4. Icons</h2>'+
    '<p class="subtitle">4.1.1 Parsing</p>'+
    '<p>'+
    'In content implemented using markup languages, elements have complete start and end tags, elements are nested'+
    'according to their specifications, elements do not contain duplicate attributes, and any IDs are unique,'+
    'except where the specifications allow these features.'+
    '</p>'+
    '<a href="https://www.w3.org/WAI/WCAG20/quickref/?showtechniques=411" target="_blank" class="pull-right">Source</a>'
};