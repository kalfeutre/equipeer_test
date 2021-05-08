<?php
// ---------------------------------------
$get_site_url             = get_site_url();
$get_bloginfo_name        = trim( get_bloginfo( 'name' ) );
$get_bloginfo_description = (ICL_LANGUAGE_CODE == 'fr') ? trim( get_bloginfo( 'description' ) ) : trim( get_option( 'equine_bloginfo_slogan_en' ) );
$get_equipeer_slug        = Equipeer()->slug;
// ---------------------------------------

// ---------------------------------------
// ---------------------------------------
// ---------------------------------------
// --- BREADCRUMB
// ---------------------------------------
// ---------------------------------------
// ---------------------------------------
?>
<div class="container">
	<div class="row">
		<div class="col col-sm-12">
			<nav class="" aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?php echo $get_site_url; ?>"><?php echo $get_bloginfo_name; ?></a></li>
					<li class="breadcrumb-item"><a href="<?php echo $get_site_url . '/' . $get_equipeer_slug; ?>"><?php echo $get_bloginfo_description; ?></a></li>
				</ol>
			</nav>
			<!-- ===== BREADCRUMB (JSON) ===== -->
			<script type="application/ld+json">
				{
					"@context": "http://schema.org",
					"@type": "BreadcrumbList",
					"itemListElement":
						[{
							"@type": "ListItem",
							"position": 1,
							"item": {
								"@id": "<?php echo $get_site_url; ?>",
								"name": "<?php echo $get_bloginfo_name; ?>"
							}
						},
						{
							"@type": "ListItem",
							"position": 2,
							"item": {
								"@id": "<?php echo $get_site_url . '/' . $get_equipeer_slug; ?>",
								"name": "<?php echo $get_bloginfo_description; ?>"
							}
						}
					]
				}
			</script>
		</div>
	</div>
</div>