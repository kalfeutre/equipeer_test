<?php
/**
 * Blocking direct access to plugin
 */
defined('ABSPATH') or die('Are you crazy!');

$equipeer_current_password_txt = __('Enter your password', EQUIPEER_ID);

/**
 * Include files
 *
 * @param	$script_path	Script PATH
 *
 * @return file included
 */
if (!function_exists("equipeer_global_include")) {
	function equipeer_global_include($script_path) {
		// check if the file to include exists:
		if (isset($script_path) && is_file($script_path)) {
			// extract variables from the global scope:
			extract($GLOBALS, EXTR_REFS);
			ob_start();
			include($script_path);
			return ob_get_clean();
		} else {
			ob_clean();
		}
	}
}

/**
 * Show date ISO in various format
 * This method return string to display
 *
 * @param	$date		Date ISO Format from MySQL
 * @param	$format		Format to return (ISO, US, UST, FR, FRT, FRH, YEAR)
 *
 * @return converted string
 */
if (!function_exists("equipeer_convert_date")) {
	function equipeer_convert_date($date, $format = 'ISO') {
		switch(strtoupper($format)) {
			// Format ISO (AAAA-MM-DD)
			default: return strftime("%F", strtotime($date)); break;
			// Format US (MM-DD-AAAA)
			case "US": return strftime("%m/%d/%Y", strtotime($date)); break;
			// Format US (MM-DD-AAAA HH:mm:ss)
			case "UST": return strftime("%m/%d/%Y %T", strtotime($date)); break;
			// Format FR (DD-MM-AAAA)
			case "FR": return strftime("%d/%m/%Y", strtotime($date)); break;
			// Format FR (DD-MM-AAAA)
			case "FR2": return strftime("%d-%m-%Y", strtotime($date)); break;
			// Format FR (DD-MM-AAAA)
			case "FR3": return strftime("%d-%m-%Y à %T", strtotime($date)); break;
			// Format FR (DD-MM-AAAA HH:mm:ss) with time
			case "FRT": return strftime("%d-%m-%Y %T", strtotime($date)); break;
			// Format FRH (DD MM AAAA) Human readable
			case "FRH": return strftime("%e %B %Y", strtotime($date)); break;
			// Year (AAAA)
			case "YEAR": return strftime("%Y", strtotime($date)); break;
		}
	}
}

/**
 * Get name by type horse
 *
 * @param	$type		string
 *
 * @return converted string
 */
if (!function_exists("equipeer_type_horse")) {
	function equipeer_type_horse($type) {
		switch(strtolower($type)) {
			case "horse": return __( 'Horse', EQUIPEER_ID ); break;
			case "pony":  return __( 'Pony', EQUIPEER_ID ); break;
			default: return '--';
		}
	}
}

/**
 * Calculate Years number between two dates
 *
 * @param	$birthday_date	Date of birth 
 * 
 * @return string
 */
if (!function_exists("equipeer_get_age")) {
	function equipeer_get_age($birthday_date = '') {
		// Check if birthdate exists
		if ($birthday_date != '') {
			$datetime1 = new DateTime("$birthday_date");    // Date dans le passe
			$datetime2 = new DateTime(date("Y-m-d H:i:s")); // Date du jour (2018-09-07 16:10:21)
			$interval  = $datetime1->diff($datetime2);      // Calcul de la difference
			$age       = $interval->format('%y') + 1;       // X annees
			// -------------------------------------------
			$age .= ($age > 1) ? " " . __( 'years', EQUIPEER_ID ) : " " . __( 'year', EQUIPEER_ID );
		} else {
			$age = "--";
		}
		return $age;
	}
}

/**
 * Calculate Years number between two years
 *
 * @param	$birthday_year	Year of birth 
 * 
 * @return string
 */
if (!function_exists("equipeer_get_age_by_year")) {
	function equipeer_get_age_by_year($birthday_year = '') {
		// Check if birthdate exists
		if ($birthday_year != '') {
			// -------------------------------------------
			$age = (date('Y') - $birthday_year);
			// -------------------------------------------
			//$age .= ($age > 1) ? " " . __( 'years', EQUIPEER_ID ) : " " . __( 'year', EQUIPEER_ID );
			// -------------------------------------------
			if ($age > 1) {
				// + 1 an
				$age .= " " . __( 'years', EQUIPEER_ID );
			} elseif ($age == 1) {
				// 1 an
				$age .= " " . __( 'year', EQUIPEER_ID );
			} else {
				// 0 an
				$age = __( 'Foal', EQUIPEER_ID );
			}
		} else {
			$age = "--";
		}
		return $age;
	}
}

/**
 * Get all type horses
 *
 * @return array
 */
if (!function_exists("equipeer_get_all_type_horses")) {
	function equipeer_get_all_type_horses() {
		return [
			[ 'value' => 'horse', 'name' => __( 'Horse', EQUIPEER_ID ) ],
		    [ 'value' => 'pony',  'name' => __( 'Pony', EQUIPEER_ID ) ]
		];
	}
}

/**
 * Get all type ads
 *
 * @return array
 */
if (!function_exists("equipeer_get_all_type_ads")) {
	function equipeer_get_all_type_ads() {
		return [
			[ 'value' => '1', 'name' => __( 'Free', EQUIPEER_ID ) ],      // Gestion libre de l'annonce
		    [ 'value' => '2',  'name' => __( 'Appraised', EQUIPEER_ID ) ] // Gestion de l'annonce par EQUIPEER
		];
	}
}

/**
 * Get post meta value
 *
 * @param	$id	 		Post id
 * @param	$name 		Meta Name
 * @param	$default	Default value to return if no value
 *
 * @return string
 */
if (!function_exists("equipeer_get_post_meta")) {
	function equipeer_get_post_meta($id, $name, $default = "") {
		$post_meta = @get_post_meta( $id, $name, true );
		
		return ($post_meta) ? $post_meta : $default;
	}
}

/**
 * Get departement name (France)
 *
 * @param	$zip	Code postal
 *
 * @return string (Department name)
 */
if (!function_exists("equipeer_localisation_text")) {
	function equipeer_localisation_text($zip) {
		global $wpdb;
		$departement = $wpdb->get_var( $wpdb->prepare( "SELECT nom_departement FROM {$wpdb->prefix}departement_fr WHERE code = '%d'", $zip ) );
		
		return $departement;
	}
}

/**
 * Get All INFOS about Taxonomy
 *
 * Usage :
 * equipeer_get_terms('equipeer_discipline', array( 'equipeer_select_taxonomy_parent_id' ), 'horse')
 * equipeer_get_terms('equipeer_gender')
 * equipeer_get_terms('equipeer_age', array( 'equipeer_select_taxonomy_parent_id' ), 'pony', 'count', 'DESC', true)
 * equipeer_get_terms('equipeer_equestrian_level', '', '', 'none')
 * 
 * @return array
 */
if (!function_exists("equipeer_get_terms")) {
	function equipeer_get_terms($taxonomy, $meta_key = array(), $meta_value = '', $orderby = 'name', $order = 'ASC', $hide_empty = false) {
		// ----------------------------------
		global $sitepress;
		$original_lang = ICL_LANGUAGE_CODE; // Save the current language
		$new_lang = 'fr'; // The language in which you want to get the terms
		$sitepress->switch_lang($new_lang); // Switch to new language
		// ----------------------------------
		$equipeer_get_term = array();
		// ----------------------------------
		$args  = array(
			'taxonomy'               => $taxonomy,   // empty string(''), false, 0 don't work, and return empty array
			'orderby'                => $orderby,    // 'name','slug','term_group','term_id','id','description','parent','count','none' to omit the ORDER BY clause. Defaults to 'name'
			'order'                  => $order,
			'hide_empty'             => $hide_empty, // can be 1, '1' too
			'include'                => 'all', // empty string(''), false, 0 don't work, and return empty array
			'exclude'                => 'all', // empty string(''), false, 0 don't work, and return empty array
			'exclude_tree'           => 'all', // empty string(''), false, 0 don't work, and return empty array
			'number'                 => false, // can be 0, '0', '' too
			'offset'                 => '',
			'fields'                 => 'all',
			'name'                   => '',
			'slug'                   => '',
			'hierarchical'           => true, // can be 1, '1' too
			'search'                 => '',
			'name__like'             => '',
			'description__like'      => '',
			'pad_counts'             => false, // can be 0, '0', '' too
			'get'                    => '',
			'child_of'               => false, // can be 0, '0', '' too
			'childless'              => false,
			'cache_domain'           => 'core',
			'update_term_meta_cache' => true,  // can be 1, '1' too
			'meta_query'             => '',
			'meta_key'               => $meta_key,
			'meta_value'             => $meta_value,
			'lang' => 'fr'
		);
		$terms = get_terms( $args );
		// ---------------------------------------------
		if ($terms) {
			foreach( $terms as $key => $taxonomy ) {
				// -----------------------------------------------
				$equipeer_get_term[$key]['id']          = $taxonomy->term_id;          // int
				$equipeer_get_term[$key]['name']        = $taxonomy->name;             // string
				$equipeer_get_term[$key]['slug']        = $taxonomy->slug;             // string
				$equipeer_get_term[$key]['group']       = $taxonomy->term_group;       // int
				$equipeer_get_term[$key]['taxonomy_id'] = $taxonomy->term_taxonomy_id; // int
				$equipeer_get_term[$key]['taxonomy']    = $taxonomy->taxonomy;         // string
				$equipeer_get_term[$key]['description'] = $taxonomy->description;      // string
				$equipeer_get_term[$key]['parent']      = $taxonomy->parent;           // int
				$equipeer_get_term[$key]['count']       = $taxonomy->count;            // int
				$equipeer_get_term[$key]['filter']      = $taxonomy->filter;           // string
				$equipeer_get_term[$key]['meta']        = $taxonomy->meta;             // array
				// -----------------------------------------------
			}
		}
		// ---------------------------------------------
		// Roll back to current language            
		$sitepress->switch_lang($original_lang);
		// ---------------------------------------------
		return $equipeer_get_term;
		// ---------------------------------------------
	}
}

