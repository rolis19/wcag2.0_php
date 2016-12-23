
var JSON_img = {
    explanation:'Images considered as non-text content, provide text alternative (alt) for any non-text content so that it can be changed into other forms people need, such as large print, braille, speech, symbols etc.',
    instruction: [
        'Input value to represent the meaning of image (without "alt") and than click edit button.',
        'Incase image doesn\'t have any meaning to the user, then click "ignore".'
    ],
    technique:[
        'H37: Using alt attributes on img elements',
        'H67: Using null alt text and no title attribute on img elements for images that AT should ignore',
        'H36: Using alt attributes on images used as submit button'
    ]
};
var JSON_input = {
    explanation:'Input without label value.',
    instruction: [
        'Input value to represent the meaning of image (without "alt") and than click edit button.',
        'Incase image doesn\'t have any meaning to the user, then click "ignore".'
    ],
    technique:[
        'H37: Using alt attributes on img elements',
        'H67: Using null alt text and no title attribute on img elements for images that AT should ignore',
        'H36: Using alt attributes on images used as submit button'
    ]
};

function showInfo(tag) {
    document.getElementById("explanation").innerHTML = "<p>"+eval("JSON_"+tag +".explanation")+"</p>";
    // document.getElementById("instruction").innerHTML = "<ul> <li>"+JSON_img.instruction[0]+"</li><li>"+JSON_img.instruction[1]+"</li> </ul>";
    document.getElementById("instruction").innerHTML = "<ul id='inst-list'></ul>";
    for(var x in eval("JSON_"+tag +".instruction")){
        $("ul#inst-list").append("<li>"+eval("JSON_"+tag +".instruction")[x]+"</li>");
    }
    document.getElementById("technique").innerHTML = "<ul id='techq-list'></ul>";
    for(var x in eval("JSON_"+tag +".technique")){
        $("ul#techq-list").append("<li>"+eval("JSON_"+tag +".technique")[x]+"</li>");
    }
}