var JSON_img = {
    explanation:'Images considered as non-text content, provide text alternative (alt) for any non-text content so that it can be changed into other forms people need, such as large print, braille, speech, symbols etc.',
    instruction: [
        '<h3>Instruction</h3>',
        'Input value to represent the meaning of image (without "alt") and than click edit button.',
        'Incase image doesn\'t have any meaning to the user, then click "ignore".'
    ],
    technique:[
        'H37: Using alt attributes on img elements',
        'H67: Using null alt text and no title attribute on img elements for images that AT should ignore',
        'H36: Using alt attributes on images used as submit button'
    ]
};