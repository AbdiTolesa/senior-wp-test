<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @since      1.0.0
 *
 * @package    Article_Voting_Plugin
 * @subpackage Article_Voting_Plugin/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Article_Voting_Plugin
 * @subpackage Article_Voting_Plugin/admin
 * @author     Abdi Tolessa <tolesaabdi@gmail.com>
 */
class Article_Voting_Plugin_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/article-voting-plugin-admin.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/article-voting-plugin-admin.js', array( 'jquery' ), $this->version, false );
	}

	/**
	 * Add a meta box that allows showing the vote results on post edit page.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function show_vote_results() {
		$post_votes = get_post_meta( get_the_ID(), 'avp_votes', true );
		if ( empty( $post_votes ) ) {
			return;
		}
		add_meta_box(
			'avp-vote-results',
			'Vote',
			array( $this, 'display_vote_results' ),
			'post',
			'normal',
			'high'
		);
	}

	/**
	 * A function that displays the vote result inside a meta box.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function display_vote_results() {
		$post_votes     = get_post_meta( get_the_ID(), 'avp_votes', true );
		$total_votes    = count( $post_votes['yes'] ) + count( $post_votes['no'] );
		$positive_votes = round( ( count( $post_votes['yes'] ) / $total_votes ) * 100, 2 );
		$negative_votes = round( 100 - $positive_votes, 2 );
		echo esc_html( sprintf( 'Total votes: %d, ', $total_votes ));
		echo esc_html( sprintf( 'Positive votes: %.2f%%, ', $positive_votes ));
		echo esc_html( sprintf( 'Negative votes: %.2f%%', $negative_votes ));
	}
}
