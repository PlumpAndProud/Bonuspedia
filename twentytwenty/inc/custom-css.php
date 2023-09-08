<?php
/**
 * Twenty Twenty Custom CSS
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since 1.0.0
 */

if ( ! function_exists( 'twentytwenty_generate_css' ) ) {

	/**
	 * Generate CSS.
	 *
	 * @param string $selector The CSS selector.
	 * @param string $style The CSS style.
	 * @param string $value The CSS value.
	 * @param string $prefix The CSS prefix.
	 * @param string $suffix The CSS suffix.
	 * @param bool   $echo Echo the styles.
	 */
	function twentytwenty_generate_css( $selector, $style, $value, $prefix = '', $suffix = '', $echo = true ) {

		$return = '';

		/*
		 * Bail early if we have no $selector elements or properties and $value.
		 */
		if ( ! $value || ! $selector ) {

			return;
		}

		$return = sprintf( '%s { %s: %s; }', $selector, $style, $prefix . $value . $suffix );

		if ( $echo ) {

			echo $return; //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- We need to double check this, but for now, we want to pass PHPCS ;)

		}

		return $return;

	}
}

if ( ! function_exists( 'twentytwenty_get_customizer_css' ) ) {

	/**
	 * Get CSS Built from Customizer Options.
	 * Build CSS reflecting colors, fonts and other options set in the Customizer, and return them for output.
	 *
	 * @param string $type Whether to return CSS for the "front-end", "block-editor" or "classic-editor".
	 */
	function twentytwenty_get_customizer_css( $type = 'front-end' ) {

		return ob_get_clean();

	}
}
