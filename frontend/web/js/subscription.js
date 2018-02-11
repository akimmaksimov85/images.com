$(document).ready(function () {
    $('a.button-subscribe').click(function () {
        var button = $(this);
        var params = {
            'id': $(this).attr('data-id')
        };
        $.post('/user/profile/subscribe', params, function (data) {
            if (data.success) {
                button.hide();
                button.siblings('.button-unsubscribe').show();
            }
        });
        return false;
    });

    $('a.button-unsubscribe').click(function () {
        var button = $(this);
        var params = {
            'id': $(this).attr('data-id')
        };
        $.post('/user/profile/unsubscribe', params, function (data) {
            if (data.success) {
                button.hide();
                button.siblings('.button-subscribe').show();
            }
        });
        return false;
    });
});