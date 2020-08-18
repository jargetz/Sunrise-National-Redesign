<?php
/**
 * Sample implementation of the Custom Header feature
 *
 * You can add an optional custom header image to header.php like so ...
 *
	<?php the_header_image_tag(); ?>
 *
 * @link https://developer.wordpress.org/themes/functionality/custom-headers/
 *
 * @package Sunrise_National
 */

/**
 * Set up the WordPress core custom header feature.
 *
 * @uses surnise_national_header_style()
 */
function surnise_national_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'surnise_national_custom_header_args', array(
		'default-image'          => '',
		'default-text-color'     => '000000',
		'width'                  => 1000,
		'height'                 => 250,
		'flex-height'            => true,
		'wp-head-callback'       => 'surnise_national_header_style',
	) ) );
}
add_action( 'after_setup_theme', 'surnise_national_custom_header_setup' );

if ( ! function_exists( 'surnise_national_header_style' ) ) :
	/**
	 * Styles the header image and text displayed on the blog.
	 *
	 * @see surnise_national_custom_header_setup().
	 */
	function surnise_national_header_style() {
		$header_text_color = get_header_textcolor();

		/*
		 * If no custom options for text are set, let's bail.
		 * get_header_textcolor() options: Any hex value, 'blank' to hide text. Default: add_theme_support( 'custom-header' ).
		 */
		if ( get_theme_support( 'custom-header', 'default-text-color' ) === $header_text_color ) {
			return;
		}

		// If we get this far, we have custom styles. Let's do this.
		?>
		<style type="text/css">
		<?php
		// Has the text been hidden?
		if ( ! display_header_text() ) :
			?>
			.site-title,
			.site-description {
				position: absolute;
				clip: rect(1px, 1px, 1px, 1px);
			}
		<?php
		// If the user has set a custom color for the text use that.
		else :
			?>
			.site-title a,
			.site-description {
				color: #<?php echo esc_attr( $header_text_color ); ?>;
			}
		<?php endif; ?>
		</style>
		<?php
	}
endif;

/**
 * function to synchronize Action posts with EveryAction API call
 */
function synchronize_everyaction_api_to_posts() {
	$actions_json = file_get_contents('everyaction/everyaction_actions.json');
	$actions = json_decode($actions_json, true)['items'];
	foreach($actions as $action){
		$eventId = strval($action['eventId']);
		$event = json_decode(file_get_contents('everyaction/events/'.$eventId.'.json'), true);
		$action['event'] = $event;
		echo '<pre>'; print_r($event); echo '</pre>';
	}
	//echo $response['items'][0]['eventId'];
}
add_action( 'after_setup_theme', 'synchronize_everyaction_api_to_posts' );

function retrieve_everyaction_event() {

}