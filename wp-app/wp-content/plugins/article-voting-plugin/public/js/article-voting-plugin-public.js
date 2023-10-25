(function( $ ) {
	'use strict';

	const userHasNotVotedForArticle = () => {
		return true;
	};

	const handleVote = ( event ) => {
				if ( userHasNotVotedForArticle() ) {
					const voteButton = event.currentTarget;
					jQuery.ajax({
						type: 'POST',
						url: ajax_object.ajax_url,
						data: {
							action: 'vote_article',
							vote: voteButton.dataset.vote,
							post_id: ajax_object.post_id
						},
						success: function( response ) {
							const voteButtonsLabel = document.getElementById( 'avp-vote-buttons-label' );
							voteButtonsLabel.innerText = response.message;
							document.getElementById( 'avp-yes-vote-btn' ).querySelector( 'span' ).textContent = response.yes + '%' ;
							document.getElementById( 'avp-no-vote-btn' ).querySelector( 'span' ).textContent  = response.no + '%';
							voteButton.classList.add( 'voted' );
						},
						error: function( xhr, textStatus, errorThrown ) {
							console.error('AJAX error:', textStatus, errorThrown);
						}
					});
					jQuery( '.avp-vote-trigger' ).off( 'click', handleVote );
				}
			};

	jQuery( document ).ready( function() {
		jQuery( '.avp-vote-trigger' ).one( 'click', handleVote );
	});

})( jQuery );
