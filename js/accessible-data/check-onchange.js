var JSON_onchangeInfo = {
    explanation:'It is important to note that the select item which is modified is after the trigger select element in the reading order ' +
    'of the Web page. This ensures that assistive technologies will pick up the change and users will encounter the new data when ' +
    'the modified element receives focus. This technique relies on JavaScript support in the user agent. ',
    instruction: [
        '<h3>Instruction How to fix</h3>',
        'Make sure that user did not find any difficulty after web page being changed'
    ],
    technique:[
        '<a href="https://www.w3.org/TR/WCAG20-TECHS/SCR19.html" target="_blank">SCR19</a>: Using an onchange event on a select element without causing a change of context'
    ],
    tag:'<a class="btn btn-danger btn-tag">Level AAA</a> <a class="btn btn-info btn-tag">Understandable</a>',
    official: '<h4 class="subtitle">Algorithm on how to check onChange</h4>'+
    '<ol>'+
    '<li>Identifying informative non-text content (future link)</li>'+
    '</ol>'+
    '<a href="#" target="_blank">Accessibility for onChange</a>'
};