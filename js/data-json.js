
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
var JSON_idInfo = {
    explanation:'Duplicate ID in elements will cause problems for assistive technologies when they are trying to parse its content.',
    instruction: [
        '<h3>Instruction</h3>',
        'Modify the code manually so that every id will be unique'
    ],
    technique:[
        '<a href="https://www.w3.org/TR/WCAG20-TECHS/H94.html" target="_blank">H94</a>: Ensuring that elements do not contain duplicate attributes',
        '<a href="https://www.w3.org/TR/WCAG20-TECHS/H93.html" target="_blank">H93</a>: Ensuring that <samp>id</samp> attributes are unique on a Web page'
    ],
    tag:'<a class="btn btn-warning btn-tag" href="#">Leve A</a> <a class="btn btn-warning btn-tag" href="#">Robust</a>'
};
var JSON_glyphInfo = {
    explanation:'When reading an icon assisistive technology may not find any content to read out to a user or it may  read the unicode equivalent, which could not match up to what the icon means in context, or worse is just plain confusing.',
    instruction: [
        '<h3>Instruction How to fix</h3>',
        'Ensure the purpose of your icon',
        'If it for pure decoration, re-emphasize or add styling to content already present in your ' +
        'HTML it does not need to be repeated to an assistive technology-using user. You can make sure ' +
        'this is not read by adding the <code>aria-hidden="true"</code>',
        'If you\'re using an icon to convey meaning (rather than only as a decorative element), ensure that ' +
        'this meaning is also conveyed to assistive technologies'
    ],
    technique:[
        '<a href="#">H93</a>: Ensuring that id attributes are unique on a web page'
    ]
};
var JSON_langInfo = {
    explanation:'Language of the document is important, It allows braille translation software to substitute control codes for ' +
    'accented characters, and insert control codes necessary to prevent erroneous creation of Grade 2 braille contractions. ' +
    'And many other benefits',
    instruction: [
        '<h3>Instruction How to fix</h3>',
        'Instruction to fix italic'
    ],
    technique:[
        '<a href="https://www.w3.org/TR/WCAG20-TECHS/H57.html" target="_blank">H57</a>:Using language attributes on the html element ',
        '<a href="https://www.w3.org/TR/WCAG20-TECHS/H58.html" target="_blank">H58</a>:Using language attributes to identify changes in the human language '
    ]
};
var JSON_italicInfo = {
    explanation:'Avoid using italic, Italics are a known problem for some people with dyslexia and the general advice has been to' +
    ' avoid italics (particularly large blocks of italic text) and instead use bold for emphasis.',
    instruction: [
        '<h3>Instruction How to fix</h3>',
        'Instruction to fix Italic style'
    ],
    technique:[
        'No specific WCAG 2.0 technique for italic, please refer to the guideline below'
    ]
};
var JSON_olInfo = {
    explanation:'Ensure the use of <code>&lt;ol&gt;</code> not for decoration only, but it must convey meaning. When markup is used that ' +
    'visually formats items as a list but does not indicate the list relationship, users may have difficulty in navigating ' +
    'the information.',
    instruction: [
        '<h3>Instruction How to fix</h3>',
        'Instruction to fix  Ordered list'
    ],
    technique:[
        '<a href="https://www.w3.org/TR/WCAG20-TECHS/T2.html" target="_blank">T2</a>: Using standard text formatting conventions for lists',
        '<a href="https://www.w3.org/TR/WCAG20-TECHS/H48.html" target="_blank">H48</a>: Using ol, ul and dl for lists or groups of links'
    ]
};
var JSON_onchangeInfo = {
    explanation:'It is important to note that the select item which is modified is after the trigger select element in the reading order ' +
    'of the Web page. This ensures that assistive technologies will pick up the change and users will encounter the new data when ' +
    'the modified element receives focus. This technique relies on JavaScript support in the user agent. ',
    instruction: [
        '<h3>Instruction How to fix</h3>',
        'Instruction to fix  onchange() function'
    ],
    technique:[
        '<a href="https://www.w3.org/TR/WCAG20-TECHS/SCR19.html" target="_blank">SCR19</a>: Using an onchange event on a select element without causing a change of context'
    ]
};

function showInfo(tag) {
    $("#instruction").html("");
    var tag_info;
    var res = tag.substring(tag.length-4, tag.length);
    if (res == 'True'){
        tag_info = tag.substring(0, tag.length-4);
    }else {
        tag_info = tag;
        document.getElementById("instruction").innerHTML = eval("JSON_"+tag_info +".instruction")[0];
        $("#instruction").append ("<ul id='inst-list'></ul>");
        var n;
        for(n=1; n < eval("JSON_"+tag_info +".instruction").length; n++){
            $("ul#inst-list").append("<li>"+eval("JSON_"+tag_info +".instruction")[n]+"</li>");
        }
    }
    document.getElementById("explanation").innerHTML = "<h3>Explanation</h3>";
    $("#explanation").append("<p>"+eval("JSON_"+tag_info +".explanation")+"</p>");
    $("#explanation").append(eval("JSON_"+tag_info +".tag"));

    document.getElementById("technique").innerHTML = "<h3>WCAG 2.0 Technique</h3><ul id='techq-list'></ul>";
    for(var x in eval("JSON_"+tag_info +".technique")){
        $("ul#techq-list").append("<li>"+eval("JSON_"+tag_info +".technique")[x]+"</li>");
    }
}