jQuery(document).ready(function($) {
	var promotion_slider = null;
        $('.promotion-slider .slider .item').on('click', function() {
            var that = $(this),
            index = that.index()
            object = $('.promotion-slider .blog-banners');
            that.parents('.slider').find('.item').removeClass('active');
            that.addClass('active');
            object.find('.item').addClass('display-none');
            object.find('.item').eq(index).removeClass('display-none');
            clearTimeout(promotion_slider);
        });

        promotion_slider = setTimeout(function(){__promotion_slider()}, 5000);

        function __promotion_slider() {
          var next = $('.promotion-slider .slider .item.active').next();
          if(next.length > 0) {
            next.click();
          } else {
            $('.promotion-slider .slider .item').eq(0).click();
          }
          promotion_slider = setTimeout(function(){__promotion_slider()}, 5000);
        }
});