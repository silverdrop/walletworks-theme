<?php

// enqueue the child theme stylesheet

function walletworks_enqueue_webfont() {
	wp_enqueue_style( 'childstyle-font', get_stylesheet_directory_uri() . '/css/webfont.css'  );
}
function walletworks_enqueue_scripts() {
	wp_enqueue_style( 'childstyle', get_stylesheet_directory_uri() . '/style.css' );
	wp_enqueue_script( 'shuffle', get_stylesheet_directory_uri() . '/js/jquery.shuffle.min.js', array(), '1.0.0', true );
	wp_enqueue_script( 'sticky', get_stylesheet_directory_uri() . '/js/jquery.sticky.js', array(), '1.0.0', true );
	wp_enqueue_script( 'childscript', get_stylesheet_directory_uri() . '/js/custom.js', array(), '1.0.0', true );
}
//add_action( 'wp_enqueue_scripts', 		'walletworks_enqueue_webfont', 10);
//add_action( 'admin_enqueue_scripts', 	'walletworks_enqueue_webfont', 10);
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
	$types = get_terms( 'coupon_type', 'orderby=count' );
	$issuers = get_terms( 'coupon_issuer', 'orderby=count' );
	ob_start();
?>
	<div class='coupon-filter-wrapper grid_section'><div class='section_inner clearfix'>
		<div class='coupon-filter'>
			<div class="vc_row">
				<div class="vc_col-xs-4">
					<select id="type_filter">
						<option value="" disabled selected style="display: none;">Type</option>
						<option value="all">All</option>
						<?php 
						if ( ! empty( $types ) && ! is_wp_error( $types ) ){
						    foreach ( $types as $type ) {
						       echo '<option value="'.$type->slug.'">'.$type->name.'</option>';
						    }
						}
						?>
					</select> 
				</div>
				<div class="vc_col-xs-4">
					<select>
						<option disabled selected>Popularity</option>
						<option value="volvo">Volvo</option>
						<option value="saab">Saab</option>
						<option value="mercedes">Mercedes</option>
						<option value="audi">Audi</option>
					</select> 
				</div>
				<div class="vc_col-xs-4">
					<select id="issuer_filter">
						<option value="" disabled selected style="display: none;">Issuer</option>
						<option value="all">All</option>
						<?php 
						if ( ! empty( $issuers ) && ! is_wp_error( $issuers ) ){
						    foreach ( $issuers as $issuer ) {
						       echo '<option value="'.$issuer->slug.'">'.$issuer->name.'</option>';
						    }
						}
						?>
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