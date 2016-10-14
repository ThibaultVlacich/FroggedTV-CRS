require(['jquery'], function ($) {
    var firstLoading  = true,
        jsonBase      = wity_base_url + 'm/crs',
        refreshTimer  = 1, // In seconds
        $crs_app      = $('.wity-app-crs.wity-app-crs-overlay'),
        $heroes_list  = $crs_app.find('ul.heroes-list'),
        $players_list = $crs_app.find('ul.players-list'),
        $safari_timer = $crs_app.find('div.safari-timer');

    function refreshContent() {
        $.getJSON(jsonBase, function (json) {
            if (!('result' in json)) {
                return;
            }

            var result = json.result;

            // Display the target on the correct hero
            loadTarget(result);

            // Refresh target kill count
            if (firstLoading) {
                $players_list.children().fadeOut(500, function () {
                    $players_list.empty();
                    loadPlayers(result);
                    loadOptions(result);
                });
            } else {
                $players_list.empty();
                loadPlayers(result);
                loadOptions(result);
            }

            firstLoading = false;
        });
    }

    function loadTarget(result) {
        $heroes_list
            .find('li')
            .removeClass('target transition');

        if ('target' in result) {
            $heroes_list
                .find('li:nth-child(' + result.target + ')')
                .addClass(function () {
                    return 'target' + (firstLoading ? ' transition' : '');
                });
        }
    }

    function loadPlayers(result) {
        if ('players' in result) {
            var players = result.players;

            $.each(players, function (index, player) {
                var $player = $('<li>').addClass('player-' + (index + 1)).text(player.name + ' : ' + player.kills);

                $players_list.append($player);
            });
        }
    }

    function loadOptions(result) {
        // Refresh safari timer
        if ('options' in result) {
            var options = result.options;

            if ('timer' in options) {
                var timer = options.timer;

                $safari_timer
                    .css('top', (parseInt($players_list.css('top'), 10) + parseInt($players_list.css('height'), 10) + 10) + 'px')
                    .text('Safari : ' + timer);
            }
        }
    }

    var current_link = 0;
    function animateLinks() {
        var $links        = $crs_app.find('ul.links'),
            numberOfLinks = $links.find('li').length;

        $links.find('li:eq(' + current_link + ')')
              .animate({'opacity' : '1'}, 1000)
              .animate({'opacity' : '1'}, 10000)
              .animate({'opacity' : '0'}, 1000, function() {
                    (current_link == numberOfLinks - 1) ? (current_link = 0) : (current_link += 1);
                    animateLinks();
              });
    }

    // When the DOM is ready
    $(function () {
        setInterval(refreshContent, refreshTimer * 1000);

        animateLinks();
    });
});
