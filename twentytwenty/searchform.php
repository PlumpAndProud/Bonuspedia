<?php
/**
 * The searchform.php template.
 *
 * Used any time that get_search_form() is called.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since 1.0.0
 */

/*
 * Generate a unique ID for each form and a string containing an aria-label if
 * one was passed to get_search_form() in the args array.
 */
$unique_id = twentytwenty_unique_id( 'search-form-' );

$aria_label = ! empty( $args['label'] ) ? 'aria-label="' . esc_attr( $args['label'] ) . '"' : '';
?>
<div class="search-container">
  <form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <input type="search" class="search-form-custom expandright" id="searchright <?php echo esc_attr( $unique_id ); ?>" type="search" name="s" placeholder="Fortuna, Sts, Lvbet, Betclic">
	  <input type="submit" class="search-submit-custom" value="" />
    <label class="button searchbutton" for="searchright <?php echo esc_attr( $unique_id ); ?>"><span class="mglass">&#9906;</span></label>
  </form>
</div>