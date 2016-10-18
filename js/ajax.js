function savaAjax(tag) {
    var info = $('#correct_'+tag).val();
    var position = $('#position_'+tag).val();
    $.ajax({
        method: "POST",
        url: "action.php",
        data: {name: info, index: position},
        success: function() {
            $(".img").remove();
        }
    });
}