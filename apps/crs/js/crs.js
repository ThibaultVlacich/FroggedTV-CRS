require(['jquery'], function ($) {
  var jsonBase      = wity_base_url + 'm/crs/json',
      refreshTimer  = 1, // In seconds
      $crs_app      = $('.wity-app-crs.wity-app-crs-index'),
      $heroes_list  = $crs_app.find('ul.heroes-list'),
      $players_list = $crs_app.find('ul.players-list'),
      $safari_timer = $crs_app.find('div.safari-timer');

  function refreshContent() {
    $.getJSON(jsonBase, function (json) {
      var result = json.result;

      // Display the target on the correct hero
      $heroes_list
        .find('li')
        .removeClass('target');

      $heroes_list
        .find('li:nth-child(' + result.target + ')')
        .addClass('target');

      // Refresh target kill count
      var players = result.players,
                i = 1;

      $players_list.empty();

      players.forEach(function (player) {
        $player = $('<li>').addClass('player-' + i).text(player.name + ' : ' + player.kills);

        $players_list.append($player);

        i++;
      });

      // Refresh safari timer
      var options = result.options;
      if ('timer' in options) {
        var timer = options.timer;

        $safari_timer
          .css('top', (parseInt($players_list.css('top'), 10) + parseInt($players_list.css('height'), 10) + 10) + 'px')
          .text('Safari : ' + timer);
      }
    });
  }

  // When the DOM is ready
  $(function () {
    refreshContent();

    setInterval(refreshContent, refreshTimer * 1000);
  });
});
