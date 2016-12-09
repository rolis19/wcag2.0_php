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

function revealInfo(idset) {
    var bodyEl = document.body;
    var content = document.querySelector( '.content-wrap' );
    var openbtn = document.getElementById(idset);
    var closebtn = document.getElementById( 'close-button' );
        isOpen = false;
    toggleMenu();
    function init() {
        initEvents();
    }
    function initEvents() {
        if( closebtn ) {
            closebtn.addEventListener( 'click', toggleMenu );
        }
        content.addEventListener( 'click', function(ev) {
            var target = ev.target;
            if( isOpen && target !== openbtn ) {
                toggleMenu();
            }
        } );
    }
    function toggleMenu() {
        if( isOpen ) {
            classie.remove( bodyEl, 'show-menu' );
        }
        else {
            classie.add( bodyEl, 'show-menu' );
        }
        isOpen = !isOpen;
    }
    init();
}