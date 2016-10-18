$(document).on('click','#save',function(e) {
    var info = $('#correct').val();
    var position = $('#position').val();
    $.ajax({
        method: "POST",
        url: "action.php",
        data: {name: info, index: position},
        success: function(status) {
            $('#correct').val('');
            $( ".img" ).remove();
        }
    });
});