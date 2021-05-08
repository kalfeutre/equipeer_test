
		<!--<li class="nav-epreuve mb-4">
			<span data-epreuve="horse" class="epreuve epreuve-horse selected">
				<i class="fas fa-horse-head"></i><br>
				<h2><?php echo __( 'Tests', 'wp-bootstrap-starter' ) . '<br>' . __( 'Horses', 'wp-bootstrap-starter' ); ?></h2>
			</span>
			<span data-epreuve="pony" class="epreuve epreuve-pony">
				<i class="fas fa-horse"></i><br>
				<h2><?php echo __( 'Tests', 'wp-bootstrap-starter' ) . '<br>' . __( 'Ponys', 'wp-bootstrap-starter' ); ?></h2>
			</span>
			<input type="hidden" id="epreuve" name="epreuve" value="horse">
		</li>-->
		
		<?php if ( is_post_type_archive( 'equine' ) ) { ?>
			<li class="nav-input-search">
				<p class="mt-3 mb-0 text-center">
					<strong class="lead font-weight-normal text-uppercase"><?php _e('Search', EQUIPEER_ID); ?></strong>
				</p>
			</li>
		<?php } ?>
		
		<li class="nav-input-search mt-4">
			<?php $form_lang = (ICL_LANGUAGE_CODE == 'fr') ? '' : '/en'; ?>
			<form action="<?php echo get_site_url() . $form_lang; ?>/annonces/" method="get">
				<!--<div class="input-wrapper">
					<input class="search" type="text" id="ref" name="ref" placeholder="<?php _e( 'Find a reference', 'wp-bootstrap-starter' ); ?>, ex: 400">
					<input class="search" type="hidden" name="s" value="search_ref">
					<label for="search" class="fa fa-search input-icon"></label>
				</div>-->
				<div class="input-group mb-3">
					<button class="btn btn-outline-secondary btn-transparent" type="submit" id="button-ref"><?php _e( 'Find a reference', 'wp-bootstrap-starter' ); ?></button>
					<input id="ref" name="ref" type="text" class="form-control" placeholder="Ex: 400" aria-label="<?php _e( 'Find a reference', 'wp-bootstrap-starter' ); ?>" aria-describedby="button-ref">
					<input class="search" type="hidden" name="s" value="search_ref">
					<label for="search" class="fa fa-search input-icon"></label>
				</div>
			</form>
			<!--<a href="" class="eq-button eq-button-blue btn-block" onclick="reset_main_form()"><?php _e( 'Reset filters', 'wp-bootstrap-starter' ); ?></a>-->
			<button form="searchMainForm" id="search-validation" type="submit" class="eq-button eq-button-red btn-block mb-2"><?php _e('Search / Validation', 'wp-bootstrap-starter' ); ?><span id="search_counter"> (<?php echo equipeer_get_search_counter(); ?>)</span></button>
			<br>
			<a href="<?php echo get_site_url() . $form_lang; ?>/annonces/" class="eq-button eq-button-blue btn-block"><?php _e( 'Reset filters', 'wp-bootstrap-starter' ); ?></a>
			<p class="mt-3 mb-3"><strong class="lead text-uppercase font-weight-bold"><?php _e( 'Filters', 'wp-bootstrap-starter' ); ?></strong></p>
			<!--<script>
				function reset_main_form() {
					document.getElementById("searchMainForm").reset();
				}
			</script>-->
		</li>

		<form action="<?php echo get_site_url() . $form_lang; ?>/annonces/" id="searchMainForm" name="searchMainForm" method="get">
			<li class="nav-accordion">
				<!-- Accordion START -->
				<div class="panel-group" id="accordion">
					
					<!-- ====================== -->
					<!-- ===== DISCIPLINE ===== -->
					<!-- ====================== -->
					<div class="panel panel-default">
						<div class="panel-heading accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" data-target="#collapseDiscipline">
							<h4 class="panel-title"><?php _e( 'Categories', 'wp-bootstrap-starter' ); ?></h4>
							<i class="arrow arrow-down"></i>
						</div>
						<div id="collapseDiscipline" class="panel-collapse collapse<?php if (trim($_GET['main_discipline']) != '') echo ' show'; ?>" data-get="<?php echo $_GET['main_discipline']; ?>">
							<div class="panel-body">
								<p>
									<?php
										// ---------------------------------------------
										$taxonomies_discipline = equipeer_get_terms('equipeer_discipline', array( 'equipeer_select_taxonomy_parent_id' ), 'horse');
										// ---------------------------------------------
										if ($taxonomies_discipline) {
											// ---------------------------------------------
											foreach( $taxonomies_discipline as $taxonomy ) {
												// ---------------------------------------------
												// --- Get number of canassons in each taxonomy
												// ---------------------------------------------
												$args = array(
													'post_type'      => 'equine',
													'post_status'    => array( 'publish' ),
													'perm'           => 'readable', // Beware of setting the 'post_status' to anything other than 'public', as it can easily lead to an information disclosure vulnerability
													'cache_results'  => true,
													'meta_query'     => array(
														array( 'key' => 'discipline', 'value' => $taxonomy['id'], 'compare' => 'IN' ),
														array( 'key' => 'sold', 'value' => '0', 'compare' => '=' )
													)
												);
												$query = new WP_Query( $args );
												$count = $query->found_posts;
												// --- Check if GET
												$get_main_discipline = array();
												if (trim($_GET['main_discipline']) != '') {
													$get_main_discipline = explode(",", trim($_GET['main_discipline']));
												}
												// --- Check s'il y a des canassons a rechercher
												if ($count > 0) {
													echo '<label class="navbar-search-label">';
													echo '<input class="main-discipline" rel="'.$count.'" type="checkbox" name="discipline_' . $taxonomy['id'] . '"  value="' . $taxonomy['id'] . '" ';
													//echo selected( $this->metaboxClass->get_meta_value('level'), $taxonomy['id'] );
													// If GET
													if (in_array($taxonomy['id'], $get_main_discipline)) echo 'checked=""';
													echo '> ';
													echo $taxonomy['name'];
													echo '</label><br>';
												}
											}
											// ---------------------------------------------
										}
									?>
								</p>
							</div>
						</div>
					</div>
					
					<!-- =============== -->
					<!-- ===== AGE ===== -->
					<!-- =============== -->
					<div class="panel panel-default">
						<div class="panel-heading accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" data-target="#collapseAge">
							<h4 class="panel-title"><?php _e( 'Age', 'wp-bootstrap-starter' ); ?></h4>
							<i class="arrow arrow-down"></i>
						</div>
						<div id="collapseAge" class="panel-collapse collapse<?php if ( (isset($_GET['main_age_min']) && $_GET['main_age_min'] > 0) || (isset($_GET['main_age_max']) && $_GET['main_age_max'] < 20) ) echo ' show'; ?>" data-get="<?php echo intval($_GET['main_age_min']).'-'.intval($_GET['main_age_max']); ?>">
							<div class="panel-body">
								<p>
									<!--<input id="main-age" type="text" class="js-range-slider" name="main_age" value="" data-postfix=" ans" data-type="double" data-min="1" data-max="20" data-from="1" data-to="20" data-grid="false" data-step="1" />-->
									<input type="text" class="js-range-slider" name="main-age" id="main-age" value="" data-type="double" data-from="<?php if (isset($_GET['main_age_min'])) echo trim($_GET['main_age_min']); else echo 0; ?>" data-to="<?php if (isset($_GET['main_age_max'])) echo trim($_GET['main_age_max']); else echo 20; ?>" data-min="" data-values="Foal,1 an, 2 ans, 3 ans, 4 ans, 5 ans, 6 ans, 7 ans, 8 ans, 9 ans, 10 ans, 11 ans, 12 ans, 13 ans, 14 ans, 15 ans, 16 ans, 17 ans, 18 ans, 19 ans, 20 ans" data-grid="false">
								</p>
							</div>
						</div>
					</div>
					
					<!-- ===================== -->
					<!-- ===== POTENTIEL ===== -->
					<!-- ===================== -->
					<div class="panel panel-default">
						<div class="panel-heading accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" data-target="#collapsePotential">
							<h4 class="panel-title"><?php _e( 'Potential', 'wp-bootstrap-starter' ); ?></h4>
							<i class="arrow arrow-down"></i>
						</div>
						<div id="collapsePotential" class="panel-collapse collapse<?php if (trim($_GET['main_potential']) != '') echo ' show'; ?>" data-get="<?php echo $_GET['main_potential']; ?>">
							<div class="panel-body">
								<p>
									<?php
										// ---------------------------------------------
										$taxonomies_potential = equipeer_get_terms('equipeer_potential', array( 'equipeer_select_taxonomy_parent_id' ), 'horse');
										// ---------------------------------------------
										if ($taxonomies_potential) {
											// $taxonomies_potential
											foreach( $taxonomies_potential as $taxonomy ) {
												// ---------------------------------------------
												// --- Get number of canassons in each taxonomy
												// ---------------------------------------------
												$args = array(
													'post_type'      => 'equine',
													'post_status'    => array( 'publish' ),
													'perm'           => 'readable', // Beware of setting the 'post_status' to anything other than 'public', as it can easily lead to an information disclosure vulnerability
													'cache_results'  => true,
													'meta_query'     => array(
														array( 'key' => 'potentiel', 'value' => $taxonomy['id'], 'compare' => 'IN' ),
														array( 'key' => 'sold', 'value' => '0', 'compare' => '=' )
													)
												);
												$query = new WP_Query( $args );
												$count = $query->found_posts;
												// --- Check if GET
												$get_main_potential = array();
												if (trim($_GET['main_potential']) != '') {
													$get_main_potential = explode(",", trim($_GET['main_potential']));
												}
												// --- Check s'il y a des canassons dans les potentiels
												if ($count > 0) {
													echo '<label class="navbar-search-label">';
													echo '<input type="checkbox" class="main-potential" rel="'.$count.'" name="potential_' . $taxonomy['id'] . '"  value="' . $taxonomy['id'] . '" ';
													//echo selected( $this->metaboxClass->get_meta_value('level'), $taxonomy['id'] );
													// If GET
													if (in_array($taxonomy['id'], $get_main_potential)) echo 'checked=""';
													echo '> ';
													echo $taxonomy['name'];
													echo '</label><br>';
												}
											}
											// ---------------------------------------------
										}
									?>
								</p>
							</div>
						</div>
					</div>
					
					<!-- ================ -->
					<!-- ===== PRIX ===== -->
					<!-- ================ -->
					<div class="panel panel-default">
						<div class="panel-heading accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" data-target="#collapsePrice">
							<h4 class="panel-title"><?php _e( 'Price', 'wp-bootstrap-starter' ); ?></h4>
							<i class="arrow arrow-down"></i>
						</div>
						<div id="collapsePrice" class="panel-collapse collapse<?php if ( (isset($_GET['main_price_min']) && $_GET['main_price_min'] > 5000) || (isset($_GET['main_price_max']) && $_GET['main_price_max'] < 100000) ) echo ' show'; ?>">
							<div class="panel-body">
								<p>
									<input id="main-price" type="text" class="js-range-slider" name="price" value="" data-postfix=" €" data-type="double" data-min="5000" data-max="100000" data-from="<?php if (isset($_GET['main_price_min'])) echo $_GET['main_price_min']; else echo '5000'; ?>" data-to="<?php if (isset($_GET['main_price_max'])) echo $_GET['main_price_max']; else echo '100000'; ?>" data-max-postfix=" +" data-grid="false" data-step="1000" />
								</p>
							</div>
						</div>
					</div>
					
					<!-- ======================== -->
					<!-- ===== LOCALISATION ===== -->
					<!-- ======================== -->
					<div id="autocomplete_main" class="panel panel-default">
						<div class="panel-heading accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" data-target="#collapseLocation">
							<h4 class="panel-title"><?php _e( 'Location', 'wp-bootstrap-starter' ); ?> (<?php _e('City', EQUIPEER_ID); ?>)</h4>
							<i class="arrow arrow-down"></i>
						</div>
						<div id="collapseLocation" class="panel-collapse collapse<?php if (isset($_GET['autocomplete_global']) && trim($_GET['autocomplete_global'] != '')) echo ' show'; ?>">
							<div class="panel-body">
								<div id="searchMain" class="input-group text-center" style="max-width: 100%; margin: 0 auto;">
									<div class="input-group-prepend">
										<span class="input-group-text" id="basic-addon1"><i class="fas fa-map-marker-alt"></i></span>
									</div>
									<!--<input id="autocomplete_global" type="text" class="form-control autocomplete" placeholder="<?php _e('Localization', EQUIPEER_ID); ?>" onFocus="geolocate_global();" aria-label="Username" aria-describedby="basic-addon1">-->
									<input onclick="getLocation(this.id)" id="autocomplete_global" name="autocomplete_global" type="text" value="<?php if (isset($_GET['autocomplete_global']) && trim($_GET['autocomplete_global'] != '')) echo trim($_GET['autocomplete_global']); ?>" class="form-control autocomplete" placeholder="<?php _e('Indicate a city', EQUIPEER_ID); ?>" aria-label="Username" aria-describedby="basic-addon1">
									<!--<input type="hidden" id="main_localisation_latitude" name="main_localisation_latitude" value="<?php if (trim($_GET['main_localisation_latitude'])) echo $_GET['main_localisation_latitude']; ?>">-->
									<!--<input type="hidden" id="main_localisation_longitude" name="main_localisation_longitude" value="<?php if (trim($_GET['main_localisation_longitude'])) echo $_GET['main_localisation_longitude']; ?>">-->
									<span id="demo"></span>
								</div>
								<br>
								<?php _e( 'In a radius around', EQUIPEER_ID ); ?> <?php _e('the city informed', EQUIPEER_ID); ?>
								<br>
								<input type="text" class="js-range-slider" name="main_around" id="main_around" value="" data-postfix=" km" data-max-postfix=" +" data-min="50" data-max="1000" data-from="<?php if (trim($_GET['main_localisation_distance'])) echo $_GET['main_localisation_distance']; else echo '0'; ?>" data-to="1000" data-grid="false" data-step="50">
							</div>
						</div>
					</div>
					<script>
					function eq_init_search_main(id) {
						var debug_sm = false;
						// Debug
						if (debug_sm) console.log('init test 1: '+id);
						let input = document.getElementById(id); // the input field id from html file
						let autocomplete = new google.maps.places.Autocomplete(input);
						//let autocomplete = new google.maps.places.Autocomplete(jQuery('#'+id+' .autocomplete')[0], { types: ['(cities)'] });
						// Debug
						if (debug_sm) {
							if (autocomplete) {
								console.log('init test autocomplete OK');
							} else {
								console.log('init test autocomplete KO');
							}
						}
						google.maps.event.addListener(autocomplete, 'place_changed', function() {
							// Debug
							if (debug_sm) console.log('init test 2');
							let place = autocomplete.getPlace();
							// Debug
							if (debug_sm) console.log(place); // You will get complete data
							var lat = place.geometry.location.lat(), lng = place.geometry.location.lng();
							// Debug
							if (debug_sm) console.log('lat: '+lat+' - lgn: '+lng);
							jQuery( "#main_localisation_latitude" ).val( lat );
							jQuery( "#main_localisation_longitude" ).val( lng );
						});
					}
					var eq_x = document.getElementById("autocomplete_global");
					function getLocation(id) {
					    if (navigator.geolocation){
						navigator.geolocation.getCurrentPosition(showPosition, showError);
					    } else {
						// Geolocation is not supported by this browser
						Swal.fire({
							title: "<?php _e('Oops', EQUIPEER_ID); ?>",
							html: "<?php _e("Geolocation is not supported by this browser", EQUIPEER_ID); ?>",
							icon: "warning",
							showCloseButton: true,
							showCancelButton: false,
							showConfirmButton: true,
						});
					    }
					    // Autocomplete Google Places
    					    eq_init_search_main(id);
					}
					
					function showPosition(position){
					    lat = position.coords.latitude;
					    lng = position.coords.longitude;
					    displayLocation(lat, lng);
					}
					
					function showError(error){
					    switch(error.code){
						case error.PERMISSION_DENIED:
							// User denied the request for Geolocation
							//eq_x.innerHTML="User denied the request for Geolocation.";
							//eq_x.value = "User denied the request for Geolocation.";
						break;
						case error.POSITION_UNAVAILABLE:
							// Location information is unavailable
							//eq_x.innerHTML="Location information is unavailable.";
							//eq_x.value = "Location information is unavailable.";
							Swal.fire({
								title: "<?php _e('Oops', EQUIPEER_ID); ?>",
								html: "<?php _e("Location information is unavailable", EQUIPEER_ID); ?>",
								icon: "warning",
								showCloseButton: true,
								showCancelButton: false,
								showConfirmButton: true,
							});
						break;
						case error.TIMEOUT:
							// The request to get user location timed out
							//eq_x.innerHTML="The request to get user location timed out.";
							//eq_x.value = "The request to get user location timed out.";
							Swal.fire({
								title: "<?php _e('Oops', EQUIPEER_ID); ?>",
								html: "<?php _e("The request to get user location timed out", EQUIPEER_ID); ?>",
								icon: "warning",
								showCloseButton: true,
								showCancelButton: false,
								showConfirmButton: true,
							});
						break;
						case error.UNKNOWN_ERROR:
							// An unknown error occurred
							//eq_x.innerHTML="An unknown error occurred.";
							//eq_x.value = "An unknown error occurred.";
							Swal.fire({
								title: "<?php _e('Oops', EQUIPEER_ID); ?>",
								html: "<?php _e("An unknown error occurred", EQUIPEER_ID); ?>",
								icon: "warning",
								showCloseButton: true,
								showCancelButton: false,
								showConfirmButton: true,
							});
						break;
					    }
					}
					
					function displayLocation(latitude, longitude) {
						var geocoder;
						geocoder   = new google.maps.Geocoder();
						var latlng = new google.maps.LatLng(latitude, longitude);
					    
						geocoder.geocode(
							{'latLng': latlng}, 
							function(results, status) {
								if (status == google.maps.GeocoderStatus.OK) {
									if (results[0]) {
										var add   = results[0].formatted_address ;
										var value = add.split(",");
							    
										count   = value.length;
										country = value[count-1];
										state   = value[count-2];
										city    = value[count-3];
										//eq_x.innerHTML = state;
										eq_x.value = state + ', ' + country;
										jQuery( "#main_localisation_latitude" ).val( latitude );
										jQuery( "#main_localisation_longitude" ).val( longitude );
									} else {
										// Address not found
										//eq_x.innerHTML = "address not found";
										//eq_x.value = "address not found";
										Swal.fire({
											title: "<?php _e('Oops', EQUIPEER_ID); ?>",
											html: "<?php _e("Address not found", EQUIPEER_ID); ?>",
											icon: "warning",
											showCloseButton: true,
											showCancelButton: false,
											showConfirmButton: true,
										});
									}
								} else {
									// Geocoder failed due to ...
									//eq_x.innerHTML = "Geocoder failed due to: " + status;
									//eq_x.value = "Geocoder failed due to: " + status;
									Swal.fire({
										title: "<?php _e('Oops', EQUIPEER_ID); ?>",
										html: "<?php _e("Geocoder failed due to:", EQUIPEER_ID); ?>" + status,
										icon: "warning",
										showCloseButton: true,
										showCancelButton: false,
										showConfirmButton: true,
									});
								}
							}
						);
					}
					</script>
					
					<!-- ============================= -->
					<!-- ===== EXPERTISE / LIBRE ===== -->
					<!-- ============================= -->
					<div class="panel panel-default">
						<div class="panel-heading accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" data-target="#collapseExpertise">
							<h4 class="panel-title"><?php _e( 'EQUIPEER Evaluation', 'wp-bootstrap-starter' ); ?></h4>
							<i class="arrow arrow-down"></i>
						</div>
						<div id="collapseExpertise" class="panel-collapse collapse<?php if ($_GET['type_annonce_expert'] == '1' || $_GET['type_annonce_libre'] == '2') echo ' show'; ?>">
							<div class="panel-body">
								<p>
									<label class="navbar-search-label">
										<input id="type_annonce_expert" type="checkbox" name="type_annonce_expert" value="1"<?php if ($_GET['type_annonce_expert'] == '1') echo ' checked=""'; ?>>
										<?php _e( 'Appraised horses - Premium offer', EQUIPEER_ID ); ?>
									</label>
									<br>
									<label class="navbar-search-label">
										<input id="type_annonce_libre" type="checkbox" name="type_annonce_libre" value="2"<?php if ($_GET['type_annonce_libre'] == '2') echo ' checked=""'; ?>>
										<?php _e( 'Certified horses - Basic offer', EQUIPEER_ID ); ?>
									</label>
								</p>
							</div>
						</div>
					</div>
					
					<!-- ========================= -->
					<!-- ===== NIVEAU ACTUEL ===== -->
					<!-- ========================= -->
					<div class="panel panel-default">
						<div class="panel-heading accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" data-target="#collapseLevel">
							<h4 class="panel-title"><?php _e( 'Actual level', 'wp-bootstrap-starter' ); ?></h4>
							<i class="arrow arrow-down"></i>
						</div>
						<div id="collapseLevel" class="panel-collapse collapse<?php if (trim($_GET['main_level']) != '') echo ' show'; ?>">
							<div class="panel-body">
								<p>
									<?php
										// ---------------------------------------------
										$taxonomies_level = equipeer_get_terms('equipeer_level', array( 'equipeer_select_taxonomy_parent_id' ), 'horse');
										// ---------------------------------------------
										if ($taxonomies_level) {
											// ---------------------------------------------
											foreach( $taxonomies_level as $taxonomy ) {
												// ---------------------------------------------
												// --- Get number of canassons in each taxonomy
												// ---------------------------------------------
												$args = array(
													'post_type'      => 'equine',
													'post_status'    => array( 'publish' ),
													'perm'           => 'readable', // Beware of setting the 'post_status' to anything other than 'public', as it can easily lead to an information disclosure vulnerability
													'cache_results'  => true,
													'meta_query'     => array(
														array( 'key' => 'level', 'value' => $taxonomy['id'], 'compare' => 'IN' ),
														array( 'key' => 'sold', 'value' => '0', 'compare' => '=' )
													)
												);
												$query = new WP_Query( $args );
												$count = $query->found_posts;
												// --- Check if GET
												$get_main_level = array();
												if (trim($_GET['main_level']) != '') {
													$get_main_level = explode(",", trim($_GET['main_level']));
												}
												// --- Check s'il y a des canassons dans les niveaux
												if ($count > 0) {
													echo '<label class="navbar-search-label">';
													echo '<input class="main-level" type="checkbox" rel="'.$count.'" name="level_' . $taxonomy['id'] . '"  value="' . $taxonomy['id'] . '" ';
													//echo selected( $this->metaboxClass->get_meta_value('level'), $taxonomy['id'] );
													// If GET
													if (in_array($taxonomy['id'], $get_main_level)) echo 'checked=""';
													echo '> ';
													echo $taxonomy['name'];
													echo '</label><br>';
												}
											}
											// ---------------------------------------------
										}
									?>
								</p>
							</div>
						</div>
					</div>
					
					<!-- ================== -->
					<!-- ===== TAILLE ===== -->
					<!-- ================== -->
					<div class="panel panel-default">
						<div class="panel-heading accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" data-target="#collapseSize">
							<h4 class="panel-title"><?php _e( 'Size', 'wp-bootstrap-starter' ); ?></h4>
							<i class="arrow arrow-down"></i>
						</div>
						<div id="collapseSize" class="panel-collapse collapse<?php if (trim($_GET['main_size']) != '') echo ' show'; ?>">
							<div class="panel-body">
								<p>
									<?php
										// ---------------------------------------------
										$taxonomies_size = equipeer_get_terms('equipeer_size', array( 'equipeer_select_taxonomy_parent_id' ), 'horse');
										// ---------------------------------------------
										if ($taxonomies_size) {
											// $taxonomies_size
											foreach( $taxonomies_size as $taxonomy ) {
												// ---------------------------------------------
												// --- Get number of canassons in each taxonomy
												// ---------------------------------------------
												$args = array(
													'post_type'      => 'equine',
													'post_status'    => array( 'publish' ),
													'perm'           => 'readable', // Beware of setting the 'post_status' to anything other than 'public', as it can easily lead to an information disclosure vulnerability
													'cache_results'  => true,
													'meta_query'     => array(
														array( 'key' => 'size', 'value' => $taxonomy['id'], 'compare' => 'IN' ),
														array( 'key' => 'sold', 'value' => '0', 'compare' => '=' )
													)
												);
												$query = new WP_Query( $args );
												$count = $query->found_posts;
												// --- Check if GET
												$get_main_size = array();
												if (trim($_GET['main_size']) != '') {
													$get_main_size = explode(",", trim($_GET['main_size']));
												}
												// --- Check s'il y a des canassons dans les tailles
												if ($count > 0) {
													echo '<label class="navbar-search-label">';
													echo '<input class="main-size" type="checkbox" rel="'.$count.'" name="size_' . $taxonomy['id'] . '"  value="' . $taxonomy['id'] . '" ';
													//echo selected( $this->metaboxClass->get_meta_value('level'), $taxonomy['id'] );
													// If GET
													if (in_array($taxonomy['id'], $get_main_size)) echo 'checked=""';
													echo '> ';
													echo $taxonomy['name'];
													echo '</label><br>';
												}
											}
											// ---------------------------------------------
										}
									?>
								</p>
							</div>
						</div>
					</div>
					
					<!-- ============================ -->
					<!-- ===== ORIGINE PATERNEL ===== -->
					<!-- ============================ -->
					<div class="panel panel-default">
						<div class="panel-heading accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" data-target="#collapseOrigin">
							<h4 class="panel-title"><?php _e( 'Perennial origin', 'wp-bootstrap-starter' ); ?></h4>
							<i class="arrow arrow-down"></i>
						</div>
						<div id="collapseOrigin" class="panel-collapse collapse<?php if (trim($_GET['main_origin']) != '') echo ' show'; ?>">
							<div class="panel-body">
								<p>
									<input class="form-control" id="main-origin" style="width: 100%;" type="text" name="main_origin" value="<?php echo stripslashes ( sanitize_text_field( trim($_GET['main_origin']) ) ); ?>" placeholder="<?php _e( "Father's name", 'wp-bootstrap-starter' ); ?>">
								</p>
							</div>
						</div>
					</div>
					
					<!-- ================ -->
					<!-- ===== RACE ===== -->
					<!-- ================ -->
					<div class="panel panel-default">
						<div class="panel-heading accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" data-target="#collapseBreed">
							<h4 class="panel-title"><?php _e( 'Breed', 'wp-bootstrap-starter' ); ?></h4>
							<i class="arrow arrow-down"></i>
						</div>
						<div id="collapseBreed" class="panel-collapse collapse<?php if (trim($_GET['main_breed']) != '') echo ' show'; ?>">
							<div class="panel-body">
								<p>
									<?php
										// ---------------------------------------------
										$taxonomies_breed = equipeer_get_terms('equipeer_breed', array( 'equipeer_select_taxonomy_parent_id' ), 'horse');
										// ---------------------------------------------
										if ($taxonomies_breed) {
											// $taxonomies_breed
											foreach( $taxonomies_breed as $taxonomy ) {
												// ---------------------------------------------
												// --- Get number of canassons in each taxonomy
												// ---------------------------------------------
												$args = array(
													'post_type'      => 'equine',
													'post_status'    => array( 'publish' ),
													'perm'           => 'readable', // Beware of setting the 'post_status' to anything other than 'public', as it can easily lead to an information disclosure vulnerability
													'cache_results'  => true,
													'meta_query'     => array(
														array( 'key' => 'breed', 'value' => $taxonomy['id'], 'compare' => 'IN' ),
														array( 'key' => 'sold', 'value' => '0', 'compare' => '=' )
													)
												);
												$query = new WP_Query( $args );
												$count = $query->found_posts;
												// --- Check if GET
												$get_main_breed = array();
												if (trim($_GET['main_breed']) != '') {
													$get_main_breed = explode(",", trim($_GET['main_breed']));
												}
												// --- Check s'il y a des canassons dans les races
												if ($count > 0) {
													echo '<label class="navbar-search-label">';
													echo '<input class="main-breed" type="checkbox" rel="'.$count.'" name="breed_' . $taxonomy['id'] . '"  value="' . $taxonomy['id'] . '" ';
													//echo selected( $this->metaboxClass->get_meta_value('level'), $taxonomy['id'] );
													// If GET
													if (in_array($taxonomy['id'], $get_main_breed)) echo 'checked=""';
													echo '> ';
													echo $taxonomy['name'];
													echo '</label><br>';
												}
											}
											// ---------------------------------------------
										}
									?>
								</p>
							</div>
						</div>
					</div>
					
					<!-- ================ -->
					<!-- ===== SEXE ===== -->
					<!-- ================ -->
					<div class="panel panel-default">
						<div class="panel-heading accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" data-target="#collapseSex">
							<h4 class="panel-title"><?php _e( 'Sex', 'wp-bootstrap-starter' ); ?></h4>
							<i class="arrow arrow-down"></i>
						</div>
						<div id="collapseSex" class="panel-collapse collapse<?php if (trim($_GET['main_gender']) != '') echo ' show'; ?>">
							<div class="panel-body">
								<p>
									<?php
										// ---------------------------------------------
										$taxonomies_sex = equipeer_get_terms('equipeer_gender', array( 'equipeer_select_taxonomy_parent_id' ), 'horse');
										// ---------------------------------------------
										if ($taxonomies_sex) {
											// $taxonomies_sex
											foreach( $taxonomies_sex as $taxonomy ) {
												// ---------------------------------------------
												// --- Get number of canassons in each taxonomy
												// ---------------------------------------------
												$args = array(
													'post_type'      => 'equine',
													'post_status'    => array( 'publish' ),
													'perm'           => 'readable', // Beware of setting the 'post_status' to anything other than 'public', as it can easily lead to an information disclosure vulnerability
													'cache_results'  => true,
													'meta_query'     => array(
														array( 'key' => 'sex', 'value' => $taxonomy['id'], 'compare' => 'IN' ),
														array( 'key' => 'sold', 'value' => '0', 'compare' => '=' )
													)
												);
												$query = new WP_Query( $args );
												$count = $query->found_posts;
												// --- Check if GET
												$get_main_gender = array();
												if (trim($_GET['main_gender']) != '') {
													$get_main_gender = explode(",", trim($_GET['main_gender']));
												}
												// --- Check s'il y a des canassons dans les sexes
												if ($count > 0) {
													echo '<label class="navbar-search-label">';
													echo '<input class="main-sex" type="checkbox" rel="'.$count.'" name="sex' . $taxonomy['id'] . '"  value="' . $taxonomy['id'] . '" ';
													//echo selected( $this->metaboxClass->get_meta_value('level'), $taxonomy['id'] );
													// If GET
													if (in_array($taxonomy['id'], $get_main_gender)) echo 'checked=""';
													echo '> ';
													echo $taxonomy['name'];
													echo '</label><br>';
												}
											}
											// ---------------------------------------------
										}
									?>
								</p>
							</div>
						</div>
					</div>
					
					<!-- =================== -->
					<!-- ===== COULEUR ===== -->
					<!-- =================== -->
					<div class="panel panel-default">
						<div class="panel-heading accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" data-target="#collapseColor">
							<h4 class="panel-title"><?php _e( 'Color', 'wp-bootstrap-starter' ); ?></h4>
							<i class="arrow arrow-down"></i>
						</div>
						<div id="collapseColor" class="panel-collapse collapse<?php if (trim($_GET['main_color']) != '') echo ' show'; ?>">
							<div class="panel-body">
								<p>
									<?php
										// ---------------------------------------------
										$taxonomies_color = equipeer_get_terms('equipeer_color', array( 'equipeer_select_taxonomy_parent_id' ), 'horse');
										// ---------------------------------------------
										if ($taxonomies_color) {
											// $taxonomies_color
											foreach( $taxonomies_color as $taxonomy ) {
												// ---------------------------------------------
												// --- Get number of canassons in each taxonomy
												// ---------------------------------------------
												$args = array(
													'post_type'      => 'equine',
													'post_status'    => array( 'publish' ),
													'perm'           => 'readable', // Beware of setting the 'post_status' to anything other than 'public', as it can easily lead to an information disclosure vulnerability
													'cache_results'  => true,
													'meta_query'     => array(
														array( 'key' => 'dress', 'value' => $taxonomy['id'], 'compare' => 'IN' ),
														array( 'key' => 'sold', 'value' => '0', 'compare' => '=' )
													)
												);
												$query = new WP_Query( $args );
												$count = $query->found_posts;
												// --- Check if GET
												$get_main_color = array();
												if (trim($_GET['main_color']) != '') {
													$get_main_color = explode(",", trim($_GET['main_color']));
												}
												// --- Check s'il y a des canassons dans les robes
												if ($count > 0) {
													echo '<label class="navbar-search-label">';
													echo '<input class="main-color" type="checkbox" rel="'.$count.'" name="color_' . $taxonomy['id'] . '"  value="' . $taxonomy['id'] . '" ';
													//echo selected( $this->metaboxClass->get_meta_value('level'), $taxonomy['id'] );
													// If GET
													if (in_array($taxonomy['id'], $get_main_color)) echo 'checked=""';
													echo '> ';
													echo $taxonomy['name'];
													echo '</label><br>';
												}
											}
											// ---------------------------------------------
										}
									?>
								</p>
							</div>
						</div>
					</div>
					
				</div>
				<!-- Accordion END -->
				<div class="mt-5 mb-4">
					<!-- Rechercher / Validation -->
					<button id="search-validation" type="submit" class="eq-button eq-button-red btn-block mb-2"><?php _e('Search / Validation', 'wp-bootstrap-starter' ); ?><span id="search_counter"> (<?php echo equipeer_get_search_counter(); ?>)</span></button>
					<br>
					<!-- Sauvegarder ma recherche -->
					<?php echo do_shortcode('[equine-save-my-search large="true"]'); ?>
					<!-- Hidden fields -->
					<input type="hidden" name="s" value="search_main">
					<input type="hidden" name="main_discipline" id="main_discipline" value="<?php echo $_GET['main_discipline']; ?>">
					<input type="hidden" name="main_age_min" id="main_age_min" value="<?php if (trim($_GET['main_age_min'])) echo $_GET['main_age_min']; else echo 0; ?>">
					<input type="hidden" name="main_age_max" id="main_age_max" value="<?php if (trim($_GET['main_age_max'])) echo $_GET['main_age_max']; else echo 20; ?>">
					<input type="hidden" name="main_potential" id="main_potential" value="<?php echo $_GET['main_potential']; ?>">
					<input type="hidden" name="main_price_min" id="main_price_min" value="<?php if (trim($_GET['main_price_min'])) echo $_GET['main_price_min']; else echo '5000'; ?>">
					<input type="hidden" name="main_price_max" id="main_price_max" value="<?php if (trim($_GET['main_price_max'])) echo $_GET['main_price_max']; else echo '100000'; ?>">
					<input type="hidden" name="main_localisation_latitude" id="main_localisation_latitude" value="<?php echo trim($_GET['main_localisation_latitude']); ?>">
					<input type="hidden" name="main_localisation_longitude" id="main_localisation_longitude" value="<?php echo trim($_GET['main_localisation_longitude']); ?>">
					<input type="hidden" name="main_localisation_distance" id="main_localisation_distance" value="<?php if (trim($_GET['main_localisation_distance'])) echo trim($_GET['main_localisation_distance']); else echo '0'; ?>">
					<input type="hidden" name="main_around" id="main_around" value="<?php if (trim($_GET['main_around'])) echo trim($_GET['main_around']); else echo '0'; ?>">					
					<input type="hidden" name="main_expertise" id="main_expertise" value="0">
					<input type="hidden" name="main_level" id="main_level" value="<?php echo $_GET['main_level']; ?>">
					<input type="hidden" name="main_size" id="main_size" value="<?php echo $_GET['main_size']; ?>">
					<input type="hidden" name="main_breed" id="main_breed" value="<?php echo $_GET['main_breed']; ?>">
					<input type="hidden" name="main_gender" id="main_gender" value="<?php echo $_GET['main_gender']; ?>">
					<input type="hidden" name="main_color" id="main_color" value="<?php echo $_GET['main_color']; ?>">
				</div>
			</li>
		</form>
		<script>
			jQuery(function($) {
				// ======================
				// ===== DISCIPLINE =====	
				// ======================
				$('.main-discipline').click(function() {
					// Add value to input
					var checkedVals = $('.main-discipline:checkbox:checked').map(function() {
						return this.value;
					}).get();
					$('#main_discipline').val( checkedVals.join(",") );
				});
				// ============================
				// ===== RANGE SLIDER AGE =====	
				// ============================
				$("#main-age").ionRangeSlider({
					skin: "modern",
					onFinish: function (data) {
						// Called every time handle position is changed
						$('#main_age_min').val( parseInt( data.from ) );
						$('#main_age_max').val( parseInt( data.to ) );
					}
				});
				// =====================
				// ===== POTENTIEL =====	
				// =====================
				$('.main-potential').click(function() {
					// Add value to input
					var checkedVals = $('.main-potential:checkbox:checked').map(function() {
						return this.value;
					}).get();
					$('#main_potential').val( checkedVals.join(",") );
				});
				// ================
				// ===== PRIX =====	
				// ================
				$("#main-price").ionRangeSlider({
					drag_interval: true,
				        min_interval: 5000,
					skin: "modern",
					onFinish: function (data) {
						// Called every time handle position is changed
						$('#main_price_min').val( parseInt( data.from ) );
						$('#main_price_max').val( parseInt( data.to ) );
					}
				});
				// =====================================
				// ===== RANGE SLIDER LOCALISATION =====	
				// =====================================
				$("#main_around").ionRangeSlider({
					skin: "modern",
					onFinish: function (data) {
						// Called every time handle position is changed
						$('#main_localisation_distance').val( parseInt( data.from ) );
					}
				});
				// =====================
				// ===== EXPERTISE =====
				// =====================
				$("#main-expertise").click(function() {
					if ($("#main-expertise").is(':checked'))
						$('#main_expertise').val( '1' );
					else
						$('#main_expertise').val( '0' );
				});
				// ==================
				// ===== NIVEAU =====	
				// ==================
				$('.main-level').click(function() {
					var checkedVals = $('.main-level:checkbox:checked').map(function() {
						return this.value;
					}).get();
					$('#main_level').val( checkedVals.join(",") );
				});
				// ==================
				// ===== TAILLE =====	
				// ==================
				$('.main-size').click(function() {
					var checkedVals = $('.main-size:checkbox:checked').map(function() {
						return this.value;
					}).get();
					$('#main_size').val( checkedVals.join(",") );
				});
				// ===================
				// ===== ORIGINE =====	
				// ===================
				$('#main-origin').change(function() {
					//$('#main_origin').val( $('#main-origin').val() );
				});
				// ================
				// ===== RACE =====	
				// ================
				$('.main-breed').click(function() {
					var checkedVals = $('.main-breed:checkbox:checked').map(function() {
						return this.value;
					}).get();
					$('#main_breed').val( checkedVals.join(",") );
				});
				// ================
				// ===== SEXE =====	
				// ================
				$('.main-sex').click(function() {
					var checkedVals = $('.main-sex:checkbox:checked').map(function() {
						return this.value;
					}).get();
					$('#main_gender').val( checkedVals.join(",") );
				});
				// ===================
				// ===== COULEUR =====	
				// ===================
				$('.main-color').click(function() {
					var checkedVals = $('.main-color:checkbox:checked').map(function() {
						return this.value;
					}).get();
					$('#main_color').val( checkedVals.join(",") );
				});
				// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
				// -=-=-=- Get counter search =-=-=-=
				// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
				$('.search-move').click(function() {
					$.ajax({
						type: "POST",                // use $_POST request to submit data
						url: equipeer_ajax.ajaxurl,  // URL to "wp-admin/admin-ajax.php"
						data: {
							action : 'equipeer_get_search_counter', // wp_ajax_*, wp_ajax_nopriv_*
						},
						success: function(response) {
							$('#search-validation span#search_counter').html('&nbsp;(' + response + ')');
							//console.log('R: ' + response);
							console.log('Search: '+search);
						},
						error: function(xhr, options, toto) {
							console.log(xhr);
							console.log(options);
							console.log(toto);
						}
					});
				});
			});
		</script>
		<script>
			//(function() {
			//	
			//	// This sample uses the Autocomplete widget to help the user select a
			//	// place, then it retrieves the address components associated with that
			//	// place, and then it populates the form fields with those details.
			//	// This sample requires the Places library. Include the libraries=places
			//	// parameter when you first load the API. For example:
			//	// <script
			//	// src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">
			//	var placeSearch, autocomplete_global;
			//	// Put the same ID to your INPUTS
			//	var componentForm = {
			//		street_number: 'short_name',   // long_name | short_name
			//		route: 'long_name',            // long_name | short_name
			//		locality: 'long_name',         // long_name | short_name
			//		//administrative_area_level_1: 'short_name',
			//		//administrative_area_level_2: 'short_name',
			//		country: 'long_name',          // long_name | short_name
			//		postal_code: 'long_name'       // long_name | short_name
			//	};
			//	
			//	google.maps.event.addDomListener(window, 'load', initAutocomplete_global);
			//});
			//// Init Autocomplete
			//function initAutocomplete_global() {
			//	// Create the autocomplete object, restricting the search predictions to
			//	// geographical location types.
			//	autocomplete_global = new google.maps.places.Autocomplete(
			//		document.getElementById('autocomplete_global'), {types: ['geocode']}
			//	);
			//	// Avoid paying for data that you don't need by restricting the set of
			//	// place fields that are returned to just the address components.
			//	autocomplete_global.setFields(['address_component', 'geometry']);
			//	// When the user selects an address from the drop-down, populate the
			//	// address fields in the form.
			//	autocomplete_global.addListener('place_changed', fillInAddress_global);
			//}
			//// Fill in Address Fields
			//function fillInAddress_global() {
			//	// Get the place details from the autocomplete object.
			//	var place = autocomplete_global.getPlace();                      
			//	var lat   = place.geometry.location.lat(),
			//		lng   = place.geometry.location.lng();				
			//	// Add Longitude / Latitude
			//	jQuery( "#main_localisation_latitude" ).val( lat );
			//	jQuery( "#main_localisation_longitude" ).val( lng );
			//}
			//// Bias the autocomplete object to the user's geographical location,
			//// as supplied by the browser's 'navigator.geolocation' object.
			//function geolocate_global() {
			//	if (navigator.geolocation) {
			//		navigator.geolocation.getCurrentPosition(function(position) {
			//			var geolocation = {
			//				lat: position.coords.latitude,
			//				lng: position.coords.longitude
			//			};
			//			var circle = new google.maps.Circle(
			//				{center: geolocation, radius: position.coords.accuracy}
			//			);
			//			autocomplete_global.setBounds(circle.getBounds());
			//		});
			//	}
			//}
		</script>
		<!--<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo get_option( 'equine_google_place_api_key' ); ?>&libraries=places" async defer></script>-->