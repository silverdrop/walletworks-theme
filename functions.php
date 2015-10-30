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



function coupon_list( $atts ) {
	ob_start();
	get_template_part( 'coupon' ); 
	$output = ob_get_contents();
	ob_end_clean();
	return $output;
}
add_shortcode( 'couponlist', 'coupon_list' );