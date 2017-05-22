var JSON_img = {
    explanation:'Images considered as non-text content, provide text alternative (alt) for any non-text content so that it can be changed into other forms people need, such as large print, braille, speech, symbols etc.',
    instruction: [
        '<h3>Instruction</h3>',
        'Input value to represent the meaning of image (without "alt") and than click edit button.',
        'Incase image doesn\'t have any meaning to the user, then click "ignore".'
    ],
    technique:[
        '<a href="https://www.w3.org/TR/WCAG20-TECHS/H37.html" target="_blank">H37</a>: Using alt attributes on img elements',
        '<a href="https://www.w3.org/TR/WCAG20-TECHS/H67.html" target="_blank">H67</a>: Using null alt text and no title attribute on img elements for images that AT should ignore',
        '<a href="https://www.w3.org/TR/WCAG20-TECHS/H36.html" target="_blank">H36</a>: Using alt attributes on images used as submit button'
    ],
    tag:'<a class="btn btn-default btn-tag" href="#">Level A</a> <a class="btn btn-primary btn-tag" href="#">Perceivable</a>',
    official: '<h4 class="subtitle">Algorithm on how to check Images</h4>'+
    '<ol>'+
    '<li>Identifying informative non-text content (future link)</li>'+
    '</ol>'+
    '<a href="#" target="_blank">Accessibility for Image</a>'
};