/**
 * Return Metas from equine post ID
 *
 * @param	$post_id	post ID
 * @param	$key 	 	meta type | meta name
 * @param 	$single		true | false - If true, returns only the first value for the specified meta key
 * 
 * @return string
 */
if (!function_exists("equipeer_get_metas")) {
	function equipeer_get_metas( $post_id, $key = '', $single = true ) {
		if ( !$post_id )
			return;
		
		switch($key) {
			case "H1":
			case "ALL":
				// All metas from post ID
				return get_post_meta( $post_id, '', false );
			break;
			default:
				// Specific meta from post ID
				return get_post_meta( $post_id, $key, $single );
			break;
		}
	}
}

/**
 * Get current full url
 *
 * @return string (full url)
 */
if (!function_exists("equipeer_current_url")) {
	function equipeer_current_url() {
		return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	}
}

/**
 * Get the pagination
 *
 * @param	$pages	Max number of pages
 * @param	$range	Show items
 *
 * Usage:
 * equipeer_pagination();
 * equipeer_pagination($pages = '', $range = 2)
 *
 * Css:
 * Style .pagination
 *
 * @return 	string	Pagination
 */
if (!function_exists("equipeer_pagination")) {
	function equipeer_pagination($pages = '', $range = 2, $type = false) {  
		global $paged;
		
		$showitems = ($range * 2)+1;  
   
		if (empty($paged)) $paged = 1;
   
		if($pages == '') {
			global $wp_query;
			$pages = $wp_query->max_num_pages;
			if(!$pages) {
				$pages = 1;
			}
		}   
	
		if (1 != $pages) {
			echo "<div class='pagination'>";
			
			if ($paged > 2 && $paged > $range+1 && $showitems < $pages)  {
			 	//echo "<a href='".get_pagenum_link(1)."'>&laquo;</a>";
				$link_1 = (!$type) ? get_pagenum_link(1) : equipeer_get_pagenum_link(1);
				echo '<a data-start="1" href="' . $link_1 . '">1</a>&nbsp;&nbsp;...&nbsp;&nbsp;';
			}
			//if($paged > 1 && $showitems < $pages) echo "<a href='".get_pagenum_link($paged - 1)."'>" . __("Prev", EQUIPEER_ID) . "</a>";
   
			for ($i=1; $i <= $pages; $i++) {
				if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems )) {
					$link_s = (!$type) ? get_pagenum_link($i) : equipeer_get_pagenum_link($i);
					echo ($paged == $i)? "<span class='current'>" . $i . "</span>":"<a href='" . $link_s . "' class='inactive' >" . $i . "</a>";
				}
			}
   
			//if ($paged < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($paged + 1)."'>" . __("Next", EQUIPEER_ID) . "</a>";
			if ($paged < $pages-1 &&  $paged+$range-0 < $pages && $showitems < $pages) {
				$link_l = (!$type) ? get_pagenum_link($pages) : equipeer_get_pagenum_link($pages);
				echo '&nbsp;&nbsp;...&nbsp;&nbsp;<a data-end="'.$pages.'" href="' . $link_l . '">' . $pages . '</a>';
				//echo "<a href='".get_pagenum_link($pages)."'>&raquo;</a>";
			}
			
			echo "</div>\n";
			
			// Next  /  Prev
			echo "<div class='pagination2'>";
			 
				// Previous
				if ($pages > 1) {
					if (!isset($_GET['page'])) {
						// Desactive
						echo "<a data-paged='".$paged."' data-items='".$showitems."' data-pages='".$pages."' href='#' data-type='prev' class='disabled'>&xlarr; " . __("Prev", EQUIPEER_ID) . "</a>";
					} else {
						// Actif
						$link_a = (!$type) ? get_pagenum_link($paged - 1) : equipeer_get_pagenum_link($paged - 1);
						echo "<a data-paged='".$paged."' data-items='".$showitems."' data-pages='".$pages."' data-type='prev' href='" . $link_a . "'>&xlarr; " . __("Prev", EQUIPEER_ID) . "</a>";
					}
				}
				
				// Next
				if ($pages > 5) {
					if ($paged < $pages && $showitems < $pages) {
						$link_b = (!$type) ? get_pagenum_link($paged + 1) : equipeer_get_pagenum_link($paged + 1);
						echo "<a data-type='next' href='" . $link_b . "'>" . __("Next", EQUIPEER_ID) . " &xrarr;</a>";
					} else {
						echo "<a data-paged='".$paged."' data-items='".$showitems."' data-pages='".$pages."' href='#' data-type='next' class='disabled'>" . __("Next", EQUIPEER_ID) . " &xrarr;</a>";
					}
				} else {
					if ($paged < $pages && $showitems > $pages) {
						$link_b = (!$type) ? get_pagenum_link($paged + 1) : equipeer_get_pagenum_link($paged + 1);
						echo "<a data-type='next' href='" . $link_b . "'>" . __("Next", EQUIPEER_ID) . " &xrarr;</a>";
					} else {
						echo "<a data-paged='".$paged."' data-items='".$showitems."' data-pages='".$pages."' href='#' data-type='next' class='disabled'>" . __("Next", EQUIPEER_ID) . " &xrarr;</a>";
					}
				}
			 
			echo "</div>\n";
		}
	}
}

/**
 * Custom WP pagenum link (Without using permalinks)
 *
 */
if (!function_exists("equipeer_get_pagenum_link")) {
	function equipeer_get_pagenum_link( $pagenum = 1, $escape = true ) {
		global $wp_rewrite;
	 
		$pagenum = (int) $pagenum;
	 
		$request = remove_query_arg( 'page' );
	 
		$home_root = parse_url( home_url() );
		$home_root = ( isset( $home_root['path'] ) ) ? $home_root['path'] : '';
		$home_root = preg_quote( $home_root, '|' );
	 
		$request = preg_replace( '|^' . $home_root . '|i', '', $request );
		$request = preg_replace( '|^/+|', '', $request );
	 
		$base = trailingslashit( get_bloginfo( 'url' ) );
 
		if ( $pagenum > 1 ) {
			$result = add_query_arg( 'page', $pagenum, $base . $request );
		} else {
			$result = $base . $request;
		}
	 
		/**
		 * Filters the page number link for the current request.
		 *
		 * @since 2.5.0
		 * @since 5.2.0 Added the `$pagenum` argument.
		 *
		 * @param string $result  The page number link.
		 * @param int    $pagenum The page number.
		 */
		//$result = apply_filters( 'get_pagenum_link', $result, $pagenum );
	 
		if ( $escape ) {
			return esc_url( $result );
		} else {
			return esc_url_raw( $result );
		}
	}
}

/**
 * Get Heading INFOS from horse
 *
 * @param	$post_id	POST ID
 * @param	$echo 		false | true - 0 = return string, 1 = echo string
 * @param	$separator	String separator
 *
 * @return string
 */
