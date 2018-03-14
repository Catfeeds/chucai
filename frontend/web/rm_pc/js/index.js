$(function () {
    $('.nav li a').click(function () {
        $('html, body').animate({
            scrollTop: $($.attr(this, 'href')).offset().top -50
        }, 500);
        return false;
    });
    $('.down').click(function () {
        $('html, body').animate({
            scrollTop: $('#aboutUs').offset().top -50
        }, 500);
        return false;
    });
    $('aside').click(function () {
        $('html, body').animate({
            scrollTop: 0
        }, 500);
        return false;
    });
    $(window).scroll(function () {
        var $a = $('.navbar .navbar-nav > li > a');
        if($(document).scrollTop() > $('#aboutUs').offset().top -60){
            $('aside').show();
            $('.navbar-inverse').addClass('active');
            $('.navbar .navbar-nav > li > a').addClass('active');
            $('.navbar .navbar-header img:eq(0)').hide();
            $('.navbar .navbar-header img:eq(1)').show();
            $('.navbar-toggle .icon-bar').addClass('active');
            $('.navbar-inverse .navbar-toggle').css('background-color','#fff').css('transition','all 1s');
            $('.navbar-inverse .navbar-toggle').click(function () {
                $(this).css('background-color','#fff')
            });
        }else{
            $('.navbar-inverse').removeClass('active');
            $('.navbar .navbar-nav > li > a').removeClass('active');
            $('aside').hide();
            $('.navbar .navbar-header img:eq(1)').hide();
            $('.navbar .navbar-header img:eq(0)').show();
            $('.navbar-toggle .icon-bar').removeClass('active');
            $('.navbar-inverse .navbar-toggle').css('background-color','#000').css('transition','all 1s');
            $('.navbar-inverse .navbar-toggle').click(function () {
                $(this).css('background-color','#000')
            })
        }
        if($(document).scrollTop() > $('#aboutUs').offset().top -60 && $(document).scrollTop() < $('#serve').offset().top - 60){
            $a.removeClass('a_color');
            $a.eq(0).addClass('a_color')
        }else if( $(document).scrollTop() > $('#serve').offset().top - 60 && $(document).scrollTop() < $('#p_place').offset().top -60 || $(document).scrollTop() > $('#serve').offset().top - 60 && $(document).scrollTop() < $('#m_place').offset().top -60){
            $a.removeClass('a_color');
            $a.eq(1).addClass('a_color')
        }else if($(document).scrollTop() > $('#p_place').offset().top - 60 && $(document).scrollTop() < $('#club').offset().top -60){
            $a.removeClass('a_color');
            $a.eq(2).addClass('a_color');
            $a.eq(3).addClass('a_color')
        }else if($(document).scrollTop() > $('#club').offset().top - 60 && $(document).scrollTop() < $('#download').offset().top -60){
            $a.removeClass('a_color');
            $a.eq(4).addClass('a_color')
        }else if($(document).scrollTop() > $('#download').offset().top - 60 && $(document).scrollTop() < $('#partner').offset().top -60){
            $a.removeClass('a_color');
            $a.eq(5).addClass('a_color')
        }else if($(document).scrollTop() > $('#partner').offset().top - 60){
            $a.removeClass('a_color');
            $a.eq(6).addClass('a_color')
        }else {
            $a.removeClass('a_color');
        }
    })
});