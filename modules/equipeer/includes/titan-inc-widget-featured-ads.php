<?php
/**
 * Blocking direct access to plugin
 */
defined('ABSPATH') or die('Are you crazy!');

$args = array(
	'post_type'      => 'equine',
	'post_status'    => array( 'publish' ),
	'perm'           => 'readable', // Beware of setting the 'post_status' to anything other than 'public', as it can easily lead to an information disclosure vulnerability
	'cache_results'  => true,
	'orderby'        => 'title',
	'order'          => 'ASC',
	'posts_per_page' => -1,
	'meta_query'     => array(
		array(
			'key'     => 'to_expertise',
			'value'   => '1',
			'compare' => '=',
		),
		array(
			'key'     => 'sold',
			'value'   => '0',
			'compare' => '=',
		),
	)
);
$query = new WP_Query( $args );
$equipeer_featured_ads = array();
while ( $query->have_posts() ) {
	$query->the_post();
	$equipeer_featured_ads[$query->post->ID] = get_the_title( $query->post->ID );
}

// =============================================
//                 POST Form
// =============================================
if ( isset($_POST['featured']) ) {
	$featured_msg       = "";
	$post_featured_ads  = $_POST['eq_featured_ads'];
	if ( get_option( 'eq_featured_ads' ) !== false ) {	 
		// The option already exists, so update it.
		update_option( 'eq_featured_ads', $post_featured_ads );
	} else {
		// The option hasn't been created yet, so add it with $autoload set to 'no'.
		$deprecated = null;
		$autoload = 'no';
		add_option( 'eq_featured_ads', $post_featured_ads, $deprecated, $autoload );
	}
}

// =============================================
//              GET FEATURED ADS
// =============================================
$get_featured_ads = get_option('eq_featured_ads');

// =============================================
//                FEATURED ADS
// =============================================
$featured_ads->createOption( array(
	'type' => 'note',
	'name' => 'Screenshot',
	'desc' => '<img style="border: 1px dotted black;" src="'.EQUIPEER_URL.'assets/images/helper-carousel-featured-ads.jpg">'
) );

$equipeer_featured_ads  = '';
$equipeer_featured_ads .= '<select name="eq_featured_ads[]" id="eq_featured_ads" multiple="multiple" class="equipeer-select-2-ads">';
	$equipeer_featured_ads .= '<option value="">&mdash; Selectionnez &mdash;</option>';
	while ( $query->have_posts() ) {
		$query->the_post();
		$equipeer_featured_ads .= '<option value="'.$query->post->ID.'" ';
		if  (in_array( $query->post->ID, $get_featured_ads ) ) $equipeer_featured_ads .= 'selected="selected"';
		$equipeer_featured_ads .= '>';
		$equipeer_featured_ads .= get_the_title( $query->post->ID );
		$equipeer_featured_ads .= '</option>';
	}
$equipeer_featured_ads .= '</select>';

$featured_ads->createOption( array(
	'name' => 'Annonces à la une<br><span class="description">Statuts PUBLIÉ et OFF</span><span class="equipeer-space-titan"></span>',
	'type' => 'note',
	'desc' => '<link href="' . EQUIPEER_URL . 'assets/vendors/Select2/select2.min.css" rel="stylesheet">
		<script src="' . EQUIPEER_URL . 'assets/vendors/Select2/select2.min.js"></script>
		<form action="?" method="post">
		' . $equipeer_featured_ads . '
		</form>
		<br><em class="description">
			Choisissez 6 annonces minimum.<br>Le nombre d\'annonces doit absolument être un multiple de 3 (6,9,12,15,18,...) sinon le widget affichera les dernières annonces expertisées à la place.
		</em>
		<p class="submit">
			<input type="hidden" name="featured" value="ads">
			<input class="button button-primary" type="submit" value="Save Changes">
		</p>
		<script>
			jQuery(function($) {
				$("#eq_featured_ads").select2();
			});
		</script>
	'
));

?>