if (!function_exists("equipeer_head_text_horse")) {
	function equipeer_head_text_horse($post_id, $echo = false, $separator = ", ", $type = 'site') {
		// --------------------------------------------------
		$equine_value = equipeer_get_metas( $post_id, 'H1' );
		$equine_text  = "";
		// --------------------------------------------------
		switch($type) {
			default:
			case "site":
				// 1. Discipline
				if ($equine_value["discipline"][0]) {
					$equine_value_discipline = get_term_by( 'id', absint( $equine_value["discipline"][0] ), 'equipeer_discipline' );
					$equine_text .= $equine_value_discipline->name . ' : ';
				}
				// 2. Race
				if ($equine_value["breed"][0]) {
					$equine_value_breed = get_term_by( 'id', absint( $equine_value["breed"][0] ), 'equipeer_breed' );
					$equine_text .= $equine_value_breed->name . $separator;
				}
				// 3. Sexe
				if ($equine_value["sex"][0]) {
					$equine_value_sex = get_term_by( 'id', absint( $equine_value["sex"][0] ), 'equipeer_gender' );
					$equine_text .= $equine_value_sex->name . $separator;
				}
				// 4. Couleur
				if ($equine_value["dress"][0]) {
					$equine_value_dress = get_term_by( 'id', absint( $equine_value["dress"][0] ), 'equipeer_color' );
					$equine_text .= $equine_value_dress->name . $separator;
				}
				// 5. Taille (cm)
				if ($equine_value["size_cm"][0]) $equine_text .= $equine_value["size_cm"][0] . 'cm' . $separator;
				// 6. Age
				if ($equine_value["birthday"][0]) {
					$_years       = ( (intval( date('Y') - $equine_value["birthday"][0]) < 2 ) ) ? __( 'year', EQUIPEER_ID ) : __( 'years', EQUIPEER_ID );
					if (intval( date('Y') - $equine_value["birthday"][0] ) == 0)
						$equine_text .= 'Foal' . $separator;
					else
						$equine_text .= intval( date('Y') - $equine_value["birthday"][0] ) . ' ' . $_years . $separator;
				}
				// 7. Potentiel
				$equine_text .= __( 'Potential', EQUIPEER_ID ) . ' ';
				if ($equine_value["potentiel"][0]) {
					$equine_text .= get_term_by( 'id', absint( $equine_value["potentiel"][0] ), 'equipeer_potential' )->name;
				} else {
					$equine_text .= __( 'Unknown', EQUIPEER_ID );
				}
			break;
			case "feedfb":
				// 1. Sexe
				if ($equine_value["sex"][0]) {
					$equine_value_sex = get_term_by( 'id', absint( $equine_value["sex"][0] ), 'equipeer_gender' );
					$equine_text .= $equine_value_sex->name . $separator;
				}
				// 2. Couleur
				if ($equine_value["dress"][0]) {
					$equine_value_dress = get_term_by( 'id', absint( $equine_value["dress"][0] ), 'equipeer_color' );
					$equine_text .= $equine_value_dress->name . $separator;
				}
				// 3. Taille (cm)
				if ($equine_value["size_cm"][0]) $equine_text .= $equine_value["size_cm"][0] . 'cm' . $separator;
				// 4. Age
				if ($equine_value["birthday"][0]) $equine_text .= intval( date('Y') - $equine_value["birthday"][0] ) . ' ' .  __( 'years', 'wp-bootstrap-starter' ) . $separator;
				// 5. Discipline
				if ($equine_value["discipline"][0]) {
					$equine_value_discipline = get_term_by( 'id', absint( $equine_value["discipline"][0] ), 'equipeer_discipline' );
					$equine_text .= $equine_value_discipline->name . ' : ';
				}
				// 6. Potentiel
				$equine_text .= __( 'Potential', EQUIPEER_ID ) . ' ';
				if ($equine_value["potentiel"][0]) {
					$equine_text .= get_term_by( 'id', absint( $equine_value["potentiel"][0] ), 'equipeer_potential' )->name;
				} else {
					$equine_text .= __( 'Unknown', EQUIPEER_ID );
				}
			break;
			case "permalink":
				// 1. Race
				if ($equine_value["breed"][0]) {
					$equine_value_breed = get_term_by( 'id', absint( $equine_value["breed"][0] ), 'equipeer_breed' );
					$equine_text .= $equine_value_breed->name . $separator;
				}
				// 2. Sexe
				if ($equine_value["sex"][0]) {
					$equine_value_sex = get_term_by( 'id', absint( $equine_value["sex"][0] ), 'equipeer_gender' );
					$equine_text .= $equine_value_sex->name . $separator;
				}
				// 3. Couleur
				if ($equine_value["dress"][0]) {
					$equine_value_dress = get_term_by( 'id', absint( $equine_value["dress"][0] ), 'equipeer_color' );
					$equine_text .= $equine_value_dress->name . $separator;
				}
				// 3. Taille (cm)
				if ($equine_value["size_cm"][0]) $equine_text .= $equine_value["size_cm"][0] . 'cm' . $separator;
				// 4. Age
				if ($equine_value["birthday_real"][0]) { // Si date de naissance
					$equine_text .= substr( $equine_value["birthday_real"][0], 0, 10) . $separator;
				} elseif ($equine_value["birthday"][0]) { // Ou si année de naissance
					$equine_text .= $equine_value["birthday"][0] . $separator;
				}
				// 5. Discipline
				if ($equine_value["discipline"][0]) {
					$equine_value_discipline = get_term_by( 'id', absint( $equine_value["discipline"][0] ), 'equipeer_discipline' );
					$equine_text .= $equine_value_discipline->name . $separator;
				}
				// 6. Reference
				if ($equine_value["reference"][0] && $equine_value["discipline"][0]) {
					$get_the_prefix = get_term_meta( $equine_value["discipline"][0], 'equipeer_prefix_taxonomy_parent_id', true );
					$equine_text .= $get_the_prefix . equipeer_get_format_reference( $equine_value["reference"][0] );
				}
			break;
		}
				
		// Echo / Return string
		if ($echo)
			echo $equine_text;
		else
			return $equine_text;
	}
}

/**
 * Get Heading INFOS from horse
 *
 * @param	$post_id	POST ID
 * @param	$echo 		false | true - 0 = return string, 1 = echo string
 * @param	$separator	String separator
 *
 * @return string
 */
if (!function_exists("equipeer_head_text_horse_url")) {
	function equipeer_head_text_horse_url($post_id, $echo = false, $separator = ", ", $type = 'site') {
		// --------------------------------------------------
		$equine_value = equipeer_get_metas( $post_id, 'H1' );
		$equine_text  = "";
		// --------------------------------------------------
		// 1. Race
		if ($equine_value["breed"][0]) {
			$equine_value_breed = get_term_by( 'id', absint( $equine_value["breed"][0] ), 'equipeer_breed' );
			$equine_text .= eq_translate($equine_value_breed->name) . $separator;
		}
		// 2. Sexe
		if ($equine_value["sex"][0]) {
			$equine_value_sex = get_term_by( 'id', absint( $equine_value["sex"][0] ), 'equipeer_gender' );
			$equine_text .= eq_translate($equine_value_sex->name) . $separator;
		}
		// 3. Couleur
		if ($equine_value["dress"][0]) {
			$equine_value_dress = get_term_by( 'id', absint( $equine_value["dress"][0] ), 'equipeer_color' );
			$equine_text .= eq_translate($equine_value_dress->name) . $separator;
		}
		// 3. Taille (cm)
		if ($equine_value["size_cm"][0]) $equine_text .= $equine_value["size_cm"][0] . 'cm' . $separator;
		// 4. Age
		if ($equine_value["birthday_real"][0]) { // Si date de naissance
			$equine_text .= substr( $equine_value["birthday_real"][0], 0, 10) . $separator;
		} elseif ($equine_value["birthday"][0]) { // Ou si année de naissance
			$equine_text .= $equine_value["birthday"][0] . $separator;
		}
		// 5. Discipline
		if ($equine_value["discipline"][0]) {
			$equine_value_discipline = get_term_by( 'id', absint( $equine_value["discipline"][0] ), 'equipeer_discipline' );
			$equine_text .= eq_translate($equine_value_discipline->name) . $separator;
		}
		// 6. Reference
		if ($equine_value["reference"][0] && $equine_value["discipline"][0]) {
			$get_the_prefix = get_term_meta( $equine_value["discipline"][0], 'equipeer_prefix_taxonomy_parent_id', true );
			$equine_text .= $get_the_prefix . equipeer_get_format_reference( $equine_value["reference"][0] );
		}
				
		// Echo / Return string
		if ($echo)
			echo $equine_text;
		else
			return $equine_text;
	}
}

/**
 * Return HTML SELECT for score
 *
 * @return html
 */
if (!function_exists("equipeer_get_score_select")) {
	function equipeer_get_score_select( $select_name, $start = 0, $end = 10 ) {
		// Initialize
		$select_value = Equipeer_Metabox::get_meta_value( $select_name );
		// Construct HTML SELECT
		$select  = '';
		$select .= '<select name="' . $select_name . '" id="' . $select_name . '">';
		$select .= '<option value="">' . __( '&mdash; Select &mdash;', EQUIPEER_ID ) . '</option>';
		for($i = $start; $i <= $end; ++$i) {
			$select .= '<option value="'.$i.'"';
			$select .= ($select_value == $i) ? ' selected="selected"' : '';
			$select .= '>';
			$select .= $i;
			$select .= '</option>';
		}
		$select .= '</select>';
		return $select;
	}
}

/**
 * Get counter search when updated (or not)
 *
 * @return counter
 */
function equipeer_get_search_counter() {
	//global $wpdb;
	// ----------------------------------
	// Initialize meta query			
	$meta_query_arg   = array();
	$meta_query_arg[] = array( 'key' => 'sold', 'value' => '0', 'compare' => '=' );
	// ----------------------------------
	$args = array(
		 'post_type'      => 'equine'
		,'post_status'    => array( 'publish' )
		,'cache_results'  => true
		,'orderby'        => 'date'
		,'order'          => 'DESC'
		,'perm'           => 'readable' // Beware of setting the 'post_status' to anything other than 'public', as it can easily lead to an information disclosure vulnerability
		,'nopaging'       => true      // Display all posts by disabling pagination
		,'meta_query'     => array(
			$meta_query_arg
		)
	);
	// ----------------------------------
	// --- REQUEST with ARGS
	// ----------------------------------
	$query   = new WP_Query( $args );
	$count_total  = $query->found_posts;
	$last_query   = $query->last_query;
	$last_request = $query->request;
	// ----------------------------------
	return $count_total;
}

/**
 * Format Reference after prefix
 * 
 * @return int on X positions
 */
function equipeer_get_format_reference( $ref, $pos = 4 ) {
	# Return formatted Reference
	return str_pad($ref, $pos, '0', STR_PAD_LEFT);
}

/**
 * Get Prefixes from horse disciplines (OBSOLETE)
 *
 * @param   $id     Discipine ID
 *
 * @return string
 */
if (!function_exists("equipeer_get_horse_prefix")) {
	function equipeer_get_horse_prefix( $id = false ) {
		switch($id) {
			case 28:
				// CSO (discipline_horse_prefix_28)
				return "SO";
			break;
			case 30:
				// DRESSAGE (discipline_horse_prefix_30)
				return "DR";
			break;
			case 31:
				// CCE (discipline_horse_prefix_31)
				return "CE";
			break;
			case 32:
				// ENDURANCE (discipline_horse_prefix_32)
				return "EN";
			break;
			case 33:
				// HUNTER (discipline_horse_prefix_33)
				return "HU";
			break;
			case 34:
				// WESTERN (discipline_horse_prefix_34)
				return "WE";
			break;
			case 35:
				// AUTRES (discipline_horse_prefix_35)
				return "AU";
			break;
			default: return; break;
		}
	}
}

/**
 * Get Range Price for a horse (Tranche de prix)
 *
 * @param 	$price		Real price (ex: 60000)
 * @param	thousands	Display only thousands or number format price (true | false)
 *
 * @return string (Range price)
 */
