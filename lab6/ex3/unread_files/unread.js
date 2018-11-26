$(function () {

    if ($("iframe")) {
        $("iframe").addClass("uk-responsive-width");
        $("iframe").css("min-height", "300px");
    }

    var winHeight = $(window).height()
    var docHeight = $(document).height()

    var max = docHeight - winHeight;
    $("#progressBar").attr('max', max);

    $(document).on('scroll', function () {
        value = $(window).scrollTop();
        $("#progressBar").attr("value", value);
    });
    
    $(window).scroll(function(){                          
            if ($(this).scrollTop() > 50) {
                $('progress').fadeIn(500);
            } else {
                $('progress').fadeOut(500);
            }
        });

});