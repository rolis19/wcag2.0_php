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

function showNotif() {
    $(document).ready(function() {
        document.getElementById("b-error").className = "bub-danger";
        var sizeError = $('.col-md-6 .form-container').length;
        document.getElementById("b-error").innerHTML = sizeError;
        var size = $("#alert-list >li").length;
        document.getElementById("b-alert").className = "bub-alert";
        document.getElementById("b-alert").innerHTML = size;
    });
}

$(function() {                       //run when the DOM is ready
    $(".edit").click(function() {  //use a class, since your ID gets mangled
        if ($(this).hasClass("active")){
            $(this).removeClass("active");
        }else {
            $(this).addClass("active");
        }
    });
});


jQuery(function() {
    $('.content-correct').on('scroll', function () {
        $('.direct').each(function () {
            if(!$(this).find('a.edit').hasClass('collapsed')) {
                var pos = $(this).find('a.active').parent()[0].getBoundingClientRect();
                var pos1 = $(this).find('a.active').parent()[0].getBoundingClientRect();
                console.log(pos1);
                if(pos.top <= 100) {
                    $(this).find('a.active').parent().addClass('stacked');
                } else {
                    $(this).find('a.active').parent().removeClass('stacked');
                }
            }
        })
    });
    // $(document).on('scroll', function () {
    //     var nav_tab = document.getElementById('nav-tab');
    //     var nav_tabPos = nav_tab.getBoundingClientRect();
    //     var nav_tabBottom = nav_tabPos.bottom;
    //     console.log(nav_tabPos);
    // });
});