if (!function_exists("equipeer_get_price")) {
	function equipeer_get_price($price, $thousands = true) {
		// Get range prices
		$range_start       = number_format( get_option( 'equine_range_start' ), 0, "", " " );
		$range_start_raw   = intval( get_option( 'equine_range_start' ) );
		list($range_start_first, $range_start_second) = explode(" ", $range_start);
		// ------------------------
		$range_1_until     = number_format( get_option( 'equine_range_1_until' ), 0, "", " " );
		$range_1_until_raw = intval( get_option( 'equine_range_1_until' ) );
		list($range_1_until_first, $range_1_until_second) = explode(" ", $range_1_until);
		// ------------------------
		$range_2_until     = number_format( get_option( 'equine_range_2_until' ), 0, "", " " );
		$range_2_until_raw = intval( get_option( 'equine_range_2_until' ) );
		list($range_2_until_first, $range_2_until_second) = explode(" ", $range_2_until);
		// ------------------------
		$range_3_until     = number_format( get_option( 'equine_range_3_until' ), 0, "", " " );
		$range_3_until_raw = intval( get_option( 'equine_range_3_until' ) );
		list($range_3_until_first, $range_3_until_second) = explode(" ", $range_3_until);
		// ------------------------
		$range_4_until     = number_format( get_option( 'equine_range_4_until' ), 0, "", " " );
		$range_4_until_raw = intval( get_option( 'equine_range_4_until' ) );
		list($range_4_until_first, $range_4_until_second) = explode(" ", $range_4_until);
		// Initialize
		$show_range      = "";
		// Text range prices
		$price_range_1 = (($thousands) ? $range_start_first : $range_start . '&euro;') . ' &agrave; ' . $range_1_until . '&euro;'; 
		$price_range_2 = (($thousands) ? $range_1_until_first : $range_1_until . '&euro;') . ' &agrave; ' . $range_2_until . '&euro;'; 
		$price_range_3 = (($thousands) ? $range_2_until_first : $range_2_until . '&euro;') . ' &agrave; ' . $range_3_until . '&euro;';
		$price_range_4 = (($thousands) ? $range_3_until_first : $range_3_until . '&euro;') . ' &agrave; ' . $range_4_until . '&euro;';
		$price_range_5 = '> ' . $range_4_until . '&euro;';
		if ( $price <= $range_1_until_raw ) {
			$show_range = $price_range_1;
		} else if ( $price <= $range_2_until_raw ) {
			$show_range = $price_range_2;
		} else if ( $price <= $range_3_until_raw ) {
			$show_range = $price_range_3;
		} else if ( $price <= $range_4_until_raw ) {
			$show_range = $price_range_4;
		} else {
			$show_range = $price_range_5;
		}
		return $show_range;
	}
}

/**
 * Get localisation detail
 *
 * @param 	$post_id	POST ID
 *
 * @return string / HTML
 */
if (!function_exists("equipeer_get_localisation_detail")) {
	function equipeer_get_localisation_detail($post_id, $strong = true) {
		// Initialisation
		$return_localisation = "";
		// Process
		$country = equipeer_get_post_meta($post_id, 'localisation_country', 'France');
		$zip     = ($country != '' && strtolower($country) == 'france') ? substr( equipeer_get_post_meta($post_id, 'localisation_zip', '00'), 0, 2) : equipeer_get_post_meta($post_id, 'localisation_zip', '00');
		if (strtolower($country) == 'france') {
		   $return_localisation .= equipeer_localisation_text( $zip ) . " ($zip)";
		} else {
		   $return_localisation .= "($zip)";
		}
		if ($country != '') {
			$return_localisation .= ($strong) ? '&nbsp;-&nbsp;<strong>' . ucfirst( strtolower($country) ) . '</strong>' : '&nbsp;-&nbsp;' . ucfirst( strtolower($country) );
		}
		
		return $return_localisation;
	}
}

/**
 * Get Selection
 *
 * @param	$post_id	POST ID
 * @param	$user_id	USER ID
 * @param	$limit		Limit to return - Default: 3
 * @param	$selection	Selection (Add or Del function or ARRAY) - Default: false - true | false
 * @param	$menu		Display in head menu - Default: false - true | false
 *
 * @return string / HTML / Array
 */
if (!function_exists("equipeer_get_selection")) {
	function equipeer_get_selection($post_id, $user_id, $limit = 3, $selection = false, $menu = false) {
		global $wpdb;
		$table_selection = Equipeer()->tbl_equipeer_selection_sport;
		$post_id         = intval($post_id);
		$user_id         = intval($user_id);
		$limit           = intval($limit);

		if ($selection) {
			$all_selection = $wpdb->get_results( "SELECT * FROM $table_selection WHERE uid = '$user_id' ORDER BY id DESC LIMIT $limit" );
			if (!$menu) {
				return $all_selection;
			} else {
				if ($all_selection) {
					$html = '<div class="container">';
					foreach($all_selection as $selection) {
						$the_prefix    = @get_term_meta( get_post_meta( $selection->pid, 'discipline', true ), 'equipeer_prefix_taxonomy_parent_id', true );
						$the_reference = @get_post_meta( $selection->pid, 'reference', true );
						$photo_id      = @get_post_meta( $selection->pid, 'photo_1', true );
						$thumbnail_src = ($photo_id) ? wp_get_attachment_image_src( $photo_id, array("50",  "40") ) : false;
						if ($thumbnail_src) {
							$thumbnail = wp_get_attachment_image( $photo_id, array("50", "40"), "", array( "class" => "masthead-selection-img", "alt" => "" ) );
						} else {
							$thumbnail = '<img class="masthead-selection-img" src="' . get_stylesheet_directory_uri() . '/assets/images/70x50.jpg" alt="">';
						}
						$html .= '<div class="row border mb-1">';
							$html .= '<div class="col">';
								$html .= $thumbnail;
							$html .= '</div>';
							$html .= '<div class="col masthead-selection-txt">';
								$html .= '<a href="' . get_permalink( $selection->pid ) . '">';
								$html .= 'Ref: ' . $the_prefix . '-' . equipeer_get_format_reference( $the_reference );
								$html .= '<br>';
								$html .= equipeer_head_text_horse( $selection->pid );
								$html .= '</a>';
							$html .= '</div>';
						$html .= '</div>'; // End ./row
					}
					$html .= '</div>'; // End ./container
					return $html;
				} else {
					$html  = "";
					$html .= '<small class="muted-text">' . __( "You don't have selection", EQUIPEER_ID ) . '</small>';
					$html .= '<form role="search" method="get" class="search-form" action="" target="_self">';
						$html .= '<input type="hidden" name="lang" value="fr">';
						$html .= '<div class="form-group input-group">';
							$html .= '<div class="input-group-prepend">';
								$html .= '<span class="input-group-text"> <i class="fas fa-search"></i> </span>';
							$html .= '</div>';
							$html .= '<input type="search" class="search-field form-control leftmenu" placeholder="' . __( 'Search', EQUIPEER_ID ) . '..." value="" name="s" title="' . __( 'Search', EQUIPEER_ID ) . '">';
						$html .= '</div> <!-- form-group// -->';
					$html .= '</form>';
					return $html;
				}

			}
		} else {
			$is_selection = $wpdb->get_row( "SELECT * FROM $table_selection WHERE uid = '$user_id' AND pid = '$post_id'" );
			return ($is_selection) ? 'del' : 'add';
		}
	}
}

/**
 * User Admin tracking - SPY
 *
 * @param	$user_action	Type of action (ex: moderate, print, ...)
 * @param	$description 	Description de l'action
 * ------------------------------------------------------
 * USAGE:
 * equipeer_activity_log($user_action, $description = '')
 * 
 * Ex: equipeer_activity_log('Moderate reject', 'Moderation : Refus de INFANT DU BOSSIS_2 - REF: 426')
 * ------------------------------------------------------
 * return void
 */
if (!function_exists("equipeer_activity_log")) {
	function equipeer_activity_log($user_action, $description = '') {
		global $wpdb;
		// Initialize
		$table = $wpdb->prefix . 'eqactivity_log';
		// Get real IP
		$user_ip = equipeer_get_real_user_ip( equipeer_get_user_ip() );
		// Current user
		$current_user = wp_get_current_user();
		// Check except
		//if (strtolower($user_action) == 'connexion' && !$current_user->ID) return;
		$user_name    = ucfirst(strtolower($current_user->user_firstname)) . ' ' . strtoupper($current_user->user_lastname) . " (User ID: $current_user->ID)";
		// Insert new record
		$wpdb->insert( $table,
			array( 'user_ip' => $user_ip, 'user_name' => $user_name, 'user_action' => $user_action, 'description' => $description),
			array( '%s', '%s', '%s', '%s' ) 
		);
	}
}

/**
 * Get Selection
 *
 * @param	$post_id	POST ID
 * @param	$user_id	USER ID
 * @param	$limit		Limit to return - Default: 3
 * @param	$selection	Selection (Add or Del function) - Default: false - true | false
 *
 * @return string
 */
if (!function_exists("equipeer_count_selection")) {
	function equipeer_count_selection($user_id) {
		global $wpdb;
		$user_id         = intval($user_id);
		$table_selection = Equipeer()->tbl_equipeer_selection_sport;

		$count_selection = $wpdb->get_var( "SELECT COUNT(*) FROM $table_selection WHERE uid = '$user_id'" );
		return (isset($count_selection) && $count_selection > 0) ? $count_selection : 0;
	}
}

/**
 * Calculates the distance between two points, given their 
 * latitude and longitude, and returns an array of values 
 * of the most common distance units
 *
 * MYSQL : https://tighten.co/blog/a-mysql-distance-function-you-should-know-about/
 *
 * @param  {coord} $lat1 Latitude of the first point
 * @param  {coord} $lon1 Longitude of the first point
 * @param  {coord} $lat2 Latitude of the second point
 * @param  {coord} $lon2 Longitude of the second point
 * @return {array}       Array of values in many distance units
 */
