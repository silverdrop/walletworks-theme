<?php
	$logo_image = wp_get_attachment_image_src( get_field('issuer_logo') );
	$coupon_id = "coupon_".get_the_ID();
	$color = get_field('color');
?>
<div class="coupon-item" id="<?=$coupon_id?>">
	<div class="coupon-item-header">
		<div class="issuer-logo" style="background-image:url('<?php echo $logo_image[0];?>')"></div>
		<h2 class="issuer-title"><?php the_field('issuer_name');?></h2>
	</div>
	<div class="coupon-item-body">
		<div class="coupon-image">
			<?php the_post_thumbnail('coupon');?>
		</div>
		<h3 class="offer-title"><?php the_field('offer_title');?></h3>
		<span class="offer-description"><?php the_field('offer_description');?></span>
	</div>
	<div class="coupon-item-footer">
		<span class="expire-by">expire by <?php the_field('expire_by');?></span>
		<div class="call-to-action">
			<div class="social-sharing">
				<span class="q_social_icon_holder normal_social"><a href="#" target="_blank"><i class="qode_icon_font_awesome fa fa-twitter fa-lg"></i></a></span>
				<span class="q_social_icon_holder normal_social"><a href="#" target="_blank"><i class="qode_icon_font_awesome fa fa-facebook fa-lg"></i></a></span>
				<span class="q_social_icon_holder normal_social"><a href="#" target="_blank"><i class="qode_icon_font_awesome fa fa-instagram fa-lg"></i></a></span>
			</div>
			<a class="call-button"></a>
		</div>
	</div>
	<style>
		#<?=$coupon_id;?>.coupon-item .qbutton:hover,
		#<?=$coupon_id;?> .coupon-item-header,
		#<?=$coupon_id;?> .coupon-item-body:before,
		#<?=$coupon_id;?> .coupon-item-footer:after {
			background-color: <?=$color?>;
		}
	</style>
</div>