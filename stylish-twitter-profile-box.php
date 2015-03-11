<?php
/**
 * Plugin Name:       Stylish Twitter Profile Box
 * Plugin URI:        http://stylishtwitterprofilebox.com/
 * Description:       Stylish Twitter Profile Box is WordPress Widget Plugin, increase 220% twitter follwers rate.
 * Version:           1.0.0
 * Author:            Nand Lal
 * Author URI:        http://codecanyon.net/user/themekarni
 * Text Domain:       stylish-twiiter-profile-box
 * Domain Path:       /lang
 */
 
 // Prevent direct file access
if ( ! defined ( 'ABSPATH' ) ) {
	exit;
}

class stpb_twitterprofilebox extends WP_Widget {

   
     /*
     * @since    1.0.0
     * @var      string
     */
    protected $widget_slug = 'stylish-twitter-profile-box';

	/*--------------------------------------------------*/
	/* Constructor
	/*--------------------------------------------------*/

	public function __construct() {

		// load plugin text domain
		add_action( 'init', array( $this, 'widget_textdomain' ) );

		// Hooks fired when the Widget is deactivate
		register_deactivation_hook( __FILE__, array( $this, 'deactivate' ) );
		
		parent::__construct(
			$this->get_widget_slug(),
			__( 'Stylish Twitter Profile Box Basic', $this->get_widget_slug() ),
			array(
				'classname'  => $this->get_widget_slug().'-class',
				'description' => __( 'Stylish Twitter Profile Box is WordPress Widget Plugin for your site.', $this->get_widget_slug() )
			)
		);

		// Register site styles and scripts
		add_action( 'wp_enqueue_scripts', array( $this, 'stpb_register_widget_styles' ) );
		
		// Conditional IE9 CSS
		add_action( 'wp_head', array( $this, 'stpb_add_ie9_css') );

		
	} // end constructor


    /**
     * Return the widget slug.
     *
     * @since    1.0.0
     *
     * @return    Plugin slug variable.
     */
    public function get_widget_slug() {
        return $this->widget_slug;
    }

	/*--------------------------------------------------*/
	/* Widget API Functions
	/*--------------------------------------------------*/

	/**
	 * Outputs the content of the widget.
	 *
	 * @param array args  The array of form elements
	 * @param array instance The current instance of the widget
	 */
	public function widget( $args, $instance ) {

		
		extract( $args, EXTR_SKIP );
		echo $before_widget;

		// Check if there is a cached output
		$data = get_transient( $this->id );
		
		if ( $data === false ) {

			$defaults = $this->stpb_get_defaults();
			extract( wp_parse_args( $instance, $defaults ) );
			
			$data = '';

			if ( $title != '' ) {

				$data .= $before_title . apply_filters( 'widget_title', $title, $instance, $this->id_base ) . $after_title;
			}

			// Request the Twitter API
			$result = $this->stpb_call_twitter_api($oauth_access_token, $oauth_access_token_secret, $consumer_key, $consumer_secret, $username, $request_time);
			
			if ( !empty($result[0]['errors'][0]['message']) ) {

				$data .= '<strong>'.__($result[0]['errors'][0]['message'], 'stpb_twitterprofilebox').'</strong><br />';
				$data .= __('Follow the documentation', 'stpb_twitterprofilebox');
				
				
			} elseif ( is_null($result[0]) || empty($result[0]) ) {

				$data .= '<strong>'.__('Couldn\'t access internet! or <br /> Data is <em>Null<em>', 'stpb_twitterprofilebox').'</strong>';

			} else {

						// If result is valid, display the widget.
						
						$name 		=	$result[0]['name'];
			    		$scr_name 	=	$result[0]['screen_name'];
			    		$img_url 	=	$result[0]['profile_image_url'];
			    		$tweets 	=	$result[0]['statuses_count'];
			    		$followers 	=	$result[0]['followers_count'];
			    		$following 	=	$result[0]['friends_count'];

				require_once( plugin_dir_path( __FILE__ ) . 'views/stpb-display.php' );

				set_transient( $this->id, $data, (60 * $request_time) );

			} // end if
		}

			print $data;
			echo $after_widget;

	} // end widget
	
	
	/**
	 * Processes the widget's options to be saved.
	 *
	 * @param array new_instance The new instance of values to be generated via the update.
	 * @param array old_instance The previous instance of values before the update.
	 */
	public function update( $new_instance, $old_instance ) {

		$instance = $old_instance;

		$instance['title'] 						= 	trim(strip_tags( $new_instance['title'] ));
		$instance['skin'] 						= 	trim(strip_tags( $new_instance['skin'] ));
		$instance['username'] 					= 	trim(strip_tags( $new_instance['username'] ));
		$instance['consumer_key'] 				= 	trim(strip_tags( $new_instance['consumer_key'] ));
		$instance['consumer_secret'] 			= 	trim(strip_tags( $new_instance['consumer_secret'] ));
		$instance['oauth_access_token'] 		= 	trim(strip_tags( $new_instance['oauth_access_token'] ));
		$instance['oauth_access_token_secret'] 	= 	trim(strip_tags( $new_instance['oauth_access_token_secret'] ));
		$instance['request_time'] 				= 	absint( $new_instance['request_time'] );
		$instance['skin'] 						= 	trim(strip_tags( $new_instance['skin'] ));

		delete_transient( $this->id ); 

		return $instance;

	} // end widget

