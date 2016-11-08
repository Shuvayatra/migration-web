$(document).ready(function () {
    $('select').select2({width: '100%',placeholder: "Select", allowClear: true, theme: "classic"});
    $('#tags').select2({placeholder: "Select", allowClear: true, theme: "classic", tags: true});

    var editor_config = {
        path_absolute : "/",
        mode : "textareas",
        editor_selector : "tinymce",
        editor_deselector : "mceNoEditor",
        plugins: [
            "advlist autolink lists link image charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code fullscreen",
            "insertdatetime media nonbreaking save table contextmenu directionality",
            "emoticons template paste textcolor colorpicker textpattern"
        ],
        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
        relative_urls: false,
        file_browser_callback : function(field_name, url, type, win) {
            var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
            var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

            var cmsURL = editor_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;
            if (type == 'image') {
                cmsURL = cmsURL + "&type=Images";
            } else {
                cmsURL = cmsURL + "&type=Files";
            }

            tinyMCE.activeEditor.windowManager.open({
                file : cmsURL,
                title : 'Filemanager',
                width : x * 0.8,
                height : y * 0.8,
                resizable : "yes",
                close_previous : "no"
            });
        }
    };

    tinymce.init(editor_config);

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

    $(".pagination").each(function(){
        var dis = $(this);
        if ( dis.text().length == 0 || dis.val() == "  "  ) {
            dis.hide();
        }
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
        if($('.list').position()){
            return $('.list').position().left;
        }
        return 0;
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
