
$.ajaxSetup({
    headers: {
        'X-CSRF-Token': $('meta[name="_token"]').attr('content')
    }
});

var App = {};

App.notify = {
    message: function(message, type){
        if ($.isArray(message)) {
            $.each(message, function(i, item){
                App.notify.message(item, type);
            });
        } else {
            $.bootstrapGrowl(message, {
                type: type,
                delay: 4000,
                width: 'auto'
            });
        }
    },

    danger: function(message){
        App.notify.message(message, 'danger');
    },
    success: function(message){
        App.notify.message(message, 'success');
    },
    info: function(message){
        App.notify.message(message, 'info');
    },
    warning: function(message){
        App.notify.message(message, 'warning');
    },
    validationError: function(errors){
        $.each(errors, function(i, fieldErrors){
            App.notify.danger(fieldErrors);
        });
    }
};

/**
 * @param  {*} requestData
 */
var changePosition = function(requestData){

    $.ajax({
        'url': '/sort',
        'type': 'POST',
        'data': requestData,
        'success': function(data) {
            if (data.success) {
                App.notify.success('Saved!');
            } else {
                App.notify.validationError(data.errors);
            }
        },
        'error': function(){
            App.notify.danger('Something wrong!');
        }
    });
};

$(document).ready(function(){
    var $sortableTable = $('.sortable');
    if ($sortableTable.length > 0) {
        $sortableTable.sortable({
            handle: '.sortable-handle',
            axis: 'y',
            update: function(a, b){

                var entityName = $(this).data('entityname');
                var $sorted = b.item;

                var $previous = $sorted.prev();
                var $next = $sorted.next();

                if ($previous.length > 0) {
                    changePosition({
                        parentId: $sorted.data('parentid'),
                        type: 'moveAfter',
                        entityName: entityName,
                        id: $sorted.data('itemid'),
                        positionEntityId: $previous.data('itemid')
                    });
                } else if ($next.length > 0) {
                    changePosition({
                        parentId: $sorted.data('parentid'),
                        type: 'moveBefore',
                        entityName: entityName,
                        id: $sorted.data('itemid'),
                        positionEntityId: $next.data('itemid')
                    });
                } else {
                    App.notify.danger('Something wrong!');
                }
            },
            cursor: "move"
        });
    }
    $('.sortable td').each(function(){
        $(this).css('width', $(this).width() +'px');
    });
});