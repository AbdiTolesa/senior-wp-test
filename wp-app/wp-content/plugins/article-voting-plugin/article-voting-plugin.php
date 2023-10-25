<?php

/**
 * Plugin Name:       Article Voting Plugin
 * Plugin URI:        https://article-voting-plugin.com
 * Description:       A plugin that allows visitors vote for an article
 * Version:           1.0.0
 * Author:            Abdi Tolessa
 * Author URI:        https://abditsori.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       article-voting-plugin
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'ARTICLE_VOTING_PLUGIN_VERSION', '1.0.0' );


/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-article-voting-plugin.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_article_voting_plugin() {

	$plugin = new Article_Voting_Plugin();
	$plugin->run();

}
run_article_voting_plugin();
