<?php

// enqueue the child theme stylesheet

function walletworks_enqueue_webfont() {
	wp_enqueue_style( 'childstyle-font', get_stylesheet_directory_uri() . '/css/webfont.css'  );
}
function walletworks_enqueue_scripts() {
	wp_enqueue_style( 'childstyle', get_stylesheet_directory_uri() . '/style.css' );
	wp_enqueue_script( 'childscript', get_stylesheet_directory_uri() . '/js/custom.js', array(), '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 		'walletworks_enqueue_webfont', 10);
add_action( 'admin_enqueue_scripts', 	'walletworks_enqueue_webfont', 10);
add_action( 'wp_enqueue_scripts', 		'walletworks_enqueue_scripts', 11);

function walletworks_framework() {
	global $qodeFramework;
	$qodeTitle = $qodeFramework->qodeMetaBoxes->getMetaBox("page_title");
	$qode_page_title_area_container = $qodeTitle->getChild("qode_page_title_area_container");
	$qode_title_text_container = $qode_page_title_area_container->getChild("qode_title_text_container");
	
	$qode_page_custom_title = new QodeMetaField("text","qode_page_custom_title","","Custom Title Text","Enter your custom title text");
	$qode_title_text_container->addChild("qode_page_custom_title",$qode_page_custom_title);
}
add_action( 'admin_init', 'walletworks_framework');

function walletworks_custom_title_text($text) {
	if(is_page()) {
		$custom_title = get_post_meta(get_the_ID(), "qode_page_custom_title", true);
		$text = $custom_title ? $custom_title : $text;
	}
	return $text;
}
add_filter( 'qode_title_text', 'walletworks_custom_title_text', 10, 1);

function walletworks_theme_setup() {
    add_image_size( 'coupon', 250, 140, true ); // (cropped)
}
add_action( 'after_setup_theme', 'walletworks_theme_setup' );

function coupon_list( $atts ) {
	ob_start();

	echo "<div class='coupon-list clearfix'><div class='coupon-list-inner'>";
	$args = array(
		'post_type'	=> 'coupon',
		'orderby'	=> 'date',
		'order'		=> 'ASC'
	);
	query_posts( $args );
	while(have_posts()) : the_post();
		get_template_part( 'coupon' ); 
	endwhile;
	echo "</div></div>";

	$output = ob_get_contents();
	ob_end_clean();
	return $output;
}
add_shortcode( 'couponlist', 'coupon_list' );

function coupon_filter( $atts ) {
	ob_start();
?>
	<div class='coupon-filter-wrapper grid_section'><div class='section_inner clearfix'>
		<div class='coupon-filter'>
			<div class="vc_row">
				<div class="vc_col-sm-4">
					<select>
						<option disabled>Type</option>
						<option value="coupon">Coupon</option>
						<option value="member_card">Member Card</option>
					</select> 
				</div>
				<div class="vc_col-sm-4">
					<select>
						<option disabled>Popularity</option>
						<option value="volvo">Volvo</option>
						<option value="saab">Saab</option>
						<option value="mercedes">Mercedes</option>
						<option value="audi">Audi</option>
					</select> 
				</div>
				<div class="vc_col-sm-4">
					<select>
						<option disabled="">Issuer</option>
						<option value="starbucks">Starbucks</option>
						<option value="pizzahut">Pizzahut</option>
						<option value="wallmart">Wallmart</option>
					</select> 
				</div>
			</div>
		</div>
	</div></div>
<?php
	$output = ob_get_contents();
	ob_end_clean();
	return $output;
}
add_shortcode( 'couponfilter', 'coupon_filter' );