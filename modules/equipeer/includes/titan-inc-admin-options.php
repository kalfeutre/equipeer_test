<?php
/**
 * Blocking direct access to plugin
 */
defined('ABSPATH') or die('Are you crazy!');

// =============================================
//                    APIs
// =============================================
$admin_options->createOption( array(
    'name'    => "Autoriser à voir tous les médias dans l'ajout/modification d'une annonce",
    'id'      => 'ads_enable_all_medias',
    'type'    => 'enable',
    'default' => false,
    'desc'    => 'Default: Disabled',
) );

?>