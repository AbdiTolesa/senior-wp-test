<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://article-voting-plugin.com
 * @since      1.0.0
 *
 * @package    Article_Voting_Plugin
 * @subpackage Article_Voting_Plugin/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Article_Voting_Plugin
 * @subpackage Article_Voting_Plugin/includes
 * @author     Abdi Tolessa <tolesaabdi@gmail.com>
 */
class Article_Voting_Plugin_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'article-voting-plugin',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
