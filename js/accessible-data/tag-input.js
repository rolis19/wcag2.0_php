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
    ]
};