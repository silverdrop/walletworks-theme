jQuery(document).ready(function($) {
  var $grid = $('.coupon-list-inner'),
  		$type_filter = $('#type_filter'),
  		$issuer_filter = $('#issuer_filter');

  $grid.shuffle({
    itemSelector: '.coupon-item'
  });

		var shuffle = function() {
		    var type = $type_filter.val();
		    var issuer = $issuer_filter.val();
		    $grid.shuffle( 'shuffle', function($el, shuffle) {
				  return (issuer == undefined || issuer == "all" || $el.data('issuer') == issuer) && (type == undefined || type == "all" || $el.data('coupon-type') == type);
				});
		}

		$(".coupon-filter select").on('change', function (e) {
		    shuffle();
		});

    $(".coupon-filter-wrapper").sticky({topSpacing:0});
});