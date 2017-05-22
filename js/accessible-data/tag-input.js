var JSON_input = {
    explanation:' Associating input label will help screen reader in refering input form, additional benefit is a larger clickable area for the control, since clicking on the label or the control will activate the control. This can be helpful for users with impaired motor control.',
    instruction: [
        '<h3>Instruction</h3>',
        'Associating done by setting both "for" in label and "id" in input to the same value.',
        'If visible label cannot be used, add "aria-label" attribute to describe the use of input.'
    ],
    technique:[
        '<a href="https://www.w3.org/TR/WCAG20-TECHS/H44.html" target="_blank">H44</a>: Using label elements to associate text labels with form controls',
        '<a href="https://www.w3.org/TR/WCAG20-TECHS/aria14.html" target="_blank">ARIA14</a>: Using aria-label to provide an invisible label where a visible label cannot be used ',
        '<a href="https://www.w3.org/TR/WCAG20-TECHS/aria6.html" target="_blank">ARIA6</a>: Using aria-label to provide labels for objects '
    ],
    tag:'<a class="btn btn-default btn-tag">Level A</a> <a class="btn btn-primary btn-tag">Perceivable</a> <a class="btn btn-info btn-tag">Understandable</a> <a class="btn btn-danger btn-tag">Robust</a>',
    official: '<h4 class="subtitle">Algorithm on how to check Input</h4>'+
    '<ol>'+
    '<li>Identifying informative non-text content (future link)</li>'+
    '</ol>'+
    '<a href="#" target="_blank">Accessibility for Input</a>'
};