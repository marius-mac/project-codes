// automatically submit the search form when type of sort is changed
$('#sort_type').change(function () {
    this.form.submit();
});

// send ajax request to pin vehicle
$('.vehicle-pin-button').click(function () {
    var button = $(this);
    var pin_action = button.hasClass('pin') ? 'pin' : 'unpin';
    $.ajax({
        url : Routing.generate('pin_vehicle', {id: button.val(), pinAction: pin_action}),
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
