define(
    ['jquery', 'carousel'],
    function ($) {
        $.get('feedback/index/approvedfeedback', function (resp) {
            let htmlContent = "";
            if (resp.feedback_status) {
                resp.data.forEach(function (item) {
                    htmlContent += "<div class='item'>" +
                        "<div><b>" + item.comment + "</b></div>" +
                        "</div>"
                });
                $('#myCarousel').html(htmlContent);

                'use strict';
                $('.owl-carousel').owlCarousel({
                    loop: true,
                    margin: 10,
                    items: 1,
                    nav: true,
                });
            }

        });
    }
);