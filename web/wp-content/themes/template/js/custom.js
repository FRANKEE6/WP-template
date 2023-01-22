// This is my main script file using jQuery which was added as dependency for this file
// As always u can split this file to many to ensure code transparency, just make sure to use some plugin that can group and minify your scripts. Many scripts might slow down your site load speed without it

(function ($) {  

    // Function for identification of descktop devices by width ____________________________________
    // This function can be used in if statements to determine if device is desktop or tablet/mobile

    function isDesktopDevice(){
        let actDevWidth = $('body, html').width();

        if (actDevWidth >= 781.1 ){
            return true;
        }
        else {
            return false;
        }
    }



    // Responsive embeds ________________________________________________
    // This script is refactored WordPress responsive embed script with adjustments to fit my needs

    function TemplateThemeResponsiveEmbeds(){
        var footerHeight, proportion, parentWidth;

        $('iframe').each(function(index, value){

            var iframeWidth = $(this).attr('width'),
                iframeHeight = $(this).attr('height');

            if (iframeWidth > 0 && iframeHeight > 0){
                footerHeight = $('.footer-flex').height();

                // Calculate the proportion/ratio based on the width & height.
                proportion = iframeWidth / iframeHeight;

                // Get the parent element's width.
                parentWidth = $(this).parent().parent().width();

                // Set the max-width & height.
                $(this).css('maxWidth', parentWidth + 'px');
                $(this).css('maxHeight', (parentWidth / proportion) + 'px');
            }
        });
    }

    // Run on initial load.
    TemplateThemeResponsiveEmbeds();

    // Run on resize.
    $(window).resize(function(){
        TemplateThemeResponsiveEmbeds();
    });


    // Scroll functions __________________________________________________
    // My simple scroll up function triggered by button on page
    // To make it work just change element class in variable

    var scrlup = $(".scrlup");

    if($(scrlup).length){
        $(scrlup).hide();
    
        $(document).on("scroll", function(){
            if($(this).scrollTop() > 400){
                $(scrlup).fadeIn();
            }
            else $(scrlup).fadeOut();
        });

        $(scrlup).on("click", function(){
            var body = $("html, body")
            $(body).animate({scrollTop: 0}, 500, 'swing', function(){$(scrlup).fadeOut()});
        });
    }

})(jQuery);