var JSON_input = {
    explanation:'Input without label value.',
    instruction: [
        '<h3>Instruction</h3>',
        'Input value to represent the meaning of image (without "alt") and than click edit button.',
        'Incase image doesn\'t have any meaning to the user, then click "ignore".'
    ],
    technique:[
        'H37: Using alt attributes on img elements',
        'H67: Using null alt text and no title attribute on img elements for images that AT should ignore',
        'H36: Using alt attributes on images used as submit button'
    ],
    official: '<h2>4. Icons</h2>'+
    '<p class="subtitle">4.1.1 Parsing</p>'+
    '<p>'+
    'In content implemented using markup languages, elements have complete start and end tags, elements are nested'+
    'according to their specifications, elements do not contain duplicate attributes, and any IDs are unique,'+
    'except where the specifications allow these features.'+
    '</p>'+
    '<a href="https://www.w3.org/WAI/WCAG20/quickref/?showtechniques=411" target="_blank" class="pull-right">Source</a>'
};