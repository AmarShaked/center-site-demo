<?php
/**
 * Local preview only (installed as a mu-plugin by the blueprint, never deployed).
 * Outgoing HTTP from PHP-WASM crashes the Playground worker ("unreachable"),
 * e.g. WordPress's oEmbed discovery on links in old content. Refuse all
 * external requests so WordPress takes its normal "request failed" path.
 */
add_filter(
	'pre_http_request',
	function ( $pre, $args, $url ) {
		$host = wp_parse_url( $url, PHP_URL_HOST );
		if ( $host && ! in_array( $host, array( '127.0.0.1', 'localhost' ), true ) ) {
			return new WP_Error( 'cc_preview_offline', 'Local preview: external requests are disabled.' );
		}
		return $pre;
	},
	1,
	3
);
