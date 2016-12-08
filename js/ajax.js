// Save img tag

function runAjax() {
    var identifier = document.getElementById("identifier").innerHTML;
    var values = {
        'name': $('#correct_'+identifier).val(),
        'index': $('#position_'+identifier).val()
    };
    $.ajax({
        method: "POST",
        url: "action.php",
        data: values,
        success: function(status) {
            $( '.'+identifier ).remove();
        }
    });
}

