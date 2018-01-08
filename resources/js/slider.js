$.fn.slider = function (timer) {
    $(this).css({
        'position': 'relative',
        'transition': 'all .1s',
        '-o-transition': 'all .1s',
        '-webkit-transition': 'all .1s',
        '-moz-transition': 'all .1s'
    });
    $(this).find('img').css({
        'position': 'absolute',
        'top': '0',
        'left': '0',
        'display': 'none'
    });
    $(this).find('img:first-child').show().addClass('slide-show');

    var html = '<div class="slide-switcher" style="opacity: 0.5;">' +
        '<div style="position: absolute; bottom: 10px; left: 0; width: 100%; text-align: center;">';
    $(this).find('img').each(function (index, item) {
        html += '<a href="' + index + '" class="slide-switch-btn" style="margin: 0 2px; width: 15px; height:15px;border-radius: 50%; background: #fff; display: inline-block"></a>';
    });
    html += '</div>' +
        '<a href="#" class="slide-next" style="position: absolute; right: 5px; top: 50%; font-size: 36px; margin-top: -40px; color: #fff"><i class="fa fa-angle-right"></i></a>' +
        '<a href="#" class="slide-previous" style="position: absolute; left: 5px; top: 50%; font-size: 36px; margin-top: -40px; color: #fff"><i class="fa fa-angle-left"></i></a>' +
        '</div>';
    $(this).append(html);

    //Automatic presentation
    setInterval(function () {
        var currentSlide = $(this).find('img.slide-show');
        currentSlide.removeClass('slide-show').fadeOut(timer / 2, function () {
            if (currentSlide.next().is(':last-child')) {
                $(this).find('img:first-child').addClass('slide-show').fadeIn(timer / 2);
            }
            else {
                currentSlide.next().addClass('slide-show').fadeIn(timer / 2);
            }
        }.bind(this));
    }.bind(this), timer);
};