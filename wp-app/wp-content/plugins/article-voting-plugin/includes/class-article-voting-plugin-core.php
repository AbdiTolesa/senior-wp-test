<?php
/**
 * The file that defines the class that contains core voting functions.
 *
 * @since      1.0.0
 *
 * @package    Article_Voting_Plugin
 * @subpackage Article_Voting_Plugin/includes
 */

/**
 * This class defines functions used to cast a vote on behalf of a user and other helper functions.
 *
 * @since      1.0.0
 * @package    Article_Voting_Plugin
 * @subpackage Article_Voting_Plugin/includes
 * @author     Abdi Tolessa <tolesaabdi@gmail.com>
 */
class Article_Voting_Plugin_Core {

	/**
	 * Returns the vote value for the current user on the current post or false if the user has not voted for it yet.
	 * 
	 * @since 1.0.0
	 * @return string|bool
	 */
	private function user_vote_value() {
		$user_id = get_current_user_id();
		$post_votes = get_post_meta( get_the_ID(), 'avp_votes', true );
		if ( empty( $post_votes ) ) {
			return false;
		}

		if ( ! empty( $post_votes['yes'] ) && in_array( $user_id, $post_votes['yes'], true ) ) {
			return 'yes';
		}
		if ( ! empty( $post_votes['no'] ) && in_array( $user_id, $post_votes['no'], true ) ) {
			return 'no';
		}
		return false;
	}

	/**
	 * Appends the vote widget on the front end on single post pages.
	 *
	 * @since 1.0.0
	 *
	 * @param string $content
	 *
	 * @return string $content
	 */
	public function show_vote_widget( $content ) {
		if ( ! is_user_logged_in() || ! is_single() ) {
			return $content;
		}
		$user_vote = $this->user_vote_value();

		if ( ! empty( $user_vote )) {
			$post_votes     = get_post_meta( get_the_ID(), 'avp_votes', true );
			$total_votes    = count( $post_votes['yes'] ) + count( $post_votes['no'] );
			$positive_votes = round( ( count( $post_votes['yes'] ) / $total_votes ) * 100, 2 );
			$negative_votes = round( 100 - $positive_votes, 2 );
		}

		ob_start();
		include plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/article-voting-plugin-public-vote-widget.php';
		$content .= ob_get_clean();

		return $content;
	}

	/**
	 * Casts a vote on behalf of the current user.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function vote_article() {
		check_ajax_referer( 'avp_create_vote', 'nonce' );

		$user_id = get_current_user_id();
		if ( empty( $_POST['vote'] ) || empty( $_POST['post_id'] ) || ! $user_id ) {
			return;
		}
		$post_id = absint( $_POST['post_id'] );
		$vote = sanitize_text_field( $_POST['vote'] );

		$post_votes = get_post_meta( $post_id, 'avp_votes', true );

		if ( empty( $post_votes ) ) {
			$post_votes = array( 'yes' => array(), 'no' => array() );
		}
		if ( ! in_array( $user_id, $post_votes[ $vote ], true ) ) {
			$post_votes[ $vote ][] = $user_id;
		}

		update_post_meta( $post_id, 'avp_votes', $post_votes );
		$total_votes    = count( $post_votes['yes'] ) + count( $post_votes['no'] );
		$positive_votes = round( ( count( $post_votes['yes'] ) / $total_votes ) * 100, 2 );

		$response = array(
			'yes' => $positive_votes,
			'no'  => round( 100 - $positive_votes, 2 ),
			'message' => __( 'Thank you for your feedback.', 'article-voting-plugin' ),
		);

		wp_send_json( $response );
	}
}
