var JSON_outlineInfo = {
    explanation:'Assistive technologies and some browsers provide mechanisms to present a list of headings to the user that allows users to jump to individual headings. Headings also provide visual clues that help to skim the page or find a specific section, this is especially useful for people that are easily distracted.',
    instruction: [
        '<h3>Instruction</h3>',
        'It is good practice to nest headings properly.',
        'When stepping down through headings, skipping levels should be avoided. That means that an &lt;h1&gt; is followed by an &lt;h1&gt; or &lt;h2&gt;, an &lt;h2&gt; is followed by a &lt;h2&gt; or &lt;h3&gt; etc'
    ],
    technique:[
        '<a href="https://www.w3.org/TR/WCAG20-TECHS/H42.html" target="_blank">H42</a>:Using h1-h6 to identify headings ',
        '<a href="https://www.w3.org/TR/WCAG20-TECHS/G141.html" target="_blank">G141</a>:Organizing a page using headings '
    ],
    official: '<h2>4. Robust</h2>'+
        '<p class="subtitle">4.1.1 Parsing</p>'+
        '<p>'+
        'In content implemented using markup languages, elements have complete start and end tags, elements are nested'+
        'according to their specifications, elements do not contain duplicate attributes, and any IDs are unique,'+
        'except where the specifications allow these features.'+
        '</p>'+
        '<a href="https://www.w3.org/WAI/WCAG20/quickref/?showtechniques=411" target="_blank" class="pull-right">Source</a>'
};