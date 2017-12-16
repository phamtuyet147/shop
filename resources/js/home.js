/**
 * @suppress JSUnusedLocalSymbols, JSUnresolvedFunction, JSUnresolvedVariable
 */
// 2. This code loads the IFrame Player API code asynchronously.
var tag = document.createElement('script');

tag.src = 'https://www.youtube.com/iframe_api';
var firstScriptTag = document.getElementsByTagName('script')[0];
firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

// 3. This function creates an <iframe> (and YouTube player)
//    after the API code downloads.
var player;

function onYouTubeIframeAPIReady() {
    player = new YT.Player('intro-video', {
        height: window.innerHeight -
        document.getElementsByTagName('nav')[0].clientHeight - 10,
        width: document.getElementById('intro').clientWidth,
        videoId: 'yerpsHuFKAE',
        playerVars: {
            autoplay: 1,
            cc_load_policy: 1,
            color: 'white',
            controls: 0,
            disablekb: 1,
            fs: 0,
            iv_load_policy: 3,
            rel: 0,
            showinfo: 0
        },
        events: {
            'onReady': onPlayerReady
            /*'onStateChange': onPlayerStateChange,*/
        }
    });
}

// 4. The API will call this function when the video player is ready.
function onPlayerReady(event) {
    event.target.playVideo();
    event.target.mute();
}

// 5. The API calls this function when the player's state changes.
//    The function indicates that when playing a video (state=1),
//    the player should play for six seconds and then stop.
var done = false;

function onPlayerStateChange(event) {
    if (event.data === YT.PlayerState.PLAYING && !done) {
        setTimeout(stopVideo, 6000);
        done = true;
    }
}

function stopVideo() {
    player.stopVideo();
}

$(document).ready(function () {
    var $window = $(window);
    var $animation_elements = $('.animation-element');

    $animation_elements.css({"min-height": $window.height()});
    check_if_in_view();

    function check_if_in_view() {
        var window_height = $window.height();
        var window_top_position = $window.scrollTop();
        var window_bottom_position = (window_top_position + window_height);

        $.each($animation_elements, function () {
            var $element = $(this);
            var element_height = $element.outerHeight();
            var element_top_position = $element.offset().top;
            var element_bottom_position = (element_top_position + element_height);

            //check to see if this current container is within viewport
            if ((element_bottom_position >= window_top_position) &&
                (element_top_position <= window_bottom_position)) {
                if (window_top_position === 0) {
                    if (typeof player !== 'undefined') {
                        player.playVideo();
                    }
                }
                else {
                    if (typeof player !== 'undefined') {
                        player.playVideo();
                    }
                }
                $element.addClass('in-view');
            } else {
                $element.removeClass('in-view');
            }
        });
    }

    $window.on('scroll resize', check_if_in_view);
    $window.trigger('scroll');

    $('#scrollBtn').find('a').on('click', function (event) {
        event.preventDefault();
        var id = $(this).attr('href');
        var element = $(id);
        element.addClass('in-view');
        setTimeout(function () {
            $('html, body').animate({scrollTop: element.offset().top}, 2000)
        }, 650);
    })
});