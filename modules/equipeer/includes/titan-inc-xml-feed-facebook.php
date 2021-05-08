<?php
/**
 * Blocking direct access to plugin
 */
defined('ABSPATH') or die('Are you crazy!');

// =============================================
//                 AJAX Action
// =============================================
$xml_feed->createOption( array(
    'name'       => 'G&eacute;n&eacute;rer votre catalogue<br><span style="color: gray; font-weight: normal;" class="description">Flux XML Facebook</span>',
    'type'       => 'ajax-button',
    'action'     => 'generate_xml_feed_fb',
    'label'      => 'G&eacute;n&eacute;rer manuellement',
	'wait_label' => 'En cours de génération...',
	'class'      => array( 'button-primary' )
) );

// =============================================
//                     CRON
// =============================================
$schedules        = wp_get_schedules();
$eq_feed_schedule = wp_get_schedule( 'equipeer_xml_feed_fb' );
// ---------------------------------------------
$eq_feed_infos = [];
$eq_feed_infos['interval'] = $schedules[ $eq_feed_schedule ][ 'interval' ];
$eq_feed_infos['display']  = $schedules[ $eq_feed_schedule ][ 'display' ];
// ---------------------------------------------
$xml_feed->createOption( array(
    'name' => '<span class="dashicons dashicons-admin-settings"></span>&nbsp;Cron',
    'type' => 'heading',
) );
$xml_feed->createOption( array(
	'name' => 'R&eacute;currence',
    'type' => 'note',
    'desc' => "Votre cron (tâche planifi&eacute;e) cr&eacute;e votre fichier en automatique et sera ex&eacute;cut&eacute; &agrave; cette fr&eacute;quence : <strong>".$eq_feed_infos['display']." ($eq_feed_schedule)</strong>.<br><a target='_blank' href='".admin_url()."tools.php?page=crontrol_admin_manage_page'>Cliquer ici</a> si vous souhaitez en modifier sa fr&eacute;quence.<br><u>Hook Name:</u> <strong style='color: maroon;'>equipeer_xml_feed_fb</strong>"
) );

// =============================================
//            Param&egrave;tres (Fichier)
// =============================================
//$xml_feed->createOption( array(
//    'name' => '<span class="dashicons dashicons-admin-generic"></span>&nbsp;Param&egrave;tres fichier XML',
//    'type' => 'heading',
//) );
//$xml_feed->createOption( array(
//    'name'    => 'Tri des annonces',
//    'id'      => 'xml_feed_sorted',
//    'options' => array(
//        'date'     => 'Date de cr&eacute;ation',
//        'modified' => 'Date de modification',
//    ),
//    'type'    => 'radio',
//    'desc'    => '',
//    'default' => 'date',
//) );
//$xml_feed->createOption( array(
//      'name'    => 'Nom du fichier',
//      'id'      => 'xml_feed_filename',
//      'type'    => 'text',
//	  'default' => 'equipeer_catalog_feed.xml',
//      'desc'    => 'Ex: equipeer_catalog_feed.xml<br><span style="color: maroon">Ne modifier cette information que si vous êtes certains de savoir ce que vous faites !</span>'
//) );

// =============================================
//               Param&egrave;tres (FB)
// =============================================
$xml_feed->createOption( array(
    'name' => '<span class="dashicons dashicons-facebook"></span>&nbsp;Param&egrave;tres FB',
    'type' => 'heading',
) );
$xml_feed->createOption( array(
	'name' => 'Utiles',
    'type' => 'note',
    'desc' => "<strong>Facebook catalog API Marketing</strong> : <a href='https://developers.facebook.com/docs/marketing-api/dynamic-product-ads/product-catalog/' target='_blank'>https://developers.facebook.com/docs/marketing-api/dynamic-product-ads/product-catalog/</a><br>
		<strong>Configuration de l'app</strong> : <a href='https://developers.facebook.com' target='_blank'>https://developers.facebook.com</a><br>
		<strong>Product feed debug</strong> : <a href='https://business.facebook.com/ads/product_feed/debug/' target='_blank'>https://business.facebook.com/ads/product_feed/debug/</a><br>
		<strong>Product taxonomy</strong> : <a href='https://www.google.com/basepages/producttype/taxonomy-with-ids.en-US.txt' target='_blank'>https://www.google.com/basepages/producttype/taxonomy-with-ids.en-US.txt</a>"
) );
//$xml_feed->createOption( array(
//      'name'    => 'Facebook Business Manager',
//      'id'      => 'xml_feed_facebook_business_manager',
//      'type'    => 'text',
//	  'default' => '459400684473729',
//      'desc'    => ''
//) );
//$xml_feed->createOption( array(
//      'name'    => 'Facebook Pixel ID',
//      'id'      => 'xml_feed_facebook_pixel_id',
//      'type'    => 'text',
//	  'default' => '482367365547015',
//      'desc'    => ''
//) );
//$xml_feed->createOption( array(
//      'name'    => 'Facebook App ID',
//      'id'      => 'xml_feed_facebook_app_id',
//      'type'    => 'text',
//	  'default' => '2379453535408567',
//      'desc'    => ''
//) );
//$xml_feed->createOption( array(
//      'name'    => 'Facebook Secret Key',
//      'id'      => 'xml_feed_facebook_secret',
//      'type'    => 'text',
//	  'default' => '9fcf61e2b009d90e2d3dbc2c1c4a0062',
//      'desc'    => ''
//) );
//$xml_feed->createOption( array(
//      'name'    => 'Facebook Token',
//      'id'      => 'xml_feed_facebook_token',
//      'type'    => 'text',
//	  'default' => 'd5d82a099b241c65956b0245b1e74fc1',
//      'desc'    => ''
//) );

// =============================================
//                AJAX FUNCTION
// =============================================
add_action( 'wp_ajax_generate_xml_feed_fb', 'equipeer_generate_xml_feed_fb' );
function equipeer_generate_xml_feed_fb() {
    global $wpdb;
	// Generate XML FEED
	$generate_feed = Equipeer_Cron::xml_feed_fb();
	// Check RESULT
    if ( $generate_feed ) {
        wp_send_json_success( __( 'Fichier généré avec succès', 'default' ) );
    }
    wp_send_json_error( __( 'Erreur lors de la génération du fichier !!!', 'default' ) );
}

?>