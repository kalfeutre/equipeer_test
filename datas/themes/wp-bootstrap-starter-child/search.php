<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package WP_Bootstrap_Starter
 */

session_start();
 
get_header();

// ------------------------------------
// --- INITIALIZE SESSION
// ------------------------------------
$_SESSION['equipeer_user_list'] = [];
$_SESSION['equipeer_list_back'] = "";
// ------------------------------------
// --- PUBLICITES
// ------------------------------------
get_template_part( 'template-parts/publicity' );

// ---------------------------------------
// --- BREADCRUMB
// ---------------------------------------
get_template_part( 'template-parts/breadcrumb' );

get_sidebar('equine-archive-header'); ?>

<aside id="secondary" class="widget-area col-sm-12 col-lg-4 equipeer-ads" role="complementary">
	<!-- ===== Advanced Search ===== --> 
	<?php get_template_part( 'template-parts/navbar', 'searchads' ); ?>
	<?php get_sidebar('equine-archive'); ?>
</aside>
 
<div id="primary" class="content-area col-sm-12 col-lg-8" data-test="<?php echo get_option("equipeer_range_1_until"); ?>">
	<div id="content" role="main">
			
		<?php
			// ============================================================
			//                         SEARCH BY
			// ============================================================
			// s = search_main  : Recherche générale
			// s = search_ref   : Recherche par reference
			// s = search_quest : Recherche par le questionnaire trouvez...
			// ============================================================
			$s = trim($_GET['s']);
			
			// Debug
			$debug_quest = false;
			
			// Check if Google Ads Option
			$google_ads_activated = get_option("equine_google_ads_active");
			$google_ads_code      = trim( get_option("equine_google_ads_code") );
			$google_ads_position  = (get_option("equine_google_ads_position") > 0) ? intval( get_option("equine_google_ads_position") ) : 5;
			
			// Get posts per page
			$posts_per_page = ($google_ads_activated && $google_ads_code != '') ? 11 : 12;
			
			// Initialisation
			$_post_type       = 'equine';
			$_post_status     = array( 'publish' ); // Statut issus de la recherche
			$_post_status_off = array( 'off' );     // Statut catalogue OFF
			$_post_orderby    = 'date';
			$_post_order      = 'DESC';
			$_posts_per_page  = $posts_per_page;
			
			// Price min max
			$_price_min = 5000;
			$_price_max = 100000;
			
			// Age min max
			$_age_min = 0;
			$_age_max = 20;
			
			// Distance min max
			$_distance_min = 50;
			$_distance_max = 1000;

			// 1- Création d'une requête personnalisée
			//$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
			$paged = (isset($_GET['page'])) ? intval($_GET['page']) : 1; // On récupère le paramètre GET dans l'URL
			
			// Initialize args			
			$meta_query_arg   = array();
			$meta_query_arg[] = array( 'key' => 'sold', 'value' => '0', 'compare' => '=' ); // Sauf les vendus
			//$meta_query_arg[] = array( 'key' => 'sold', 'value' => '1', 'compare' => '<' ); // Sauf les vendus
			//$meta_query_arg[] = array( 'key' => 'sold', 'value' => array('0'), 'compare' => 'IN' ); // Sauf les vendus
			
			switch($s) {
				default:
				case "search_main":
					// main_discipline
					// main_age_min / main_age_max
					// main_potential
					// main_price_min / main_price_max
					// main_localisation_latitude / main_localisation_longitude / main_localisation_distance
					// main_expertise
					// main_level
					// main_size
					// main_breed
					// main_gender
					// main_color
					// ----- RECHERCHE GLOBAL (navbar-search-content) -----
					$meta_query_arg_test = array();
					// --- Discipline
					$discipline = trim($_GET['main_discipline']);
					if (isset($discipline) && $discipline != '') {
						$arrdiscipline    = explode(",", $discipline);
						$meta_query_arg[] = array( 'key' => 'discipline', 'value' => $arrdiscipline, 'compare' => 'IN' );
					}
					// --- Age
					$age_min = intval( $_GET['main_age_min'] );
					$age_max = intval( $_GET['main_age_max'] );
					if ( ( (isset($age_min) && $age_min > $_age_min) ) || ( ( isset($age_max) && $age_max < $_age_max ) ) ) {
						if (( (isset($age_min) && $age_min != '') || $age_min == 0) && ( (isset($age_max) && $age_max != '') || $age_max == 0 ) ) {
							$date_min = (date('Y') - $age_min);
							$date_max = (date('Y') - $age_max);
							$meta_query_arg[] = array( 'key' => 'birthday', 'value' => $date_min, 'compare' => '<=', 'type' => 'NUMERIC' );
							$meta_query_arg[] = array( 'key' => 'birthday', 'value' => $date_max, 'compare' => '>=', 'type' => 'NUMERIC' );
						}
					}
					// --- Potentiel
					$potential = trim($_GET['main_potential']);
					if (isset($potential) && $potential > 0) {
						$arrpotential     = explode(",", $potential);
						$meta_query_arg[] = array( 'key' => 'potentiel', 'value' => $arrpotential, 'compare' => 'IN' );
					}
					// --- Prix					
					$price_min = intval($_GET['main_price_min']);
					$price_max = intval($_GET['main_price_max']);
					if ( ( (isset($price_min) && $price_min > $_price_min) ) || ( ( isset($price_max) && $price_max < $_price_max ) ) ) {
						if (isset($price_min) && isset($price_max)) {
							$meta_query_arg[] = array( 'key' => 'price_equipeer', 'value' => $price_min, 'compare' => '>=', 'type' => 'NUMERIC' );
							if ($price_max < $_price_max) $meta_query_arg[] = array( 'key' => 'price_equipeer', 'value' => $price_max, 'compare' => '<=', 'type' => 'NUMERIC' );
						}
					}
					// ANNONCES
					// --- Expertise
					// --- Libre	
					$to_expertise = intval($_GET['type_annonce_expert']);
					$to_free_ads  = intval($_GET['type_annonce_libre']);
					if ( (isset($to_expertise) && $to_expertise > 0) && (isset($to_free_ads) && $to_free_ads == 0) ) {
						$meta_query_arg[] = array( 'key' => 'type_annonce', 'value' => '2', 'compare' => '=', 'type' => 'NUMERIC' );
					}				
					if ( (isset($to_free_ads) && $to_free_ads > 0) && (isset($to_expertise) && $to_expertise == 0) ) {
						$meta_query_arg[] = array( 'key' => 'type_annonce', 'value' => '1', 'compare' => '=', 'type' => 'NUMERIC' );
					}
					// --- Niveau
					$level = trim($_GET['main_level']);
					if (isset($level) && $level != '') {
						$arrlevel = explode(",", $level);
						$meta_query_arg[] = array( 'key' => 'level', 'value' => $arrlevel, 'compare' => 'IN' );
					}
					// --- Taille
					$size = trim($_GET['main_size']);
					if (isset($size) && $size != '') {
						$arrsize = explode(",", $size);
						$meta_query_arg[] = array( 'key' => 'size', 'value' => $arrsize, 'compare' => 'IN' );
					}
					// --- Origine paternel
					$origin = stripslashes ( sanitize_text_field( trim($_GET['main_origin']) ) );
					$origin = htmlspecialchars( $origin, ENT_QUOTES );
					if (isset($origin) && $origin != '') {
						$meta_query_arg[] = array( 'key' => 'origin_sire', 'value' => $origin, 'compare' => 'LIKE' );
					}
					// --- Race
					$breed = trim($_GET['main_breed']);
					if (isset($breed) && $breed != '') {
						$arrbreed = explode(",", $breed);
						$meta_query_arg[] = array( 'key' => 'breed', 'value' => $arrbreed, 'compare' => 'IN' );
					}
					// --- Sexe
					$sex = trim($_GET['main_gender']);
					if (isset($sex) && $sex != '') {
						$arrsex = explode(",", $sex);
						$meta_query_arg[] = array( 'key' => 'sex', 'value' => $arrsex, 'compare' => 'IN' );
					}
					// --- Couleur
					$color = trim($_GET['main_color']);
					if (isset($color) && $color != '') {
						$arrcolor = explode(",", $color);
						$meta_query_arg[] = array( 'key' => 'dress', 'value' => $arrcolor, 'compare' => 'IN' );
					}
					// -----------------------------------------------------------
					$localisation_name = trim($_GET['autocomplete_global']);
					$latitudeFrom      = trim($_GET['main_localisation_latitude']);
					$longitudeFrom     = trim($_GET['main_localisation_longitude']);
					//$distance          = intval($_GET['main_around']);
					//$distance          = intval($_GET['main_localisation_distance']);
					$distance          = (isset($_GET['main_localisation_distance']) && intval($_GET['main_localisation_distance']) > 0) ? intval($_GET['main_localisation_distance']) : (($localisation_name != '') ? 50 : 0);
					//$distance          = (isset($_GET['main_around']) && intval($_GET['main_around']) > 0) ? intval($_GET['main_around']) : 1;
					if ( (isset($latitudeFrom) && $latitudeFrom != '') && (isset($longitudeFrom) && $longitudeFrom != '') ) {
						$_posts_per_page = -1;
					}
					// -----------------------------------------------------------
					$args = array(
						 'post_type'      => $_post_type
						,'post_status'    => $_post_status
						,'perm'           => 'readable' // Beware of setting the 'post_status' to anything other than 'public', as it can easily lead to an information disclosure vulnerability
						,'cache_results'  => true
						,'orderby'        => $_post_orderby
						,'order'          => $_post_order
						,'posts_per_page' => $_posts_per_page
						,'paged'          => $paged
						,'meta_query'     => array(
							$meta_query_arg
						)
					);
				break;
				case "search_ref":
					// ref
					// ----- RECHERCHE PAR REFERENCE -----
					$reference = intval($_GET['ref']);
					// -----------------------------------
					$args = array(
						'post_type'      => $_post_type,
						'post_status'    => $_post_status,
						'perm'           => 'readable', // Beware of setting the 'post_status' to anything other than 'public', as it can easily lead to an information disclosure vulnerability
						'cache_results'  => true,
						'orderby'        => $_post_orderby,
						'order'          => $_post_order,
						'posts_per_page' => $_posts_per_page,
						'paged'          => $paged,
						'meta_query'     => array(
							array(
								'key'     => 'reference',
								'value'   => $reference,
								'compare' => '=',
							)
						)
					);
				break;
				case "search_quest":
					// quest_discipline
					// quest_level
					// quest_age_min / quest_age_max
					// quest_price_min / quest_price_max
					// quest_gender
					// quest_localisation_latitude / quest_localisation_longitude
					// quest_localisation_distance / quest_localisation_name
					// ----- RECHERCHE PAR LE QUESTIONNAIRE TROUVEZ... -----
					// --- Type annonce (Expertisee)
					$meta_query_arg[] = array( 'key' => 'type_annonce', 'value' => '2', 'compare' => '=', 'type' => 'NUMERIC' );
					// --- Discipline
					$discipline = intval($_GET['quest_discipline']);
					if (isset($discipline) && $discipline > 0) {
						$meta_query_arg[] = array( 'key' => 'discipline', 'value' => $discipline, 'compare' => '=' );
					}
					if ($debug_quest) echo "Discipline: $discipline<br>";
					// --- Niveau
					$level    = trim($_GET['quest_level']);
					$arrlevel = explode(",", $level);
					if (isset($level) && $level > 0) {
						$meta_query_arg[] = array( 'key' => 'level', 'value' => $arrlevel, 'compare' => 'IN' );
					}
					if ($debug_quest) echo " - Niveau<pre>".var_dump($arrlevel)."</pre>";
					// --- Age
					$age_min  = intval( $_GET['quest_age_min'] );
					$age_max  = intval( $_GET['quest_age_max'] );
					//$date_min = ($age_min == 1) ? (date('Y') - 1) : (date('Y') - $age_min);
					$date_min = (date('Y') - $age_min);
					$date_max = (date('Y') - $age_max);
					if ( ( (isset($age_min) && $age_min > $_age_min) ) || ( ( isset($age_max) && $age_max < $_age_max ) ) ) {
						if (isset($age_min) && isset($age_max)) {
							$meta_query_arg[] = array( 'key' => 'birthday', 'value' => $date_min, 'compare' => '<=', 'type' => 'NUMERIC' );
							$meta_query_arg[] = array( 'key' => 'birthday', 'value' => $date_max, 'compare' => '>=', 'type' => 'NUMERIC' );
						}
					}
					if ($debug_quest) echo "Age min: $age_min - Age max: $age_max<br>";
					// --- Prix					
					$price_min = intval($_GET['quest_price_min']);
					$price_max = intval($_GET['quest_price_max']);
					if ( ( (isset($price_min) && $price_min > $_price_min) ) || ( ( isset($price_max) && $price_max < $_price_max ) ) ) {
						if (isset($price_min) && isset($price_max)) {
							$meta_query_arg[] = array( 'key' => 'price_equipeer', 'value' => $price_min, 'compare' => '>=', 'type' => 'NUMERIC' );
							if ($price_max < $_price_max) $meta_query_arg[] = array( 'key' => 'price_equipeer', 'value' => $price_max, 'compare' => '<=', 'type' => 'NUMERIC' );
						}
					}
					if ($debug_quest) echo "Prix min: $price_min - Prix max: $price_max<br>";
					// --- Sexe
					$sex    = trim($_GET['quest_gender']);
					$arrsex = explode(",", $sex);
					if (isset($sex) && $sex > 0) {
						$meta_query_arg[] = array( 'key' => 'sex', 'value' => $arrsex, 'compare' => 'IN' );
					}
					if ($debug_quest) echo " - Sexe:<pre>".var_dump($arrsex)."</pre>";
					$latitudeFrom      = trim($_GET['quest_localisation_latitude']);
					$longitudeFrom     = trim($_GET['quest_localisation_longitude']);
					$distance          = intval($_GET['quest_localisation_distance']);
					//$distance          = intval($_GET['quest_localisation_distance']);
					//$distance          = (intval($_GET['quest_localisation_distance']) > 0) ? intval($_GET['quest_localisation_distance']) : 1;
					if ( (isset($latitudeFrom) && $latitudeFrom != '') && (isset($longitudeFrom) && $longitudeFrom != '') ) {
						$_posts_per_page = -1;
					}
					$localisation_name = trim($_GET['quest_localisation_name']);
					if ($debug_quest) echo "Latitude (from): $latitudeFrom<br>";
					if ($debug_quest) echo "Longitude (from): $longitudeFrom<br>";
					if ($debug_quest) echo "Distance: $distance<br>";
					// -----------------------------------------------------
					$args = array(
						'post_type'      => $_post_type,
						'post_status'    => $_post_status,
						'perm'           => 'readable', // Beware of setting the 'post_status' to anything other than 'public', as it can easily lead to an information disclosure vulnerability
						'cache_results'  => true,
						'orderby'        => $_post_orderby,
						'order'          => $_post_order,
						'posts_per_page' => $_posts_per_page,
						//'paged'          => $paged,
						'no_found_rows'  => true,
						'meta_query'     => array(
							$meta_query_arg
						)
					);
					// -----------------------------------------------------
					$args_off = array(
						'post_type'      => $_post_type,
						'post_status'    => $_post_status_off,
						'perm'           => 'readable', // Beware of setting the 'post_status' to anything other than 'public', as it can easily lead to an information disclosure vulnerability
						'cache_results'  => true,
						'orderby'        => $_post_orderby,
						'order'          => $_post_order,
						'meta_query'     => array(
							$meta_query_arg
						)
					);
					// -----------------------------------------------------
				break;
			}
			
			// --- REQUEST with ARGS
			$query                 = new WP_Query( $args );
			$query_count_total     = $query->found_posts;
			$query_status_off      = new WP_Query( $args_off );
			//$query_num_rows        = $query->post_count;
			$query_count_total_off = $query_status_off->found_posts;
			if ($debug_quest) {
				echo 'T: '.$query_count_total;
				echo '<br>LQ: '.$query->request;
				echo '<pre>';
				var_dump($meta_query_arg);
				echo '</pre>';
			}
		?>

		<div class="container">
			
			<div class="row justify-content-md-left mt-3">
				<div id="your-search-criteria" class="col text-left">
					<h3 id="search_text_result">
						<?php
							//if ($query_count_total > 0) {
							//	echo __('With your search criteria', EQUIPEER_ID) . ' - ' . __('Founds', EQUIPEER_ID) . ' : ' . $query_count_total;
							//} else {
							//	echo __('Your search criteria', EQUIPEER_ID);
							//}
						?>
						<span id=""></span>
					</h3>
					<?php
						switch($s) {
							case "search_main":
								$_search_text = "";
								// ------------------------------
								// DISCIPLINE
								// ------------------------------
								if (isset($discipline) && $discipline != '') {
									$all_disciplines = equipeer_get_terms('equipeer_discipline', $meta_key = array(), $meta_value = '', $orderby = 'name', $order = 'ASC');
									$_search_text .= 'Catégories : ';
									echo __( 'Disciplines', EQUIPEER_ID ) . ' : ';
									$discipline_text = "";
									foreach($all_disciplines as $row) {
										if (in_array($row['id'], $arrdiscipline)) {
											$_search_text    .= $row['name'] . ' ';
											$discipline_text .= ', ' . $row['name'];
										}
									}
									$_search_text .= '<br>';
									echo trim( ltrim($discipline_text, ",") ) . '<br>';
								}
								// ------------------------------
								// AGE
								// ------------------------------
								if ( ( (isset($age_min) && $age_min > $_age_min) ) || ( ( isset($age_max) && $age_max < $_age_max ) ) ) {
									if ( ( (isset($age_min) && $age_min != '') || $age_min == 0 ) && ( ( isset($age_max) && $age_max != '' ) || $age_max == 0 ) ) {
										if ($age_min != $age_max) {
											if ($age_min == 0) $age_min = 'Foal';
											$text_age = ($age_max == 1) ? __('Age : From %s to %s year', EQUIPEER_ID) : __('Age : From %s to %s years', EQUIPEER_ID);
											$_search_text .= 'Age : De ' . $age_min . ' à ' . $age_max . ' ans<br>';
										} else {
											if ($age_min == 0) {
												$text_age = 'Age : Foal';
												$_search_text .= $text_age . '<br>';
											} elseif ($age_min == 1) {
												$text_age = __('Age : %s year', EQUIPEER_ID);
												$_search_text .= 'Age : ' . $age_min . ' an<br>';
											} else {
												$text_age = __('Age : %s years', EQUIPEER_ID);
												$_search_text .= 'Age : ' . $age_min . ' ans<br>';
											}
										}
										echo sprintf( $text_age, $age_min, $age_max ) . '<br>';
									}
								}
								// ------------------------------
								// POTENTIEL
								// ------------------------------
								if (isset($potential) && $potential != '') {
									$all_potentials = equipeer_get_terms('equipeer_potential', $meta_key = array(), $meta_value = '', $orderby = 'name', $order = 'ASC');
									$_search_text .= 'Potentiels : ';
									echo __( 'Potentials', EQUIPEER_ID ) . ' : ';
									$potential_text = "";
									foreach($all_potentials as $row) {
										if (in_array($row['id'], $arrpotential)) {
											$_search_text    .= $row['name'] . ' ';
											$potential_text .= ', ' . $row['name'];
										}
										
									}
									$_search_text .= '<br>';
									echo trim( ltrim($potential_text, ",") ) . '<br>';
								}
								// ------------------------------
								// PRIX
								// ------------------------------
								if ( ( (isset($price_min) && $price_min > $_price_min) ) || ( ( isset($price_max) && $price_max < $_price_max ) ) ) {
									if (isset($price_min) && isset($price_max)) {
										$_search_text .= 'Prix : ';
										echo __( 'Price', EQUIPEER_ID ) . ' : ';
										if ($price_max < 100000) {
											$text_price = __("Between %s &euro; and %s &euro;", EQUIPEER_ID);
											$_search_text .= 'Entre ' . number_format($price_min, 0, "", " ") . '&euro; et ' . number_format($price_max, 0, "", " ") . '<br>';
											echo sprintf($text_price, number_format($price_min, 0, "", " "), number_format($price_max, 0, "", " ")) . '<br>';
										} else {
											$text_price = __("From %s &euro;", EQUIPEER_ID);
											$_search_text .= 'A partir de ' . number_format($price_min, 0, "", " ") . '<br>';
											echo sprintf($text_price, number_format($price_min, 0, "", " ")) . '<br>';
										}
									}
								}
								// ------------------------------
								// TYPE D'ANNONCES
								// ------------------------------
								if ((isset($to_expertise) && $to_expertise > 0) || (isset($to_free_ads) && $to_free_ads > 0)) {
									$_search_text .= "Type d'annonces : ";
									echo __('Ads type', EQUIPEER_ID) . ' : ';
									if ($to_free_ads) {
										$_search_text .= 'Libre';
										echo __('Certified horses - Basic offer', EQUIPEER_ID);
									}
									if ($to_expertise) {
										if ($to_free_ads > 0) {
											$_search_text .= ' et ';
											echo ' ' . __('and', EQUIPEER_ID) . ' ';
										}
										$_search_text .= 'Expertisé';
										echo __( 'Appraised horses - Premium offer', EQUIPEER_ID );
									}
									$_search_text .= '<br>';
									echo '<br>';
								}
								// ------------------------------
								// NIVEAU
								// ------------------------------
								if (isset($level) && $level != '') {
									$_search_text .= "Niveaux : ";
									echo __( 'Level', EQUIPEER_ID ) . ' : ';
									$level_text = "";
									$all_levels = equipeer_get_terms('equipeer_level', $meta_key = array('equipeer_select_discipline_taxonomy_parent_id', 'equipeer_select_discipline_2_taxonomy_parent_id', 'equipeer_select_discipline_3_taxonomy_parent_id'), $meta_value, $orderby = 'name', $order = 'ASC');
									foreach($all_levels as $row) {
										if (in_array($row['id'], $arrlevel)) {
											$_search_text .= $row['name'] . ' ';
											$level_text   .= ', ' . $row['name'];
										}
									}
									$_search_text .= '<br>';
									echo trim( ltrim($level_text, ",") ) . '<br>';
								}
								// ------------------------------
								// TAILLE
								// ------------------------------
								if (isset($size) && $size != '') {
									$_search_text .= "Tailles : ";
									echo __( 'Sizes', EQUIPEER_ID ) . ' : ';
									$size_text = "";
									$all_sizes  = equipeer_get_terms('equipeer_size', $meta_key = array(), $meta_value = '', $orderby = 'id', $order = 'ASC');
									foreach($all_sizes as $row) {
										if (in_array($row['id'], $arrsize)) {
											$_search_text .= $row['name'] . ' ';
											$size_text .= ', ' . $row['name'];
										}
									}
									$_search_text .= '<br>';
									echo trim( ltrim($size_text, ",") ) . '<br>';
								}
								// ------------------------------
								// ORIGINE PATERNELLE
								// ------------------------------
								if (isset($origin) && $origin != '') {
									$_search_text .= "Origine paternelle : " . $origin . '<br>';
									echo __( 'Perennial origin', EQUIPEER_ID ) . ' : ' . $origin . '<br>';;
								}
								// ------------------------------
								// RACE
								// ------------------------------
								if (isset($breed) && $breed != '') {
									$_search_text .= "Races : ";
									echo __( 'Breeds', EQUIPEER_ID ) . ' : ';
									$breed_text = "";
									$all_breeds  = equipeer_get_terms('equipeer_breed', $meta_key = array(), $meta_value = '', $orderby = 'id', $order = 'ASC');
									foreach($all_breeds as $row) {
										if (in_array($row['id'], $arrbreed)) {
											$_search_text .= $row['name'] . ' ';
											$breed_text   .= ', ' . $row['name'];
										}
									}
									$_search_text .= '<br>';
									echo trim( ltrim($breed_text, ",") ) . '<br>';
								}
								// ------------------------------
								// SEXE
								// ------------------------------
								if (isset($sex) && $sex != '') {
									$_search_text .= "Sexe : ";
									echo __( 'Sex', EQUIPEER_ID ) . ' : ';
									$sex_text    = "";
									$all_genders = equipeer_get_terms('equipeer_gender', $meta_key = array(), $meta_value = '', $orderby = 'id', $order = 'ASC');
									foreach($all_genders as $row) {
										if (in_array($row['id'], $arrsex)) {
											$_search_text .= $row['name'] . ' ';
											$sex_text     .= ', ' . $row['name'];
										}
									}
									$_search_text .= '<br>';
									echo trim( ltrim($sex_text, ",") ) . '<br>';
								}
								// ------------------------------
								// ROBE
								// ------------------------------
								if (isset($color) && $color != '') {
									$_search_text .= "Robe : ";
									echo __( 'Color', EQUIPEER_ID ) . ' : ';
									$color_text = "";
									$all_colors = equipeer_get_terms('equipeer_color', $meta_key = array(), $meta_value = '', $orderby = 'id', $order = 'ASC');
									foreach($all_colors as $row) {
										if (in_array($row['id'], $arrcolor)) {
											$_search_text .= $row['name'] . ' ';
											$color_text   .= ', ' . $row['name'];
										}
									}
									$_search_text .= '<br>';
									echo trim( ltrim($color_text, ",") ) . '<br>';
								}
								// ------------------------------
								// LOCALISATION
								// ------------------------------
								if (trim($localisation_name) != '') {
									$distance_text = ($distance < 2) ? 0 : $distance;
									$_search_text .= 'Localisation : ' . stripslashes($localisation_name) . ' (Rayon de ' . $distance_text . 'km)<br>';
									$text_localization = __("Within a radius of %s km", EQUIPEER_ID);
									echo __( 'Localization', EQUIPEER_ID ) . ' : ' . stripslashes($localisation_name) . ' (' . sprintf($text_localization, $distance_text) . ')<br>';
								}
							break;
							case "search_ref":
								// ------------------------------
								// REFERENCE
								// ------------------------------
								$_search_text .= 'Ref : '.$reference;
								echo __( 'Reference', EQUIPEER_ID ) . ' : ';
								echo $reference;
							break;
							case "search_quest":
								$_search_text = "";
								// ------------------------------
								// DISCIPLINE
								// ------------------------------
								$all_disciplines = equipeer_get_terms('equipeer_discipline', $meta_key = array(), $meta_value = '', $orderby = 'id', $order = 'ASC');
								$_search_text .= 'Catégories : ';
								echo __( 'Discipline', EQUIPEER_ID ) . ' : ';
								foreach($all_disciplines as $row) {
									if ($discipline == $row['id']) {
										$_search_text .= $row['name'] . '<br>';
										echo $row['name'] . '<br>';
									}
								}
								// ------------------------------
								// NIVEAU
								// ------------------------------
								echo __( 'Level', EQUIPEER_ID ) . ' : ';
								if (array_keys( $arrlevel, true )) {
									$level_text = "";
									$all_levels = equipeer_get_terms('equipeer_level', $meta_key = array('equipeer_select_discipline_taxonomy_parent_id', 'equipeer_select_discipline_2_taxonomy_parent_id', 'equipeer_select_discipline_3_taxonomy_parent_id'), $meta_value, $orderby = 'name', $order = 'ASC');
									$_search_text .= 'Niveau : ';
									foreach($all_levels as $row) {
										if (in_array($row['id'], $arrlevel)) {
											$_search_text .= $row['name'] . ' ';
											$level_text .= ", ".$row['name'];
										}
									}
									$_search_text .= '<br>';
									echo trim( ltrim($level_text, ",") ) . '<br>';
								} else {
									echo '--<br>'; // $arrlevel
								}
								// ------------------------------
								// AGE
								// ------------------------------
								$text_age = __('Age : From %s to %s years', EQUIPEER_ID);
								$_search_text .= 'Age : De ' . $age_min . ' à ' . $age_max . ' ans<br>';
								echo sprintf( $text_age, $age_min, $age_max ) . '<br>';
								// ------------------------------
								// PRIX
								// ------------------------------
								$_search_text .= __( 'Price', EQUIPEER_ID ) . ' : ';
								echo __( 'Price', EQUIPEER_ID ) . ' : ';
								if ($price_max < 100000) {
									$text_price = __("Between %s &euro; and %s &euro;", EQUIPEER_ID);
									$_search_text .= 'Entre ' . number_format($price_min, 0, "", " ") . '&euro; et ' . number_format($price_max, 0, "", " ") . '<br>';
									echo sprintf($text_price, number_format($price_min, 0, "", " "), number_format($price_max, 0, "", " ")) . '<br>';
								} else {
									$text_price = __("From %s &euro;", EQUIPEER_ID);
									$_search_text .= 'A partir de ' . number_format($price_min, 0, "", " ") . '<br>';
									echo sprintf($text_price, number_format($price_min, 0, "", " ")) . '<br>';
								}
								// ------------------------------
								// SEXE
								// ------------------------------
								echo __( 'Sex', EQUIPEER_ID ) . ' : ';
								if (isset($sex)) {
									$_search_text .= "Sexe : "; 
									$sex_text    = "";
									$all_genders = equipeer_get_terms('equipeer_gender', $meta_key = array(), $meta_value = '', $orderby = 'id', $order = 'ASC');
									foreach($all_genders as $row) {
										if (in_array($row['id'], $arrsex)) {
											$_search_text .= $row['name'] . ' ';
											$sex_text .= ", ".$row['name'];
										}
									}
									$_search_text .= '<br>';
									echo trim( ltrim($sex_text, ",") ) . '<br>';
								} else {
									echo '--';
								}
								// ------------------------------
								// LOCALISATION
								// ------------------------------
								//if ($distance > 0 && $distance < 1000) {
								if (trim($localisation_name) != '') {
									$distance_text = ($distance < 2) ? 0 : $distance;
									$_search_text .= 'Localisation : ' . stripslashes($localisation_name) . ' (Rayon de ' . $distance_text . 'km)<br>';
									$text_localization = __("Within a radius of %s km", EQUIPEER_ID);
									echo __( 'Localization', EQUIPEER_ID ) . ' : ' . stripslashes($localisation_name) . ' (' . sprintf($text_localization, $distance_text) . ')<br>';
								}
							break;
						}
					?>
				</div>
			</div>

			<div id="the_container" class="row">
			<?php // 2- Boucle chevaux
			$array_horses   = array();
			$count_horses   = 0;
			$google_ads_cpt = 1;
			
			// !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
			// !!!!!!!!!!!!!! DISTANCE (Bug) !!!!!!!!!!!!!!
			// !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
			//$distance = ($distance < 2) ? 0 : $distance;
			// !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
			
			$debug_trace = false;
			if ($debug_trace) $j = 1;
			
			if ( $query->have_posts() ) {
			
				while ( $query->have_posts() ) {

					$query->the_post(); // Don't remove this line (required for loop)
					
					if ($debug_trace) echo " J$j - ";
					
					// Check if localization required
					if ($debug_trace) {
						echo '$latitudeFrom: '.$latitudeFrom.'<br>';
						echo '$longitudeFrom: '.$longitudeFrom.'<br>';
						echo '$distance: '.$distance.'<br>';
						echo 'search: '.$s.'<br>';
					}
					if ( (isset($latitudeFrom) && $latitudeFrom != '') && (isset($longitudeFrom) && $longitudeFrom != '') && ($s == 'search_quest' || $s == 'search_main') ) {
					//if ( (isset($latitudeFrom) && $latitudeFrom != '') && (isset($longitudeFrom) && $longitudeFrom != '') && (isset($distance) && $distance > $_distance_min && $distance < $_distance_max) && ($s == 'search_quest' || $s == 'search_main') ) {
					// Localization
					//if ( (isset($distance) && $distance > $_distance_min && $distance < $_distance_max) && ($s == 'search_quest' || $s == 'search_main') ) {
						if ($debug_trace) echo " K$j - ";
						// Get information localization
						$the_id = $query->post->ID;
						$localisation_latitude  = (get_post_meta( $the_id, 'localisation_latitude', true ) != '') ? get_post_meta( $the_id, 'localisation_latitude', true ) : false;
						$localisation_longitude = (get_post_meta( $the_id, 'localisation_longitude', true ) != '') ? get_post_meta( $the_id, 'localisation_longitude', true ) : false;
						// Check distance between points from horse localization
						if ($localisation_latitude && $localisation_longitude) {
							$get_distance = equipeer_get_distance_between_points($latitudeFrom, $longitudeFrom, $localisation_latitude, $localisation_longitude);
							if ($debug_trace) echo "&nbsp;<span style='color: red;'>L$j (".$get_distance->kilometers.")</span> - ";
							// Check distance
							// @return different measures (object)
							// $get_distance->miles
							// $get_distance->feet
							// $get_distance->yards
							// $get_distance->kilometers
							// $get_distance->meters
							if (ceil($get_distance->kilometers) <= $distance) {
								if ($debug_trace) echo " <span style='color: green;'>".ceil($get_distance->kilometers)." <= $distance</span> - ";
								// Check if Google Ads Activated
								// Afficher apres X annonces
								if ($posts_per_page == 11  && $google_ads_cpt == $google_ads_position) {
									?>
										<div class="col-lg-4 col-md-6 col-sm-12 p-3-eq archive-card archive-card-pub">
										   <div class="h-100 text-center eq-color horse-list">
												<?php echo $google_ads_code; ?>
										   </div>
										</div>
									<?php
								}
								get_template_part( 'templates/equine/archive', 'card' );
								$array_horses[] = $the_id;
								$count_horses++;
								$google_ads_cpt++;
								// --------------------------------------
								// Initialize PREV LIST NEXT
								// --------------------------------------
								$_SESSION['equipeer_user_list'][] = $query->post->ID;
								// Get full back list URL
								$_SESSION['equipeer_list_back'] = equipeer_current_url();
								// --------------------------------------
								// Check if search quest (8 max)
								// --------------------------------------
								if ($s == 'search_quest' && $count_horses == 8) {
									break;
								}
							}
						}
					} else {
						// -------------------------------------------
						// Pas de recherche de localisation
						// -------------------------------------------
						if ($debug_trace) echo " O$j - ";
						// Check if Google Ads Activated
						// Afficher apres X annonces
						if ($posts_per_page == 11  && $google_ads_cpt == $google_ads_position) {
							?>
								<div class="col-lg-4 col-md-6 col-sm-12 p-3-eq archive-card archive-card-pub">
								   <div class="h-100 text-center eq-color horse-list">
										<?php echo $google_ads_code; ?>
								   </div>
								</div>
							<?php
						}
						get_template_part( 'templates/equine/archive', 'card' );
						$array_horses[] = $the_id;
						$count_horses++;
						$google_ads_cpt++;
						// --------------------------------------
						// Initialize PREV LIST NEXT
						// --------------------------------------
						$_SESSION['equipeer_user_list'][] = $query->post->ID;
						// Get full back list URL
						$_SESSION['equipeer_list_back'] = equipeer_current_url();
					}
					
				}
				wp_reset_postdata(); // On réinitialise les données
				
				$custom_pagination = true;
			?>
			</div>
			
			<script>
				jQuery(function($) {
					var $divs = $("div.archive-card");
					var typeOrderedDivs = $divs.sort(function (a, b) {
						return $(a).find("h5").text() < $(b).find("h5").text();
					});
					$("#the_container").html(typeOrderedDivs);
					<?php if (11 == $posts_per_page) { ?>
						// if pub
						var $pub = $("div.archive-card-pub");
						$('#the_container div.archive-card:nth-child(4)').after($pub);
					<?php } ?>
					// ---------------------------------------
					// Equine LIST (click URL)
					// jQuery Click Event On Div, Except Child Div
					// ---------------------------------------
					$(".horse-list").click(function(e) {
						if ($(e.target).hasClass('equine-add-selection')) {
							// Don't change page when click on ADD TO SELECTION
							return false;
						}
						var url = $(this).attr('data-click-url');
						if (url !== '') document.location = url;
					});
					// ---------------------------------------
					// --- User Not connected
					// ---------------------------------------
					$(".equipeer-not-connected").on('click', function(e) {
						e.preventDefault();
						var swal_title        = $(this).attr('data-title');
						var swal_text         = $(this).attr('data-text');
						var swal_cancel       = $(this).attr('data-cancel');
						var swal_connect      = $(this).attr('data-connect');
						var swal_connect_url  = $(this).attr('data-connect-url');
						var swal_register     = $(this).attr('data-register');
						var swal_register_url = $(this).attr('data-register-url');
						Swal.fire({
							title: swal_title,
					  //html: swal_text + '<br><div class="swal2-div"><button type="button" role="button" tabindex="0" class="swal2-styled swal2-link" onclick="documentLocation(\'login\')">' + swal_connect + '</button>' + '<button type="button" role="button" tabindex="0" class="swal2-confirm swal2-styled" onclick="Swal.close()">' + swal_cancel + '</button>' + '<button type="button" role="button" tabindex="0" class="swal2-styled swal2-link equipeer-link" onclick="documentLocation(\'register\')">' + swal_register + '</button></div>',
					  html: swal_text + '<br><div class="swal2-div"><button type="button" role="button" tabindex="0" class="swal2-styled swal2-link" onclick="documentLocation(\'login\')">' + swal_connect + '</button>' + '<button type="button" role="button" tabindex="0" class="swal2-styled swal2-link equipeer-link" onclick="documentLocation(\'register\')">' + swal_register + '</button></div>',
							icon: "warning",
					  showCloseButton: true,
					  showCancelButton: false,
					  showConfirmButton: false,
						});
					});				
					// -----------------------------
					// Add / Del selection (CLICK)
					// -----------------------------
					$('.action-to-selection').click(function (e) {
						e.preventDefault();
						// Initialize
						var the_button  = $(this);
						var the_counter = $("#equine-selection-counter");
						// Ajax loader replaces text
						the_button.html('<div class="equine-load-45 spinner-equipeer-add-del"><i class="text-light spinner-grow spinner-grow-sm" role="status"></i></div>');
						// Get infos
						var post_id          = $(this).attr('data-pid');  // Post ID
						var user_id          = $(this).attr('data-uid');  // User ID
						var switch_op        = $(this).attr('data-op');   // OP to do
						var is_mini          = $(this).attr('data-mini'); // Is mini
						var pid_ref          = $(this).attr('data-ref');  // Horse REF
						var pid_sexe         = $(this).attr("data-sexe");
						var pid_robe         = $(this).attr("data-robe");
						var pid_taille       = $(this).attr("data-taille");
						var pid_age          = $(this).attr("data-age");
						var pid_discipline   = $(this).attr("data-discipline");
						var pid_potentiel    = $(this).attr("data-potentiel");
						var pid_photo        = $(this).attr("data-photo_licol");
						var pid_price        = $(this).attr("data-price");
						var pid_localisation = $(this).attr("data-localisation");
						var pid_url          = $(this).attr("data-url");
						// Post Ajax Request
						$.ajax({
							type: "POST",                // use $_POST request to submit data
							url: equipeer_ajax.ajaxurl,  // URL to "wp-admin/admin-ajax.php"
							data: {
								action : 'equipeer_to_selection', // wp_ajax_*, wp_ajax_nopriv_*
								pid    : post_id,  // Post ID
								uid    : user_id,  // User ID
								op     : switch_op // ADD Operation
							},
							success:function(response) {
								//alert(response);
								var retour      = response.split("|");
								var resultat    = (retour[0] == 1) ? 'error' : 'success'; // 0: success | 1: error
								var title       = retour[1];
								var description = retour[2];
								var counter_tot = parseInt(retour[3]);
								//if (ajax_debug_selection === true) console.log("Resultat: " + resultat + " - " + retour);
								// Add counter or NOT
								if (resultat == 'success') {
									var _html_text = "";
									switch(switch_op) {
										case "add":
											// -----------------------------
											// ADD Operation
											// -----------------------------							
											// Change text / class button
											_html_text = (!is_mini) ? '<i class="fas fa-star"></i>&nbsp;&nbsp;' + equipeer_ajax.txt_removefromselection : '<i class="fas fa-star"></i>';
											the_button.removeClass('equine-add-selection').addClass('equine-del-selection').attr('data-op', 'del').html( _html_text );
											// Change counter
											$('#navbarDropdownSelection i.fa-star').html('<span id="equine-selection-counter" class="badge badge-danger">'+counter_tot+'</span>');
											// Display Send Selection button
											$('#equipeer-send-my-selection').css('display', 'block');
											// -----------------------------
											// FACEBOOK PIXEL TRACKING : ADDTOCART
											// -----------------------------
											fbq('track', 'AddToCart', {
												contents: [
													{
														id: pid_ref,
														quantity: 1
													}
												],
												content_ids: pid_ref,
												content_name: 'ADD TO SELECTION',
												content_type: 'product'
											});
											// -----------------------------
											// SEND IN BLUE : ADD_TO_SELECTION
											// -----------------------------
											sendinblue.track(
												'add_to_selection', {
													"id": pid_ref,
													"sexe": pid_sexe,
													"robe": pid_robe,
													"taille": pid_taille,
													"age": pid_age,
													"discipline": pid_discipline,
													"potentiel": pid_potentiel,
													"photo_licol": pid_photo,
													"price": pid_price,
													"localisation_code_postal": pid_localisation,
													"impression": '',
													"url": pid_url
												}
											);
										break;
										case "del":
											// -----------------------------
											// DEL Operation
											// -----------------------------
											// Change text / class button
											_html_text = (!is_mini) ? '<i class="fas fa-star"></i>&nbsp;&nbsp;' + equipeer_ajax.txt_addtoselection : '<i class="fas fa-star"></i>';
											the_button.removeClass('equine-del-selection').addClass('equine-add-selection').attr('data-op', 'add').html( _html_text );
											// Check if Counter is equal to 0
											// navbarDropdownSelection i.fa-star
											// REMOVE <span id="equine-selection-counter" class="badge badge-danger">0</span>
											if (counter_tot == 0) {
												$('#navbarDropdownSelection i.fa-star').html('');
												// Hide Send Selection button
												$('#equipeer-send-my-selection').css('display', 'none');
											} else {
												// Change counter menu
												$('#navbarDropdownSelection i.fa-star').html('<span id="equine-selection-counter" class="badge badge-danger">'+counter_tot+'</span>');
												// Display Send Selection button
												$('#equipeer-send-my-selection').css('display', 'block');
											}
											// -----------------------------
											// FACEBOOK PIXEL TRACKING : ADDTOCART
											// -----------------------------
											fbq('track', 'AddToCart', {
												contents: [
													{
														id: pid_ref,
														quantity: 1
													}
												],
												content_ids: pid_ref,
												content_name: 'DEL SELECTION',
												content_type: 'product'
											});
										break;
									}
								}
								// Display RESULT in Sweet Alert 2
								Swal.fire({
										icon: resultat,
										title: title,
										text: description,
										customClass: {
											closeButton: 'swal-eq-close-button-class',
											confirmButton: 'swal-eq-confirm-button-class',
											cancelButton: 'swal-eq-cancel-button-class',
											//container: 'container-class',
											//popup: 'popup-class',
											//header: 'header-class',
											//title: 'title-class',
											//icon: 'icon-class',
											//image: 'image-class',
											//content: 'content-class',
											//input: 'input-class',
											//actions: 'actions-class',
											//footer: 'footer-class'
										}
									});
				
							},
							error: function(errorThrown) {
								alert("Une erreur est survenue.\nRéessayez ou contacter un administrateur");
								console.log(errorThrown); // Error
							}
						});
						
						return false;
					});
				});
			</script>

			<div rel="<?php echo $count_horses; ?>" class="row justify-content-md-left mt-3">
				
				<?php //if ($query_count_total == 0) { ?>
				<?php if ($count_horses == 0) { ?>
						<div>
							<h3><?php _e( "No horses available", 'wp-bootstrap-starter'); ?></h3>
						</div>
					</div>
					<div class="row justify-content-md-center mt-3">
				<?php } ?>
				
				<div class="col text-center" data-count="<?php echo $count_horses; ?>">
					<!-- Sauvegarder ma recherche -->
					<?php echo do_shortcode('[equine-save-my-search]'); ?>
				</div>

			</div>

			<div class="row justify-content-md-center">
				<div class="col">
					<?php
						
						if ($custom_pagination) {
							
							equipeer_pagination( $query->max_num_pages, $range = 2, $type = 'search' );
							
						} else {
						
							// 3- Appel de la fonction paginate_links
							$big = 999999999;
			
							echo paginate_links( array( // Plus d'info sur les arguments possibles : https://codex.wordpress.org/Function_Reference/paginate_links
								'base'    => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
								'format'  => '?paged=%#%',
								'current' => max( 1, get_query_var('paged') ),
								'total'   => $query->max_num_pages
							) ); 
							//Fin de la fonction paginate_links
						}
					
					?>
				</div>
						
			<?php } else { ?>
				<?php
					// --------------------------------------------
					// --- Check if canassons en stock OFF
					// Desole, nous n'avons pas d'equide disponible en ligne correspondant a vos criteres de recherche.
					$search_empty_text = __("Sorry, we don't have any equine available online matching your search criteria.", EQUIPEER_ID);
					// --------------------------------------------
				?>
				<h3 id="search-empty" class="eq-red"><?php echo $search_empty_text; ?></h3>
				<?php
					// Show message if count > 0 from OFF Status
					if ($query_count_total_off > 0) {
						if ($query_count_total_off == 1) {
							echo '<h3 id="search-empty-off" class="eq-fs400 eq-italic eq-blue">' . sprintf( __("But we have 1 horse which correspond in our Off-market catalog.", EQUIPEER_ID), $query_count_total_off ) . '</h3>';
						} else {
							echo '<h3 id="search-empty-off" class="eq-fs400 eq-italic eq-blue">' . sprintf( __("But we have %s horses which correspond in our Off-market catalog.", EQUIPEER_ID), $query_count_total_off ) . '</h3>';
						}
					}
				?>
				<!-- Sauvegarder ma recherche -->
				<div class="mt-1 eq-w100">
				<?php
					echo do_shortcode('[equine-save-my-search large=true red=true]');
					// Pour etre alerte par email des la mise en ligne d'un cheval correspondant a vos criteres
					echo '<div class="eq-description">' . __("To be alerted by email when a horse corresponding to your criteria is put online", EQUIPEER_ID) . '</div>';
				?>
				</div>
				
				<!-- Bouton Transmettre mon projet d'achat a l'equipe d'Equipeer SPORT -->
				<div id="eq-show-form-off-button" class="mt-4 eq-w100">
					<a id="eq-show-form-off" role="button" class="eq-button eq-button-blue eq-cursor eq-w100"><?php _e("Transmit my purchase project to the EQUIPEER SPORT team", EQUIPEER_ID); ?></a>
					<script>
						jQuery("#eq-show-form-off").click(function(e) {
							e.preventDefault();
							jQuery("#eq-show-form-off-button").hide(500);
							jQuery("#search-empty-form").show(500);
						});
					</script>
					<br>
					<?php
						if ($query_count_total_off > 0) {
							// Pour nous transmettre votre requete et/ou avoir plus d'informations sur les chevaux du catalogue off-market qui correspondent a vos criteres
							echo '<div class="eq-description">' . __("To send us your request and / or have more information about the horses in the off-market catalog that meet your criteria", EQUIPEER_ID) . '</div>';
						}
					?>
				</div>
				
				<div id="search-empty-form" class="mt-2 eq-w100" style="display: none;">
					<?php
						echo do_shortcode('[wpforms id="2823"]');
						$_new_search_textarea = str_replace("<br>", " / ", html_entity_decode($_search_text));
						$new_search_textarea  = rtrim( trim($_new_search_textarea), "/" );
					?>
					<script>
						jQuery(document).ready(function($) {
							$("#wpforms-2823-field_9").val("<?php echo nl2br($new_search_textarea); ?>");
						});
					</script>
				</div>
			<?php } ?>
			
			</div>
			
			<?php
				// -----------------------------------------
				// ---------- INSERT SEARCH IN DB ----------
				// -----------------------------------------
				// `id` int(11) NOT NULL,
				// `uid` int(11) DEFAULT NULL,
				// `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
				// `url` text NOT NULL,
				// `username` varchar(255) DEFAULT NULL,
				// `formname` varchar(100) NOT NULL,
				// `result` int(11) NOT NULL DEFAULT '0',
				// `search_text` text
				// -----------------------------------------
				$search_db_uid      = (get_current_user_id()) ? get_current_user_id() : NULL;
				$search_db_url      = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
				$search_db_username = (get_current_user_id()) ? get_user_by('id', get_current_user_id())->user_nicename : NULL;
				$search_db_formname = $s;
				$search_db_search_t = $_search_text;
				$search_db_ip       = isset($_SERVER['HTTP_CLIENT_IP']) ? $_SERVER['HTTP_CLIENT_IP'] : (isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR']);
				// -----------------------------------------
				// --- Initialize
				$_session_search = md5(trim(strip_tags($_search_text)));
				// --- Check if search is already inserted
				if ($_SESSION['equipeer_user_search'] != $_session_search && $search_db_uid != 3121) {
					// -----------------------------------------
					$wpdb->insert( 
						Equipeer()->tbl_equipeer_user_search, 
						array( 
							 'uid'         => $search_db_uid
							,'url'         => $search_db_url
							,'username'    => $search_db_username
							,'formname'    => $search_db_formname
							,'result'      => $count_horses
							,'search_text' => $search_db_search_t
							,'ip'          => $search_db_ip
						), 
						array( '%d', '%s', '%s', '%s', '%s', '%s', '%s' ) 
					);
					// ---------------------------------------------
					// --- Check if result is 0, send email to ADMIN
					// ---------------------------------------------
					if ($count_horses == 0) {
						// (string|array) (Required) Array or comma-separated list of email addresses to send message
						$emails      = (get_option('equine_email_admin_search') != '') ? get_option('equine_email_admin_search') : get_option('admin_email');
						$comma       = strpos($emails, ","); // Search if several emails
						$to          = ($comma === false) ? $emails : explode(",", $emails);
						// (string) (Required) Email subject
						$subject     = 'Recherche infructueuse (Formulaire EQUIPEER)';
						// (string) (Required) Message content
						$_username   = ($search_db_username) ? '<a href="'.get_admin_url().'user-edit.php?user_id='.get_current_user_id().'">'.$search_db_username.'</a>' : 'Visiteur';
						$message     = "Bonjour Admin,<br><br>Un client ($_username - $search_db_ip) a effectué une recherche infructueuse.<br><br>Voici ses critères de recherche :<br>$_search_text<br><br>Message automatique provenant du site EQUIPEER à l'attention des administrateurs du site.";
						// (string|array) (Optional) Additional headers
						$headers[]   = 'Content-Type: text/html; charset=UTF-8';
						$headers[]   = 'From: ADMIN Equipeer <noreply@equipeer.com>';
						// (string|array) (Optional) Files to attach. Default value: array()
						$attachments = array();
						// Sends an email, similar to PHP's mail function
						wp_mail( $to, $subject, $message, $headers, $attachments );
					}
				}
				// Register Current SESSION
				$_SESSION['equipeer_user_search'] = $_session_search;
				//echo 'LQ: '.$wpdb->last_query;
			?>
			
		</div>
	 
	</div><!-- #content -->
</div><!-- #primary -->

<?php
	// Show count
	switch($s) {
		default:
		case "search_main":
		case "search_ref":
			if ( (isset($latitudeFrom) && $latitudeFrom != '') && (isset($longitudeFrom) && $longitudeFrom != '') ) {
				$count_horses = $count_horses;
			} else {
				$count_horses = $query_count_total;
			}
		break;
		case "search_quest":
			$count_horses = $count_horses;
		break;
	}
?>

<?php get_template_part( 'template-parts/footer', 'page' ); ?>

<script>
	var search = true;
	var equipeer_search_text = "<?php echo str_replace("'", " ", $_search_text); ?>";
	jQuery(document).ready(function($) {
		
		// Change h1
		switch("<?php echo $s; ?>") {
			default:
			case "search_main":
				$('#content-header h1').text( "<?php _e('Search', EQUIPEER_ID); ?>" );
			break;
			case "search_ref":
				$('#content-header h1').text( "<?php _e('Search by reference', EQUIPEER_ID); ?>" );
			break;
			case "search_quest":
				$('#content-header h1').text( "<?php _e('Search your horse', EQUIPEER_ID); ?>" );
			break;
		}
		
		$('#search-validation span#search_counter').html('&nbsp;(<?php echo $count_horses; ?>)');
		<?php if ($count_horses > 0) { ?>
			$('#your-search-criteria h3#search_text_result').html("<?php echo __('With your search criteria', EQUIPEER_ID) . ' - ' . __('Founds', EQUIPEER_ID) . ' : ' . $count_horses; ?>");	
		<?php } else { ?>
			$('#your-search-criteria h3#search_text_result').html("<?php echo __('Your search criteria', EQUIPEER_ID); ?>");
		<?php } ?>
	});
</script>
 
<?php get_footer(); ?>