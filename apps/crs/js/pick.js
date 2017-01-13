require(['jquery'], function ($) {
    var portrait_video_url = wity_base_url + '/apps/crs/front/video/portrait.mp4';

    $('.wity-app-crs.wity-app-crs-pick video').on('click', function(event) {
        var video_url = wity_base_url + '/apps/crs/front/video/' + $(this).attr('data-portrait-video');

        if ($(this).attr('data-is-showed') == 'true') {
            $(this).attr('src', portrait_video_url);

            $(this).attr('data-is-showed', 'false');
        } else {
            $(this).attr('src', video_url);

            $(this).attr('data-is-showed', 'true');
        }
    });
});
