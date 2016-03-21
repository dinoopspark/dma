$(function () {

    var base_url = 'http://localhost/dma';

    $(".row-delete").click(function () {
        var $this = $(this);

        var action = $(this).attr("data-action");

        if (action == "user_delete") {
            var user_id = $(this).attr("data-id");
            var data = {action: action, user_id: user_id};

            $.get(dmaGlobal.ajax_url, data, function (response) {
                if (response) {
                    $this.parents("tr").remove();
                }

            });
        }



    });


    $(".ajax-form-submit").click(function (e) {
        e.preventDefault();
        var $form = $(this).parents('form');
        var form_data = $form.serialize();

        $.post(dmaGlobal.ajax_url, form_data, function (response) {

            $form.display_form_msg(response);

        }, 'json');
    });
});


jQuery.fn.extend({
    display_form_msg: function (response) {
        var $alert = $(this).prev('.alert');

        if ($alert.length == 0) {
            $(this).before('<div class="alert alert-' + response.type + '">' + response.message + '</div>');
        } else {
            $alert.remove();
            $(this).before('<div class="alert alert-' + response.type + '">' + response.message + '</div>');
        }

    }
});