if (!function_exists("equipeer_get_distance_between_points")) {
	function equipeer_get_distance_between_points($lat1, $lon1, $lat2, $lon2) {
		$theta      = $lon1 - $lon2;
		$miles      = (sin(deg2rad($lat1)) * sin(deg2rad($lat2))) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
		$miles      = acos($miles);
		$miles      = rad2deg($miles);
		$miles      = $miles * 60 * 1.1515;
		$feet       = $miles * 5280;
		$yards      = $feet / 3;
		$kilometers = $miles * 1.609344;
		$meters     = $kilometers * 1000;
		
		return (object) [
			 'miles'      => $miles
			,'feet'       => $feet
			,'yards'      => $yards
			,'kilometers' => $kilometers
			,'meters'     => $meters
		];
	}
}

/**
 * Return Video Type Mime INV
 *
 * @param	$type	Type mime
 *
 * @return	string
 */
if (!function_exists("equipeer_show_type_mime_video_inv")) {
	function equipeer_show_type_mime_video_inv( $type ) {
		switch ( strtolower( $type ) ) {
			// ------------------
			// Type video
			case 'video/mpeg':		return 'mpg';
			case 'video/mp4':		return 'mp4';
			case 'video/quicktime':	return 'mov';
			case 'video/x-ms-wmv':	return 'wmv';
			case 'video/x-msvideo':	return 'avi';
			case 'video/x-flv':		return 'flv';
	
			default: return false;
		}
	}
}

/**
 * Return Video Type Mime
 *
 * @param	$type	file extension
 *
 * @return	string
 */
if (!function_exists("equipeer_show_type_mime_video")) {
	function equipeer_show_type_mime_video( $extension ) {
		switch ( strtolower( $extension ) ) {
			// ------------------
			// Type video
			case "mpg": case "mpeg": return 'video/mpeg';
			case "mp4": return 'video/mp4';
			case "mov": return 'video/quicktime';
			case "wmv": return 'video/x-ms-wmv';
			case "avi": return 'video/x-msvideo';
			case "flv": return 'video/x-flv';
	
			default: return false;
		}
	}
}

/**
 * Return File size human readable
 *
 * @param	$size	File size in octets
 *
 * @return	string
 */
if (!function_exists("equipeer_file_size")) {
	function equipeer_file_size($size) {
		if ($size >= 1073741824)
			$size = round($size / 1073741824 * 100) / 100 . " Go";
		elseif ($size >= 1048576)
			$size = round($size / 1048576 * 100) / 100 . " Mo";
		elseif ($size >= 1024)
			$size = round($size / 1024 * 100) / 100 . " KO";
		else
			$size = $size . " bytes";
		return $size;
	}
}

/**
 * Return Video Type Mime
 *
 * @param	$type	Type mime
 *
 * @return	string
 */
if (!function_exists("equipeer_file_extension")) {
	function equipeer_file_extension( $filename ) {
		$extension = explode( '.', $filename );
		$extension = array_reverse( $extension );
		$extension = $extension[0];
	
		return $extension;
	}
}

/**
 * Return HTML VIDEO
 *
 * @return html
 */
if (!function_exists("equipeer_selected_video")) {
	function equipeer_selected_video( $video_type = 'youtube', $video_url = false, $video_id = false, $width = false, $height = false ) {
		// Initialize
		$_width  = ($width) ? $width : '225';
		$_height = ($height) ? $height : '169';
		$return  = '';
		switch( strtolower($video_type) ) {
			case "youtube":
				if ( $video_url ) {
					// $video_url : https://www.youtube.com/embed/_pVCS8HbrmI
					// $video_id : _pVCS8HbrmI
					$return .= '<iframe class="youtube-video" width="'.$_width.'" height="'.$_height.'" src="' . $video_url . '?enablejsapi=1" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
				} else {
					//$return .= '<strong>' . __( "Can't load this video", EQUIPEER_ID ) . '</strong>';
				}
			break;
			case "vimeo":
				if ( $video_id ) {
					// $video_url: https://vimeo.com/265045525
					// $video_id : 265045525
					//$return .= '<iframe class="vimeo-video" src="https://player.vimeo.com/video/265045525?byline=0" width="'.$_width.'" height="'.$_height.'" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>';
					$return .= '<iframe class="vimeo-video" src="' . $video_url . '" width="'.$_width.'" height="'.$_height.'" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>';
				} else {
					//$return .= '<strong>' . __( "Can't load this video", EQUIPEER_ID ) . '</strong>';
				}
			break;
			default:
				if ( $video_url ) {
					// $video_url: http://techslides.com/demos/sample-videos/small.mp4
					// $video_id : -
					$video_extension = equipeer_file_extension( basename($video_url) );
					$video_type_mime = equipeer_show_type_mime_video( $video_extension );
					$return .= '<video class="html5-video" width="'.$_width.'" height="'.$_height.'" controls><source src="' . $video_url . '" type="' . $video_type_mime . '">' . __( 'Your browser does not support the video tag', EQUIPEER_ID ) . '</video> ';
				} else {
					//$return .= '<strong>' . __( "Can't load this video", EQUIPEER_ID ) . '</strong>';
				}
			break;
		}
		return $return;
	}
}

/**
 * Used to determine what kind of url is being submitted here
 * 
 * @param	string	$url	either a YouTube or Vimeo URL string
 *
 * @return array will return either "youtube","vimeo" or "file" and also the video id from the url
 */
if (!function_exists("equipeer_video_is")) {
	function equipeer_video_is($url) {	
		$yt_rx = '/^((?:https?:)?\/\/)?((?:www|m)\.)?((?:youtube\.com|youtu.be))(\/(?:[\w\-]+\?v=|embed\/|v\/)?)([\w\-]+)(\S+)?$/';
		$has_match_youtube = preg_match($yt_rx, $url, $yt_matches);

		$vm_rx = '/(https?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*([‌​0-9]{6,11})[?]?.*/';
		$has_match_vimeo = preg_match($vm_rx, $url, $vm_matches);
	
		// Then we want the video id which is:
		if ($has_match_youtube) {
			$video_id = $yt_matches[5]; 
			$type     = 'youtube';
		} elseif ($has_match_vimeo) {
			$video_id = $vm_matches[5];
			$type     = 'vimeo';
		} else {
			$video_id = 0;
			$type     = 'file';
		}

		$data['video_id']   = $video_id;
		$data['video_type'] = $type;
	
		return $data;
	}
}

/**
 * Get Video Thumbnail
 *
 * @param	$type	Video type
 *
 * @return string	Thumbnail URL
 */
if (!function_exists("equipeer_video_thumbnail")) {
	function equipeer_video_thumbnail($type, $video_id) {
		switch($type) {
			case "youtube":
				return "https://i3.ytimg.com/vi/$video_id/hqdefault.jpg";
			break;
			case "vimeo":
				$data = file_get_contents("http://vimeo.com/api/v2/video/$video_id.json");
				$data = json_decode($data);
				return $data[0]->thumbnail_medium;
			break;
			default:
			case "file":
				return get_stylesheet_directory_uri() . "/assets/images/video-thumbnail-133.jpg";
			break;
		}
	}
}

/**
 * Get actual SWAL INFO for user not connected
 *
 * @return array | false
 */
if (!function_exists("equipeer_splash_user")) {
	function equipeer_splash_user() {
		global $wpdb;
		$eqsplashuser_session_tbl = $wpdb->prefix . 'eqsplashscreen_session';

		// Initialize
		$splash_user_language = (ICL_LANGUAGE_CODE == 'fr') ? ICL_LANGUAGE_CODE : 'en';
		$splash_user_delay    = get_option('equine_user_not_logged_in_delay');
		$splash_user_repeat   = get_option('equine_user_not_logged_in_repeat');
		$splash_user_title    = get_option("equine_user_not_logged_in_title_$splash_user_language");
		$splash_user_text     = get_option("equine_user_not_logged_in_text_$splash_user_language");
		$time_plus_one_day    = strtotime('+ 1day');
		
		// TEST Mode
		$test_mode = false;
		
		if (!$test_mode) {
			// Check if splash user is activated
			$check_splash_user_active = get_option('equine_user_not_logged_in_active');
			if ($check_splash_user_active == '1') {
				// --- Splash user is ACTIVATED
				// Get real IP
				$user_ip = equipeer_get_real_user_ip( equipeer_get_user_ip() );
				// Check if USER is in DB
				$check_session = $wpdb->get_row( "SELECT * FROM $eqsplashuser_session_tbl WHERE ip = '$user_ip'" );
				
				if ($check_session) {
					$user_repeat     = $check_session->user_repeat;
					$splash_id       = $check_session->id;
					$user_expiration = $check_session->time;
					$current_time    = time();
					// Check if user repeat is exceeded
					if ( $user_repeat < $splash_user_repeat ) {
						$user_repeat++;
						$wpdb->update( $eqsplashuser_session_tbl,
									  array( 'user_repeat' => $user_repeat ),
									  array( 'id'  => $splash_id ),
									  array( '%d' ),
									  array( '%d' )
						);
					} elseif ( $current_time < $user_expiration ) { // Check if time is expired
						// Time is NOT expired
						return false;
					} else {
						// Time is expired
						$id = $check_session->id;
						$wpdb->delete( $eqsplashuser_session_tbl, array( 'ID' => $id ), array( '%d' ) );
						// Insert new record
						$wpdb->insert( $eqsplashuser_session_tbl,
							array( 'ip' => $user_ip, 'time' => $time_plus_one_day), 
							array( '%s', '%d' ) 
						);
					}
				} else {
					// Insert Data in DB
					$wpdb->insert( $eqsplashuser_session_tbl,
						array( 'ip' => $user_ip, 'time' => $time_plus_one_day), 
						array( '%s', '%d' ) 
					);
				}
			} else {
				// Splash user is not ACTIVATED
				return false;
			}
		}
		
		// Return array
		return [
			'title'   => $splash_user_title,
			'text'    => $splash_user_text,
			'delay'   => $splash_user_delay,
		];
	}
}

/**
 * Upload TMP files after submit an AD
 *
 * @param	$file 				Path of the file to insert in media library
 * @param 	$filename			New name of the file
 * @param	$parent_post_id		Post parent ID (attachment)
 *
 * return bool | integer (Attachment ID)
 */
