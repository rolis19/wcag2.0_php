// Save img tag

function runAjax(identify) {
    var values = {
        'name': $('#correct_'+identify).val(),
        'index': $('#position_'+identify).val()
    };
    $.ajax({
        method: "POST",
        url: "action.php",
        data: values,
        success: function(status) {
            $( '.'+identify ).remove();
            var size = $('.col-md-6 .form-container').length;
            if (size === 0) {
                alert("Download button just get activated");
                $("#download").removeClass("disabled");
            }
        }
    });
    console.log(identify);
    return false;
}

function runIgnore(identify) {
    var values = {
        'name': "Ignore",
        'index': $('#position_'+identify).val()
    };
    $.ajax({
        method: "POST",
        url: "action.php",
        data: values,
        success: function(status) {
            $( '.'+identify ).remove();
        }
    });
    console.log(identify);
    return false;
}

function revealInfo(idset, tag) {
    var bodyEl = document.body;
    var content = document.querySelector( '.content-wrap' );
    var openbtn = document.getElementById(idset);
    var closebtn = document.getElementById( 'close-button' );
    var isOpen = false;
    toggleMenu();
    function init() {
        initEvents();
    }
    function initEvents() {
        if( closebtn ) {
            closebtn.addEventListener( 'click', toggleMenu );
        }
        content.addEventListener( 'click', function(ev) {
            showInfo(tag);
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

function toLine(ln) {
    $.smoothScroll({
        offset: -200,
        scrollElement: $('div.showcode-container'),
        scrollTarget: '#line'+ln,
        beforeScroll: function(options) {
            $('.line').removeClass("active");
        },
        afterScroll: function(options) {
            $('#line'+ln).addClass("active");
        }
    });
    return false;
}