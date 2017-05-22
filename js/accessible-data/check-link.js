var JSON_linkInfo = {
    explanation:'Links provided in-content help to navigate users throughout a website, providing clear, understandable and meaningful for link text is must to avoid confussion for user with screen reader and user who navigate with keyboard',
    instruction: [
        '<h3>Instruction</h3>',
        'Do not create link with no destination.',
        'Provide at least 3 words for link text or use aria-label instead',
        'Do not include any html character or symbol',
        'If inside link another element non text please use the correspondent element accessibility.'
    ],
    technique:[
        '<a href="https://www.w3.org/TR/WCAG20-TECHS/H91.html" target="_blank">H91</a>: Providing link text that describes the purpose of a link ',
        '<a href="https://www.w3.org/TR/WCAG20-TECHS/g94.html" target="_blank">G94</a>: Providing short text alternative for non-text content that serves the same purpose and presents the same information as the non-text content ',
        '<a href="https://www.w3.org/TR/WCAG20-TECHS/H30.html" target="_blank">H30</a>: Providing link text that describes the purpose of a link for anchor elements',
        '<a href="https://www.w3.org/TR/WCAG20-TECHS/aria8.html" target="_blank">ARIA8</a>: Using aria-label for link purpose '
    ],
    tag:'<a class="btn btn-default btn-tag">Level A</a> <a class="btn btn-danger btn-tag">Level AAA</a> <a class="btn btn-primary btn-tag">Perceivable</a> <a class="btn btn-success btn-tag">Operable</a>',
    official: '<h4 class="subtitle">Algorithm on how to check Link</h4>'+
    '<ol>'+
    '<li>Identifying informative non-text content (future link)</li>'+
    '</ol>'+
    '<a href="#" target="_blank">Accessibility for Link</a>'
};