if (!function_exists("equipeer_insert_attachment")) {
	function equipeer_insert_attachment($file, $filename, $parent_post_id) {
		$upload_file = wp_upload_bits($filename, null, file_get_contents($file));
		if (!$upload_file['error']) {
			$wp_filetype = wp_check_filetype($filename, null );
			$attachment  = array(
				'post_mime_type' => $wp_filetype['type'],
				'post_parent'    => $parent_post_id,
				'post_title'     => sanitize_file_name( $filename ),
				'post_content'   => '',
				'post_status'    => 'inherit'
			);
			$attachment_id = wp_insert_attachment( $attachment, $upload_file['file'], $parent_post_id );
			if (!is_wp_error($attachment_id)) {
				require_once(ABSPATH . "wp-admin" . '/includes/image.php');
				$attachment_data = wp_generate_attachment_metadata( $attachment_id, $upload_file['file'] );
				wp_update_attachment_metadata( $attachment_id,  $attachment_data );
				// return Attachment ID
				return $attachment_id;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
}

/**
 * Return EMBED Youtube URL
 *
 * @param	$url 	Url to check and transform if necessary
 * MDR
 */
if (!function_exists("equipeer_check_youtube_url")) {
	function equipeer_check_youtube_url($url) {
		// --------------------------------------
		// Check if youtube video
		$ytstring  = $url;
		// --------------------------------------
		$ytfindme  = 'youtube';
		$ytpos     = strpos($ytstring, $ytfindme);
		// --------------------------------------
		$ytfindme2 = 'youtu.be';
		$ytpos2    = strpos($ytstring, $ytfindme2);
		// --------------------------------------
		// Search strings
		if ($ytpos !== false || $ytpos2 !== false) {
			// Initialisation
			$url_new  = "";
			// -------------------------------
			// If url with "watch" string
			// -------------------------------
			if ($ytpos !== false) {
				// Initialize
				$mystring = $ytstring;
				// Check if url is already embed
				if (strpos($mystring, 'embed')) {
					return $url;
				}
				// Find me "watch" string
				$findme   = 'watch';
				$pos      = strpos($mystring, $findme);
				// Chaine trouvee
				list($first, $second) = explode('?', $mystring);
				// Search if multiple parameters
				$mystring2 = $second;
				$findme2   = '&';
				$pos2      = strpos($mystring2, $findme2);
				// Check				
				if ($pos2 === false) {
					// Ne se trouve pas dans la chaine SECOND
					list($var, $value) = explode('=', $mystring2);
					$url_new = "https://www.youtube.com/embed/".$value;
				} else {
					// & a ete trouve dans la chaine SECOND
					list($string1, $string2) = explode('&', $mystring2);
					list($var2, $value2) = explode('=', $string1);
					$url_new = "https://www.youtube.com/embed/".$value2;
				}
				
				return $url_new;
			}
			// -------------------------------
			// If url with "youtu.be" string
			// -------------------------------
			if ($ytpos2 !== false) {
				// Initialize
				$mystring = $ytstring;
				// Chaine trouvee
				list($first, $second) = explode('youtu.be/', $mystring);
				// Url new
				$url_new = "https://www.youtube.com/embed/".rtrim($second, "/");
				
				return $url_new;
			}
			// -------------------------------
			// If not, return url
			// -------------------------------
			return $url;
		
		} else {
			// Pas une video youtube
			return $url;
		}
	}
}

/**
 * Return translated text using Google Translate API
 *
 * @param	$text		Text to translate
 * @param 	$target		Target Language (fr, en, ...)
 * @param	$source		Source Language (en, fr, ...)
 *
 * @return string
 */
if (!function_exists("equipeer_translate")) {
	function equipeer_translate($text, $target, $source = false) {
		// initialize
		$api_key = trim( get_option('equine_google_translate_api_key') );
		$text_translated = $source_language_translated = "";
		// Construct URL
		$url  = 'https://www.googleapis.com/language/translate/v2?key=' . $api_key . '&q=' . rawurlencode($text);
		$url .= '&target='.$target;
		if ($source) $url .= '&source='.$source;
		// Call API
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);                 
		curl_close($ch);
		// true converts stdClass to associative array
		$obj = json_decode($response, true);
		// Check return
        if ($obj != null) {
            if (isset($obj['error'])) {
                $text_translated = "Error is : ".$obj['error']['message'];
            } else {
                $text_translated = $obj['data']['translations'][0]['translatedText'];
                // This is set if only source is not available.
                if (isset($obj['data']['translations'][0]['detectedSourceLanguage']))
                    $source_language_translated = "Detected Source Language : ".$obj['data']['translations'][0]['detectedSourceLanguage']."\n";     
            }
        } else {
            $text_translated = "UNKNOW ERROR";
        }
		// Return result
		return ['translated' => $text_translated, 'source' => $source_language_translated ];
	}
}

/**
 * Get all saved searches
 *
 * @return array
 */
if (!function_exists("equipeer_searches")) {
	function equipeer_searches() {
		global $wpdb;
		$table = $wpdb->prefix . 'eqsearch_save';
		$uid   = get_current_user_id();
		
		$query  = "SELECT * FROM $table WHERE uid = '$uid' ORDER BY date DESC";
		$result = $wpdb->get_results( $query );

		return $result;		
	}
}

/**
 * Get all user ads (Moderate, publish)
 *
 * @return array
 */
if (!function_exists("equipeer_get_user_ads")) {
	function equipeer_get_user_ads($uid) {
		//global $wpdb;
		$author_obj = get_user_by('id', $uid);
		// ----------------------------------			
		$post_status = 'moderate'; // array( 'publish', 'moderate' )
		// ----------------------------------
		$args = array(
			 'post_type'      => 'equine'
			,'post_status'    => $post_status
			//,'author'         => $uid
			,'orderby'        => 'date'
			,'order'          => 'DESC'
			,'meta_key'       => 'owner_email'
			,'meta_value'     => $author_obj->user_email
			,'meta_compare'   => '='
		);
		// ----------------------------------
		// --- REQUEST with ARGS
		// ----------------------------------
		$query        = new WP_Query( $args );
		$count_total  = $query->found_posts;
		$last_query   = $query->last_query;
		$last_request = $query->request;
		// ----------------------------------
		return [
			 'result'  => $query
			,'total'   => $count_total
			,'query'   => $last_query
			,'request' => $last_request
			,'author'  => $uid
			,'email'   => $author_obj->user_email
		];
	}
}

/**
 * Get all saved searches
 *
 * @return array
 */
if (!function_exists("equipeer_my_selection")) {
	function equipeer_my_selection() {
		global $wpdb;
		$table = $wpdb->prefix . 'equipeer_selection_sport';
		$uid   = get_current_user_id();
		
		$query  = "SELECT * FROM $table WHERE uid = '$uid' ORDER BY id DESC";
		$result = $wpdb->get_results( $query );

		return $result;		
	}
}

/** Get all Selections sent
 *
 * @return array
 */
if (!function_exists("equipeer_selections_sent")) {
	function equipeer_selections_sent() {
		global $wpdb;
		$table = $wpdb->prefix . 'equipeer_selections_sent';
		$uid   = get_current_user_id();
		
		$query  = "SELECT * FROM $table WHERE uid = '$uid' ORDER BY date DESC";
		$result = $wpdb->get_results( $query );

		return $result;	
	}
}

/** Get all Client documents
 *
 * @return array
 */
if (!function_exists("equipeer_client_documents")) {
	function equipeer_client_documents() {
		global $wpdb;
		$table = $wpdb->prefix . 'equipeer_pdf_client';
		$uid   = get_current_user_id();
		
		$query  = "SELECT * FROM $table WHERE uid = '$uid' AND active = '1' ORDER BY date DESC";
		$result = $wpdb->get_results( $query );

		return $result;	
	}
}

/**
 * Get all saved searches
 *
 * @return array
 */
if (!function_exists("equipeer_get_my_selection")) {
	function equipeer_get_my_selection() {
		global $wpdb;
		$table = $wpdb->prefix . 'equipeer_selection_sport';
		$uid   = get_current_user_id();
		
		$query  = "SELECT * FROM $table WHERE uid = '$uid' ORDER BY id DESC";
		$result = $wpdb->get_results( $query );

		if ($result) {
			
			$selections = "";
			foreach($result as $selection) {
				$the_prefix    = @get_term_meta( get_post_meta( $selection->pid, 'discipline', true ), 'equipeer_prefix_taxonomy_parent_id', true );
				$the_reference = equipeer_get_format_reference( @get_post_meta( $selection->pid, 'reference', true ) );
				$selections   .= $the_prefix . '-' . $the_reference . ",";
			}
			return rtrim( $selections, ",");
			
		} else {
			return "--";
		}
	}
}

/**
 * Get my selection with images
 *
 * @return HTML
 */
if (!function_exists("equipeer_get_my_selection_email")) {
	function equipeer_get_my_selection_email($ids) {
		// --- Get all selections from this user
		//$_all_selections = equipeer_my_selection();
		$_all_selections = explode(",", $ids);
		// --- Loop all IDS
		if ($_all_selections) {
			$selections = "";
			foreach($_all_selections as $selection) {
				// Check if horse is solded
				if (@get_post_meta( $selection, 'sold', true ) == 1) continue;
				// Get horses
				$the_prefix    = @get_term_meta( @get_post_meta( $selection, 'discipline', true ), 'equipeer_prefix_taxonomy_parent_id', true );
				$the_reference = equipeer_get_format_reference( @get_post_meta( $selection, 'reference', true ) );
				$photo_id      = @get_post_meta( $selection, 'photo_1', true );
				$photo_src     = ($photo_id) ? wp_get_attachment_url( $photo_id ) : get_stylesheet_directory_uri() . '/assets/images/equipeer-no-photo-thumb.jpg';
				$selections   .= '<div style="border: 1px solid #d1023e; float: left; margin: 0 5px 5px 0; width: 160px; height: 210px;"><a href="' . get_permalink( $selection ) . '"><img style="object-fit: cover; height: 160px; width: 100%;" src="' . $photo_src . '" alt="' . $the_prefix . '-' . $the_reference . '" /></a><p style="text-align: center; color: #0e2d4c;">' . $the_prefix . '-' . $the_reference . '</p></div>';
			}
			$selections .= '<div style="clear: both;">&nbsp;</div>';
			return $selections;
		} else {
			return "--";
		}
	}
}

/**
 * Send my selection to admins
 *
 * @param 	$refs	All references from client
 *
 * @return bool
 */
if (!function_exists("equipeer_send_my_selection")) {
	function equipeer_send_my_selection($refs, $uid) {
		// -----------------------------
		// Initialization
		// -----------------------------
		$user_info      = get_userdata($uid);
		$client_name    = ucfirst(strtolower($user_info->first_name)) . ' ' . strtoupper($user_info->last_name);
		$client_email   = $user_info->user_email;
		$client_phone   = (isset($user_info->equipeer_user_telephone) && $user_info->equipeer_user_telephone != '') ? $user_info->equipeer_user_telephone : '--';
		$client_address = (isset($user_info->equipeer_user_address_1)) ? $user_info->equipeer_user_address_1 . ', ' . $user_info->equipeer_user_city . ' (' . $user_info->equipeer_user_zip . ') - ' . $user_info->equipeer_user_country : '--';
        // -----------------------------
        // Send Email to ADMIN
        // -----------------------------
		add_filter( 'wp_mail_content_type', 'equipeer_set_html_mail_content_type' );
		// -----------------------------
        $email_admin_body  = "Bonjour Admin,<br><br>Envoi d'une sélection par le client suivant :<br><br>Sélection : $refs<br>Client : $client_name<br>Adresse : $client_address<br>Email : $client_email<br>Téléphone : $client_phone<br><br>Message automatique site EQUIPEER";
        // --- Send email (Headers)
        // (string|array) (Required) Array or comma-separated list of email addresses to send message
        $emails    = (get_option('equine_email_admin_selection') != '') ? get_option('equine_email_admin_selection') : get_option('admin_email');
        $comma     = strpos($emails, ","); // Search if several emails
        $to_admins = ($comma === false) ? $emails : explode(",", $emails);
        $subject   = "Envoi d'une sélection par un client (Ref: ".esc_html($refs).")";
        $body      = nl2br($email_admin_body);
        // -----------------------------
        $admin_email_result = wp_mail( $to_admins, $subject, $body, $headers );
		// -----------------------------
        // Reset content-type to avoid conflicts -- https://core.trac.wordpress.org/ticket/23578
		// -----------------------------
        remove_filter( 'wp_mail_content_type', 'equipeer_set_html_mail_content_type' );
		// -----------------------------
	}
}

/**
 * Get all IDS for PREV / BACK TO LIST / NEXT
 *
 * @param 	$args_session 	Query arguments
 *
 * @return void (Prepare SESSION)
 */
if (!function_exists("equipeer_get_prev_list_next")) {
	function equipeer_get_prev_list_next( $args_session = false ) {
		// Initialize
		$_SESSION['equipeer_user_list'] = [];
		$_SESSION['equipeer_list_back'] = "";
		if (!$args_session) {
			// Toutes les annonces
			$args_session = array(
				'post_type'      => 'equine',
				'post_status'    => array( 'publish' ),
				'perm'           => 'readable', // Beware of setting the 'post_status' to anything other than 'public', as it can easily lead to an information disclosure vulnerability
				'cache_results'  => true,
				'orderby'        => 'date',
				'order'          => 'DESC',
				'posts_per_page' => -1
			);
		}
		$query_session = new WP_Query( $args_session );
		if ( $query_session->have_posts() ) {
			while ( $query_session->have_posts() ) {
				$query_session->the_post(); // Don't remove this line (required for loop)
				$_SESSION['equipeer_user_list'][] = get_the_ID();
			}
		}
		// Get full back list URL
		$_SESSION['equipeer_list_back'] = (!$args_session) ? get_site_url() . '/annonces' : equipeer_current_url();
	}
}

function equipeer_previous_element(array $array, $currentKey) {
    if (!isset($array[$currentKey])) {
        return false;
    }
    end($array);
    do {
        $key = array_search(current($array), $array);
        $previousElement = prev($array);
    }
    while ($key != $currentKey);

    return $previousElement;
}
function equipeer_next_element(array $array, $currentKey) {
    if (!isset($array[$currentKey])) {
        return false;
    }
    reset($array);
    do {
        $key = array_search(current($array), $array);
        $nextElement = next($array);
    }
    while ($key != $currentKey);

    return $nextElement;
}

/**
 * Return converted seconds into h:m:s
 *
 * @param	$sec 		seconds
 * @param	$padHours	???
 *
 * @return hms (string)
 */
if (!function_exists("equipeer_sec2hms")) {
	function equipeer_sec2hms($sec, $padHours = false) {
		$hms     = "";
		$hours   = intval(intval($sec) / 3600);
		$hms    .= ($padHours) ? str_pad($hours, 2, "0", STR_PAD_LEFT). ':' : $hours. ':';
		$minutes = intval(($sec / 60) % 60);
		$hms    .= str_pad($minutes, 2, "0", STR_PAD_LEFT). ':';
		$seconds = intval($sec % 60);
		$hms     .= str_pad($seconds, 2, "0", STR_PAD_LEFT);
	
		return $hms;
	}
}

/**
 * Return converted h:m:s into seconds
 *
 * @param	$hms 	H:M:S
 *
 * @return seconds (int)
 */
if (!function_exists("equipeer_hms2sec")) {
	function equipeer_hms2sec($hms) {
		list($h, $m, $s) = explode (":", $hms);
		$seconds = 0;
		$seconds += (intval($h) * 3600);
		$seconds += (intval($m) * 60);
		$seconds += (intval($s));
		return $seconds;
	}
}

/**
 * Get Browser infos
 * This method return array
 *
 * @return array
 */
if (!function_exists("equipeer_get_browser")) {
	function equipeer_get_browser() { 
		$u_agent = $_SERVER['HTTP_USER_AGENT']; 
		$bname = 'Unknown';
		$platform = 'Unknown';
		$version= "";
	
		//First get the platform?
		if (preg_match('/linux/i', $u_agent)) {
			$platform = 'linux';
		}
		elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
			$platform = 'mac';
		}
		elseif (preg_match('/windows|win32/i', $u_agent)) {
			$platform = 'windows';
		}
	
		// Next get the name of the useragent yes seperately and for good reason
		if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent)) 
		{ 
			$bname = 'Internet Explorer'; 
			$ub = "MSIE"; 
		} 
		elseif(preg_match('/Firefox/i',$u_agent)) 
		{ 
			$bname = 'Mozilla Firefox'; 
			$ub = "Firefox"; 
		} 
		elseif(preg_match('/Chrome/i',$u_agent)) 
		{ 
			$bname = 'Chrome'; 
			$ub = "Chrome"; 
		} 
		elseif(preg_match('/Safari/i',$u_agent)) 
		{ 
			$bname = 'Safari'; 
			$ub = "Safari"; 
		} 
		elseif(preg_match('/Opera/i',$u_agent)) 
		{ 
			$bname = 'Opera'; 
			$ub = "Opera"; 
		} 
		elseif(preg_match('/Netscape/i',$u_agent)) 
		{ 
			$bname = 'Netscape'; 
			$ub = "Netscape"; 
		} 
	
		// finally get the correct version number
		$known = array('Version', $ub, 'other');
		$pattern = '#(?<browser>' . join('|', $known) .
		')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
		if (!preg_match_all($pattern, $u_agent, $matches)) {
			// we have no matching number just continue
		}
	
		// see how many we have
		$i = count($matches['browser']);
		if ($i != 1) {
			//we will have two since we are not using 'other' argument yet
			//see if version is before or after the name
			if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
				$version= $matches['version'][0];
			}
			else {
				$version= $matches['version'][1];
			}
		}
		else {
			$version= $matches['version'][0];
		}
	
		// check if we have a number
		if ($version==null || $version=="") {$version="?";}
	
		return array(
			'userAgent' => $u_agent,
			'name'      => $bname,
			'version'   => $version,
			'platform'  => $platform,
			'pattern'   => $pattern
		);
	}
}

