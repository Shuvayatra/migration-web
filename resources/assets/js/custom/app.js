$(function () {
    $('select').select2({placeholder: "Select", allowClear: true, theme: "classic"});
    $('#tags').select2({placeholder: "Select", allowClear: true, theme: "classic", tags: true})
    tinymce.init({
        selector: "textarea",
        theme: "modern",
        width: 700,
        height: 300,
        browser_spellcheck: true,
        fontsize_formats: "8pt 10pt 12pt 14pt 16pt 18pt 20pt 24pt 36pt",
        plugins: [
            "advlist autolink link image lists charmap  hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
            "save table contextmenu directionality template paste textcolor colorpicker"
        ],
        content_css: "css/content.css",
        toolbar: "insertfile undo redo | styleselect | fontsizeselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image |  media fullpage | forecolor backcolor",
    });
    $(document).on('change', '#post_type', function () {
        $('.content-type').hide();
        var field = $(this).val();
        $('.type-' + field).show();
    });
    $(document).on('click', '.post_type', function () {
        $('.content-type').hide();
        $(this).parent().siblings().removeClass('active');
        $(this).parent().addClass('active');
        var field = $(this).data('post-type');
        $('.post_type_value').val(field);
        $('.type-' + field).show();
    });
    $(document).on('click', '.delete', function (e) {
        e.preventDefault();
        $(this).parent().remove();
    });

    var hidWidth;
    var scrollBarWidths = 40;

    var widthOfList = function(){
        var itemsWidth = 0;
        $('.list li').each(function(){
            var itemWidth = $(this).outerWidth();
            itemsWidth+=itemWidth;
        });
        return itemsWidth;
    };

    var widthOfHidden = function(){
        return (($('.wrapper').outerWidth())-widthOfList()-getLeftPosi())-scrollBarWidths;
    };

    var getLeftPosi = function(){
        return $('.list').position().left;
    };

    var reAdjust = function(){
        if (($('.wrapper').outerWidth()) < widthOfList()) {
            $('.scroller-right').show();
        }
        else {
            $('.scroller-right').hide();
        }

        if (getLeftPosi()<0) {
            $('.scroller-left').show();
        }
        else {
            $('.item').animate({left:"-="+getLeftPosi()+"px"},'slow');
            $('.scroller-left').hide();
        }
    }

    reAdjust();

    $(window).on('resize',function(e){
        reAdjust();
    });

    $('.scroller-right').click(function() {

        $('.scroller-left').fadeIn('slow');
        $('.scroller-right').fadeOut('slow');

        $('.list').animate({left:"+="+widthOfHidden()+"px"},'slow',function(){

        });
    });

    $('.scroller-left').click(function() {

        $('.scroller-right').fadeIn('slow');
        $('.scroller-left').fadeOut('slow');

        $('.list').animate({left:"-="+getLeftPosi()+"px"},'slow',function(){

        });
    });

});
