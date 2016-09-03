require(['jquery'], function ($) {
  var jsonBase      = wity_base_url + 'm/crs/json',
      refreshTimer  = 1, // In seconds
      $crs_app      = $('.wity-app-crs.wity-app-crs-index'),
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
      $heroes_list
        .find('li')
        .removeClass('target');

      if ('target' in result) {
        $heroes_list
          .find('li:nth-child(' + result.target + ')')
          .addClass('target');
      }

      // Refresh target kill count
      $players_list.empty();

      if ('players' in result) {
        var players = result.players;

        $.each(players, function (index, player) {
          var $player = $('<li>').addClass('player-' + (index + 1)).text(player.name + ' : ' + player.kills);

          $players_list.append($player);
        });
      }

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
    });
  }

  // When the DOM is ready
  $(function () {
    refreshContent();

    setInterval(refreshContent, refreshTimer * 1000);
  });
});
