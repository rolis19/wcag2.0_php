// Save img tag
$(document).on('click','#save_img',function(e) {
    var info = $('#correct_img').val();
    var tag = $('#value').val();
    var position = $('#position_img').val();
    $.ajax({
        method: "POST",
        url: "action.php",
        data: {name_img: info, index_img: position, tag: tag},
        success: function(status) {
            $( ".img" ).remove();
        }
    });
});

// Save input tag
$(document).on('click','#save_input',function(e) {
    var info = $('#correct_input').val();
    var tag = $('#value').val();
    var position = $('#position_input').val();
    $.ajax({
        method: "POST",
        url: "action.php",
        data: {name_input: info, index_input: position, tag: tag},
        success: function(status) {
            $( ".input" ).remove();
        }
    });
});
