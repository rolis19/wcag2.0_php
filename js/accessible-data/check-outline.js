var JSON_outlineInfo = {
    explanation:'Assistive technologies and some browsers provide mechanisms to present a list of headings to the user that allows users to jump to individual headings. Headings also provide visual clues that help to skim the page or find a specific section, this is especially useful for people that are easily distracted.',
    instruction: [
        '<h3>Instruction</h3>',
        'It is good practice to nest headings properly.',
        'When stepping down through headings, skipping levels should be avoided. That means that an &lt;h1&gt; is followed by an &lt;h1&gt; or &lt;h2&gt;, an &lt;h2&gt; is followed by a &lt;h2&gt; or &lt;h3&gt; etc'
    ],
    technique:[
        '<a href="https://www.w3.org/TR/WCAG20-TECHS/H42.html" target="_blank">H42</a>: Using h1-h6 to identify headings ',
        '<a href="https://www.w3.org/TR/WCAG20-TECHS/G141.html" target="_blank">G141</a>: Organizing a page using headings ',
        '<a href="https://www.w3.org/TR/WCAG20-TECHS/aria12.html" target="_blank">ARIA12</a>: Using role=heading to identify headings'
    ],
    tag:'<a class="btn btn-default btn-tag">Level A</a> <a class="btn btn-danger btn-tag">Level AAA</a> <a class="btn btn-primary btn-tag">Perceivable</a> <a class="btn btn-success btn-tag">Operable</a>',
    official: '<h4 class="subtitle">Algorithm on how to check Outline</h4>'+
    '<ol>'+
    '<li>Identifying informative non-text content (future link)</li>'+
    '</ol>'+
    '<a href="#" target="_blank">Accessibility for Outline</a>'
};