/**
 * Return decode HTML string
 *
 * @param 	$str 	string to decode
 *
 * @return string
 */
if (!function_exists("eq_decodeHtmlEnt")) {
	function eq_decodeHtmlEnt($str) {
		$ret = html_entity_decode($str, ENT_COMPAT, 'UTF-8');
		$p2 = -1;
		for(;;) {
			$p = strpos($ret, '&#', $p2+1);
			if ($p === FALSE)
				break;
			$p2 = strpos($ret, ';', $p);
			if ($p2 === FALSE)
				break;
			   
			if (substr($ret, $p+2, 1) == 'x')
				$char = hexdec(substr($ret, $p+3, $p2-$p-3));
			else
				$char = intval(substr($ret, $p+2, $p2-$p-2));
			   
			//echo "$char\n";
			$newchar = iconv(
				'UCS-4', 'UTF-8',
				chr(($char>>24)&0xFF).chr(($char>>16)&0xFF).chr(($char>>8)&0xFF).chr($char&0xFF)
			);
			//echo "$newchar<$p<$p2<<\n";
			$ret = substr_replace($ret, $newchar, $p, 1+$p2-$p);
			$p2 = $p + strlen($newchar);
		}
		return $ret;
	}
}

/**
* Return a string to truncate
* @param string $string
* @param int $max
* @param string $replacement
* @return string truncated
*/
if (!function_exists("equipeer_truncate")) {
	function equipeer_truncate($string, $maxChar = 20, $replacement = '') {
		if (strlen($string) <= $maxChar) {
			return $string;
		}
		$string1 = mb_strimwidth($string, 0, $maxChar, "");
		$clean_string = (mb_substr($string1, -1) == "?") ? trim(substr_replace($string1, "", -1)) : $string1;
		return $clean_string . $replacement;
	}
}

