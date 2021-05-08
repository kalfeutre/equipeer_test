<?php
/**
 * Blocking direct access to plugin
 */
defined('ABSPATH') or die('Are you crazy!');

// =============================================
//                    APIs
// =============================================
$options->createOption( array(
    'name' => '<img src="'.EQUIPEER_URL.'assets/images/icon-google-place.png" style="float: left; width: 32px; margin-right: 1em;"><span class="equipeer-blue">APIs</span>',
    'type' => 'heading',
) );
$options->createOption( array(
	'name' => 'Google Place Autocomplete',
	'id'   => 'google_place_api_key',
	'type' => 'text',
	'desc' => 'Renseignez votre clé API Google Place'
) );
// =============================================
//                 COMMISSIONS
// =============================================
$options->createOption( array(
    'name' => '<img src="'.EQUIPEER_URL.'assets/images/icon-commission.png" style="float: left; width: 32px; margin-right: 1em;"><span class="equipeer-blue">Commissions</span>',
    'type' => 'heading',
) );
$options->createOption( array(
    'name'    => 'Annonce libre (%)',
    'id'      => 'commission_annonce_libre',
    'type'    => 'number',
    'desc'    => '',
    'default' => '10',
    'max'     => '100',
	'step'    => '1'
) );
$options->createOption( array(
    'name'    => 'Annonce expertisée (%)',
    'id'      => 'commission_annonce_expertise',
    'type'    => 'number',
    'desc'    => '',
    'default' => '15',
    'max'     => '100',
	'step'    => '1'
) );
// =============================================
//              TRANCHE DE PRIX
// =============================================
$options->createOption( array(
    'name' => '<img src="'.EQUIPEER_URL.'assets/images/icon-equine.png" style="float: left; width: 32px; margin-right: 1em;"><span class="equipeer-blue">Tranche de prix</span>',
    'type' => 'heading',
) );
// Range START
$options->createOption( array(
    'name'    => 'Prix de départ',
    'id'      => 'range_start',
    'type'    => 'number',
    'desc'    => '',
    'default' => '8000',
	'min'     => '1000',
    'max'     => '10000',
	'step'    => '1000'
) );
// Range 1 UNTIL
$options->createOption( array(
    'name'    => 'Tranche <strong class="equipeer-red">€</strong>€€€€<br><span class="range_start">0</span> à <span class="range_1_until">0</span>€',
    'id'      => 'range_1_until',
    'type'    => 'number',
    'desc'    => '',
    'default' => '15000',
	'min'     => '8000',
    'max'     => '30000',
	'step'    => '1000'
) );
// Range 2 UNTIL
$options->createOption( array(
    'name'    => 'Tranche <strong class="equipeer-red">€€</strong>€€€<br><span class="range_1_until">0</span> à <span class="range_2_until">0</span>€',
    'id'      => 'range_2_until',
    'type'    => 'number',
    'desc'    => '',
    'default' => '30000',
	'min'     => '15000',
    'max'     => '50000',
	'step'    => '1000'
) );
// Range 3 UNTIL
$options->createOption( array(
    'name'    => 'Tranche <strong class="equipeer-red">€€€</strong>€€<br><span class="range_2_until">0</span> à <span class="range_3_until">0</span>€',
    'id'      => 'range_3_until',
    'type'    => 'number',
    'desc'    => '',
    'default' => '50000',
	'min'     => '30000',
    'max'     => '70000',
	'step'    => '1000'
) );
// Range 4 UNTIL
$options->createOption( array(
    'name'    => 'Tranche <strong class="equipeer-red">€€€€</strong>€<br><span class="range_3_until">0</span> à <span class="range_4_until">0</span>€<br>Tranche <strong class="equipeer-red">€€€€€</strong><br>> à <span class="range_4_until">0</span>€',
    'id'      => 'range_4_until',
    'type'    => 'number',
    'desc'    => '',
    'default' => '80000',
	'min'     => '50000',
    'max'     => '150000',
	'step'    => '1000'
) );

?>