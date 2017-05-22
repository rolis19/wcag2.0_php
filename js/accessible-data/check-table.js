var JSON_tableInfo = {
    explanation:'Tables used to present tabular information or matrix, and to have column or rows that show the meaning in the grid format. Someone that cannot see the table cannot make these visual associations, so proper markup must be used to make a programmatic association in table.',
    instruction: [
        '<h3>Instruction</h3>',
        'Table not used for decorative purpose',
        'Table must have th tag include with scope attribute',
        'Scope attribute indicate to whom the header belong'
    ],
    technique:[
        '<a href="https://www.w3.org/TR/WCAG20-TECHS/H51.html" target="_blank">H51</a>: Using table markup to present tabular information',
        '<a href="https://www.w3.org/TR/WCAG20-TECHS/H63.html" target="_blank">H63</a>: Using the scope attribute to associate header cells and data cells in data tables',
        '<a href="https://www.w3.org/TR/WCAG20-TECHS/H63.html" target="_blank">H43</a>: Using id and headers attributes to associate data cells with header cells in data tables'
    ],
    tag:'<a class="btn btn-default btn-tag">Level A</a> <a class="btn btn-primary btn-tag">Perceivable</a>',
    official: '<h4 class="subtitle">Algorithm on how to check Table</h4>'+
    '<ol>'+
    '<li>Identifying informative non-text content (future link)</li>'+
    '</ol>'+
    '<a href="#" target="_blank">Accessibility for Table</a>'
};