/**
* Searches text for unwanted tags and removes them
* @param string $text String to purify
* @return string $text The purified text
*/
if (!function_exists("equipeer_stop_XSS")) {
	function equipeer_stop_XSS($text) {
		if (!is_array($text)) {
			$text = preg_replace("/\(\)/si", "", $text);
			$text = strip_tags($text);
			$text = str_replace(array("\"",">","<","\\"), "", $text);
		} else {
			foreach($text as $k=>$t) {
				if (is_array($t)) {
					equipeer_stop_XSS($t);
				} else {
					$t = preg_replace("/\(\)/si", "", $t);
					$t = strip_tags($t);
					$t = str_replace(array("\"",">","<","\\"), "", $t);
					$text[$k] = $t;
				}
			}
		}
		return $text;
	}
}

/**
 * Check whether URL is HTTPS / HTTP
 * @return boolean [description]
 */
if (!function_exists("equipeer_is_secure")) {
	function equipeer_is_secure() {
		if (
			( ! empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
			|| ( ! empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')
			|| ( ! empty($_SERVER['HTTP_X_FORWARDED_SSL']) && $_SERVER['HTTP_X_FORWARDED_SSL'] == 'on')
			|| (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443)
			|| (isset($_SERVER['HTTP_X_FORWARDED_PORT']) && $_SERVER['HTTP_X_FORWARDED_PORT'] == 443)
			|| (isset($_SERVER['REQUEST_SCHEME']) && $_SERVER['REQUEST_SCHEME'] == 'https')
		) {
			return true;
		} else {
			return false;
		}
	}
}

/**
 * Returns a rewrite string
 * @return string
 */
if (!function_exists("equipeer_rewrite_string")) {
	function equipeer_rewrite_string($string = "") {
		$noValidString = trim($string);
		$noValidString = preg_replace('`\s+`', '-', trim($noValidString));
		$noValidString = str_replace("'", "-", $noValidString);
		$noValidString = str_replace('"', '-', $noValidString);
		$noValidString = preg_replace('`_+`', '-', trim($noValidString));
		$caracters_in  = array(' ', '?', '!', '.', ',', ':', "'", '&', '(', ')', '-', '/', '%', '=', '+', '[', ']', '~', '"', '{', '}', '|', "`", '@', '$', '£', '*');
		$caracters_out = array('-', '', '', '', '', '-', '-', '-', '', '', '-', '-', '-', '-', '-', '', '', '', '', '', '', '', '-', '-', '-', '-', '');
		$noValidString = str_replace($caracters_in, $caracters_out, $noValidString);
		$noValidString = str_replace("------", "-", $noValidString);
		$noValidString = str_replace("-----", "-", $noValidString);
		$noValidString = str_replace("----", "-", $noValidString);
		$noValidString = str_replace("---", "-", $noValidString);
		$noValidString = str_replace("--", "-", $noValidString);
		$accents       = array('À','Á','Â','Ã','Ä','Å','à','á','â','ã','ä','å','Ò','Ó','Ô','Õ','Ö','Ø','ò','ó','ô','õ','ö','ø','È','É','Ê','Ë','è','é','ê','ë','Ç','ç','Ì','Í','Î','Ï','ì','í','î','ï','Ù','Ú','Û','Ü','ù','ú','û','ü','ÿ','Ñ','ñ');
		$ssaccents     = array('A','A','A','A','A','A','a','a','a','a','a','a','O','O','O','O','O','O','o','o','o','o','o','o','E','E','E','E','e','e','e','e','C','c','I','I','I','I','i','i','i','i','U','U','U','U','u','u','u','u','y','N','n');
		$validString   = str_replace($accents, $ssaccents, $noValidString);
	
		return ($validString);
	}
}

/**
 * Generate a random string, using a cryptographically secure 
 * pseudorandom number generator (random_int)
 * 
 * For PHP 7, random_int is a PHP core function
 * For PHP 5.x, depends on https://github.com/paragonie/random_compat
 * 
 * @param int $length      How many characters do we want?
 * @param string $keyspace A string of all possible characters
 *                         to select from
 * @return string
 */
if (!function_exists("equipeer_random_str")) {
	function equipeer_random_str( $length, $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ' ) {
		$str = '';
		$max = mb_strlen($keyspace, '8bit') - 1;
		if ($max < 1) {
			throw new Exception('$keyspace must be at least two characters long');
		}
		for ($i = 0; $i < $length; ++$i) {
			$str .= $keyspace[random_int(0, $max)];
		}
		return $str;
	}
}

/**
 * Create random string
 * @return string
 */
if (!function_exists("equipeer_rand_sha1")) {
	function equipeer_rand_sha1($length) {
		$max = ceil($length / 40);
		$random = '';
		for ($i = 0; $i < $max; $i ++) {
		  $random .= sha1(microtime(true).mt_rand(10000,90000));
		}
		return substr($random, 0, $length);
	}
}

/**
 * Check locale WP Site
 * @return LC_TIME (setlocale)
 */
if (!function_exists("equipeer_get_locale")) {
	function equipeer_get_locale() {
		$equipeer_locale_wp = get_locale();
		if ($equipeer_locale_wp == 'fr_FR')
			setlocale(LC_TIME, "fr_FR.utf8", "fra");
		else {
			setlocale(LC_TIME, "$equipeer_locale_wp.utf8", "fra");
		}
	}
}

/**
 * Create / Start to Increment Log file
 * @return string
 */
if (!function_exists("equipeer_log_start")) {
	function equipeer_log_start($file = "") {
		$log_file = ($file != "") ? "log_$file.txt" : "log.txt";
		file_put_contents ( ABSPATH . "logs/$log_file" , "==========================\n", FILE_APPEND);
	}
}

/**
 * Increment Log File
 * @return string
 */
if (!function_exists("equipeer_log")) {
	function equipeer_log ($var, $file = "") {
		$log_file = ($file != "") ? "log_$file.txt" : "log.txt";
		file_put_contents ( ABSPATH . "logs/$log_file" , var_export($var, true), FILE_APPEND);
		file_put_contents ( ABSPATH . "logs/$log_file" , "\n", FILE_APPEND);
	}
}

/**
 * Create / Start to Increment Log file
 * @return string
 */
if (!function_exists("equipeer_log_messaging_start")) {
	function equipeer_log_messaging_start( $id ) {
		file_put_contents ( ABSPATH . "logs/messaging_conv_id_$id.txt" , "==========================\n", FILE_APPEND);
	}
}

/**
 * Increment Log File
 * @return string
 */
if (!function_exists("equipeer_log_messaging")) {
	function equipeer_log_messaging( $id, $var ) {
		file_put_contents ( ABSPATH . "logs/messaging_conv_id_$id.txt" , var_export($var, true), FILE_APPEND);
		file_put_contents ( ABSPATH . "logs/messaging_conv_id_$id.txt" , "\n", FILE_APPEND);
	}
}

/**
 * Check if session is started
 * @return bool
 */
if (!function_exists("equipeer_is_session_started")) {
	function equipeer_is_session_started() {
		if ( php_sapi_name() !== 'cli' ) {
			if ( version_compare(phpversion(), '5.4.0', '>=') ) {
				return session_status() === PHP_SESSION_ACTIVE ? TRUE : FALSE;
			} else {
				return session_id() === '' ? FALSE : TRUE;
			}
		}
		return FALSE;
	}
}

// --- Function EMAIL
if (!function_exists("equipeer_set_html_mail_content_type")) {
	function equipeer_set_html_mail_content_type() {
		return 'text/html';
	}
}

if (!function_exists("equipeer_illegal_character")) {
	function equipeer_illegal_character($string) {
		$illegal_caracters = array('À','Á','Â','Ã','Ä','Å','à','á','â','ã','ä','å','Ò','Ó','Ô','Õ','Ö','Ø','ò','ó','ô','õ','ö','ø','È','É','Ê','Ë','è','é','ê','ë','Ç','ç','Ì','Í','Î','Ï','ì','í','î','ï','Ù','Ú','Û','Ü','ù','ú','û','ü','ÿ','Ñ','ñ','&','~','"','#','{','}','(',')','[',']','-','_','`','/','^','¨','@','°','+','=','$','£','¤','%','*','µ','?',',',';','.',':','!','§','n','”','“','¢','»','ł','|','ß','ð','đ','ŋ','ħ','j','ĸ','ł','µ','þ','œ','→','↓','←','ŧ','¶','€','«','æ','¬','¹');
	
		if (strpos($string, $illegal_caracters) === true)
			return true;
		else
			return false;
	}
}

if (!function_exists("predump")) {
	function predump($value) {
		echo '<pre>';
		var_dump($value);
		echo '</pre>';
	}
}

/**
 * Very useful to print out to the browsers console instead of just var_dumping
 *
 * Usage:
 * $myvar = array(1,2,3);
 * console_log( $myvar ); // [1,2,3]
 */
if (!function_exists("equipeer_console_log")) {
	function equipeer_console_log( $data ){
	  echo '<script>';
	  echo 'console.log('. json_encode( $data ) .')';
	  echo '</script>';
	}
}

function equipeer_unique_multidim_array($array, $key) {
    $temp_array = array();
    $i = 0;
    $key_array = array();
   
    foreach($array as $val) {
        if (!in_array($val[$key], $key_array)) {
            $key_array[$i] = $val[$key];
            $temp_array[$i] = $val;
        }
        $i++;
    }
    return $temp_array;
} 

?>