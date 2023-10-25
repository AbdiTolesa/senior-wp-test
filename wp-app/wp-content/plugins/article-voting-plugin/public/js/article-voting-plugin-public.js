( function( $ ) {
	'use strict';

	const handleVote = ( event ) => {
		const voteButton = event.currentTarget;
		$.ajax( {
			type: 'POST',
			url: ajaxObject.ajax_url,
			data: {
				action: 'vote_article',
				vote: voteButton.dataset.vote,
				post_id: ajaxObject.post_id,
				nonce: ajaxObject.ajax_nonce,
			},
			success( response ) {
				const voteButtonsLabel = document.getElementById( 'avp-vote-buttons-label' );
				voteButtonsLabel.innerText = response.message;
				document.getElementById( 'avp-yes-vote-btn' ).querySelector( 'span' ).textContent = response.yes + '%';
				document.getElementById( 'avp-no-vote-btn' ).querySelector( 'span' ).textContent = response.no + '%';
				voteButton.classList.add( 'voted' );
				$( '.avp-vote-trigger' ).removeClass( 'avp-vote-trigger' );
			},
			error( xhr, textStatus, errorThrown ) {
				console.error( 'AJAX error:', textStatus, errorThrown );
			},
		} );
		$( '.avp-vote-trigger' ).off( 'click', handleVote );
	};

	$( document ).ready( function() {
		$( '.avp-vote-trigger' ).one( 'click', handleVote );
	} );
}( jQuery ) );
