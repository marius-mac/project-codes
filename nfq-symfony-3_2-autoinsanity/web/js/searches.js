// send ajax request to pin vehicle search
$('.vehicle-search-pin-button').click(function () {
    var button = $(this);
    var pin_action = button.hasClass('pin') ? 'pin' : 'unpin';
    $.ajax({
        url : Routing.generate('pin_vehicle_search', {id: button.val(), pinAction: pin_action}),
        type: 'POST',
        data : '',
        success: function(data) {
            if(data.error === 'auth-error') {
                button.popover({
                    'animation': true,
                    'html': true,
                    'placement': 'bottom',
                    'trigger': 'focus'
                })
                button.popover('show');
            }
            else if (typeof data.pin_action !== 'undefined') {
                button.removeClass(pin_action);
                if (data.pin_action === 'pin') {
                    button.html('<span class="glyphicon glyphicon-heart-empty"></span> ' + data.button_text);
                } else {
                    button.html('<span class="glyphicon glyphicon-heart"></span> <b>' + data.button_text + '</b>');
                }
                button.addClass(data.pin_action);
            }
        },
        error: function(data) {

        }
    });
});
