<?php
/**
 * Blocking direct access to plugin
 */
defined('ABSPATH') or die('Are you crazy!');

$email->createOption( array(
	'name'    => 'Email admin EQUIPEER (Contact client)',
	'id'      => 'email_admin',
	'type'    => 'text',
	'desc'    => sprintf( "S'il n'est pas rempli, l'email d'administration par défaut de Wordpress sera utilisé à la place : %s", get_option('admin_email') ) . '<br>Vous pouvez ajouter plusieurs adresses emails en les séparant par des virgules.',
	'default' => get_option('admin_email')
) );

//$email->createOption( array(
//	'name'    => 'Email(s) admin EQUIPEER (Formulaires de recherche - résultat à 0)',
//	'id'      => 'email_admin_search',
//	'type'    => 'text',
//	'desc'    => sprintf( "S'il n'est pas rempli, l'email d'administration par défaut de Wordpress sera utilisé à la place : %s", get_option('admin_email') ) . '<br>Vous pouvez ajouter plusieurs adresses emails en les séparant par des virgules.',
//	'default' => get_option('admin_email')
//) );

?>