require(['jquery'], function ($) {
    var $players = $('.wity-app.wity-app-crs.wity-action-game').find('.form-group[data-player-id]');

    $.each($players, function (index, value) {
        var $player   = $(value),
            player_id = $player.attr('data-player-id');

        $player.on('click', '.add', function (event) {
            var $kills_input = $player.find('.kills');

            $.ajax(wity_base_url + 'm/admin/crs/kill_count/'+player_id+'/increase')
             .done(function() {
                 var new_kill_count = +$kills_input.val() + 1;

                 $kills_input.val(new_kill_count);
             });

            event.preventDefault();
            return false;
        });

        $player.on('click', '.minus', function (event) {
            var $kills_input = $player.find('.kills');

            $.ajax(wity_base_url + 'm/admin/crs/kill_count/'+player_id+'/decrease')
             .done(function() {
                 var new_kill_count = +$kills_input.val() - 1;

                 $kills_input.val(new_kill_count);
             });

            event.preventDefault();
            return false;
        });
    });

    $('.safari-start').on('click', function (event) {
        $(this).prop('disabled', true);

        var timeout = setInterval(function () {
            $.getJSON(wity_base_url + 'm/admin/crs/increment_timer', function (json) {
                if (!('result' in json)) {
                    return;
                }

                var timer = json.result.timer;

                $('.timer').val(timer);
            });
        }, 1000);

        $('.safari-end').prop('disabled', false);

        $('.safari-end').on('click', function (event) {
            clearInterval(timeout);

            $('.safari-start').prop('disabled', false);
            $('.safari-end').prop('disabled', true);

            event.preventDefault();
            return false;
        });

        event.preventDefault();
        return false;
    });
});
