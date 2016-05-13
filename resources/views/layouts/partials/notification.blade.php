<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-Token': $('meta[name="_token"]').attr('content')
        }
    });

    var App = {};

    App.notify = {
        message: function (message, type) {
            if ($.isArray(message)) {
                $.each(message, function (i, item) {
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

        danger: function (message) {
            App.notify.message(message, 'danger');
        },
        success: function (message) {
            App.notify.message(message, 'success');
        },
        info: function (message) {
            App.notify.message(message, 'info');
        },
        warning: function (message) {
            App.notify.message(message, 'warning');
        },
        validationError: function (errors) {
            $.each(errors, function (i, fieldErrors) {
                App.notify.danger(fieldErrors);
            });
        }
    };
    $('form .btn-danger').click(function (e) {
        return confirm("Are you sure you want to delete ?");
        e.preventDefault();
    });
</script>
