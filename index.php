<?php
/*
* Plugin Name: YouTube Hub - AMP For WordPress compatibility
* Plugin URI: https://wpythub.com
* Description: Add-on plugin for YouTube Video Importer - YouTube Hub which introduces compatibility with plugin "AMP for WordPress"
* Author: Constantin Boiangiu
* Version: 1.0
* Author URI: https://wpythub.com
*/

class CBC_AMP4WP_Compatibility{
	/**
	 * Holds class instance
	 * @var CBC_AMP4WP_Compatibility|null
	 */
	private static $instance = null;

	/**
	 * CBC_Vlog_Compatibility constructor.
	 */
	private function __construct() {
		add_action( 'init', array( $this, 'on_init' ) );
	}

	/**
	 * @return CBC_Vlog_Compatibility|null
	 */
	public static function get_instance(){
		if( null === self::$instance ){
			self::$instance = new CBC_AMP4WP_Compatibility();
		}
		return self::$instance;
	}

	/**
	 * Hook "init" callback, verifies that plugin is loaded and
	 * that loaded theme is the right theme
	 */
	public function on_init(){
		if( !class_exists( 'CBC_YouTube_Videos' ) ){
			return;
		}

		add_action( 'pre_amp_render_post', array( $this, 'amp_render_post' ), 10, 1 );
	}

	/**
	 * Hook "pre_amp_render_post" callback.
	 * Implements filter that will modify the video embed to be AMP compatible
	 */
	public function amp_render_post( $post_id ){
		add_filter( 'cbc_embed_html_container', array( $this, 'video_embed' ), 10, 4 );
	}

	/**
	 * @param $video_container
	 * @param $post
	 * @param $video
	 * @param $settings
	 *
	 * @return string
	 */
	public function video_embed( $video_container, $post, $video, $settings ){
		return "\n" . 'https://www.youtube.com/watch?v=' . $video['video_id'] . "\n";
	}
}
CBC_AMP4WP_Compatibility::get_instance();