	/**
	 * Generates the administration form for the widget.
	 *
	 * @param array instance The array of keys and values for the widget.
	 */
	public function form( $instance ) {

		$defaults = $this->stpb_get_defaults();

		$instance = wp_parse_args(
			$instance,
			$defaults
		);

		extract($instance);
		
		// Display the admin form
		include( plugin_dir_path(__FILE__) . 'views/stpb-admin.php' );

	} // end form

	/*--------------------------------------------------*/
	/* Public Functions
	/*--------------------------------------------------*/

	/**
	 * Loads the Widget's text domain for localization and translation.
	 */
	public function widget_textdomain() {

		load_plugin_textdomain( $this->get_widget_slug(), false, plugin_dir_path( __FILE__ ) . 'lang/' );

	} // end widget_textdomain.

	/**
	 * Fired when the plugin is deactivated.
	 *
	 * @param boolean $network_wide True if WPMU superadmin uses "Network Activate" action, false if WPMU is disabled or plugin is activated on an individual blog
	 */
	public function deactivate( $network_wide ) {
		

		delete_transient ( $this->id );
		deactivate_plugins( plugin_basename( __FILE__ ), TRUE, $network_wide );

    	header( 'Location: ' . network_admin_url( 'plugins.php?deactivate=true' ) );
    
	} // end deactivate

	/**
	 * Add conditional IE9 CSS script in Head section.
	 */
	public function stpb_add_ie9_css() {

			$output  =  "<!--[if gte IE 9]>\n";
			$output .=	'<style type="text/css">'."\n";
			$output	.=  ".blue, \n .blue .counters, \n .purple, \n .purple .counters, \n .green, \n .green counters, \n .orange, \n .orange .counters, \n .brown, \n .brown .counters \n { filter: none; } \n";
			$output .=	"</style>\n";
			$output .=  "<![endif]-->\n";

			echo __($output);

	} // end stpb_add_ie9_css function.

	/**
	 * Registers and enqueues widget-specific styles.
	 */
	public function stpb_register_widget_styles() {

		wp_enqueue_style( $this->get_widget_slug().'-widget-styles', plugins_url( 'css/stpb-main.css', __FILE__ ) );

	} // end stpb_register_widget_styles

	/**
	* Defualt Values
	*/
	public function stpb_get_defaults()
	{
		$defaults = array(
			'title'						=> 'Stylish Twitter Profile Box',
			'username'					=> '',
			'consumer_key'				=> '',
			'consumer_secret' 			=> '',
			'oauth_access_token' 		=> '',
			'oauth_access_token_secret' => '',
			'skin'						=> 'dark',
			'request_time'				=> 30 
		);
		
		return $defaults;
	}

	/**
	* Images Directory
	*/
	public function stpb_get_images( $imgname )
	{
		
		$images = plugins_url( 'images/'.$imgname, __FILE__ );
		return $images;
	}

	/**
	* Call the Twitter API
	*/
	public function stpb_call_twitter_api( $oauth_access_token, $oauth_access_token_secret, $consumer_key, $consumer_secret, $username, $request_time ) {

			require_once( plugin_dir_path( __FILE__ ) . 'inc/TwitterAPIExchange.php');

				$profile_info = array();
			    /** Set access tokens here - see: https://dev.twitter.com/apps/ **/
			    $settings = array(
			    'oauth_access_token' => $oauth_access_token,
			    'oauth_access_token_secret' => $oauth_access_token_secret,
			    'consumer_key' => $consumer_key,
			    'consumer_secret' => $consumer_secret
				);

			    $url = "https://api.twitter.com/1.1/users/show.json";
			    $requestMethod = "GET";
			    $getfield = '?screen_name='.$username;
			    $twitter = new TwitterAPIExchange($settings);
			    $profile_info[] = json_decode($twitter->setGetfield($getfield)
			    ->buildOauth($url, $requestMethod)
			    ->performRequest(),$assoc = TRUE);

			   
			    return $profile_info;
	} // end callTwiiterAPI

	
	/**
	* Change the image url for big image size.
	*/

	 public function stpb_image_url($imgUrl) {

	 	$find    = array ( '/_normal/', '/http/' );
	 	$replace = array ( '', 'https' );
    	return preg_replace( $find, $replace, $imgUrl);

	} // end stpb_image_url.

	/**
	* Convert digits to K after 10,000 e.g 10K.
	*/
	public function stpb_format_number($number) {

	    if($number >= 10000) {

	       return (number_format($number/1000, 2) * 100) / 100 . "K";   // NB: you will want to round this
	    
	    } else {

	        return $number;
	    }

	} // end stpb_format_number.

} // end class

// Init and register Widget.
add_action( 'widgets_init', create_function( '', 'register_widget("stpb_twitterprofilebox");' ) );
