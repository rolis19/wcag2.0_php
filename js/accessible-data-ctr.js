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