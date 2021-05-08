<?php
/**
 * Blocking direct access to plugin
 */
defined('ABSPATH') or die('Are you crazy!');

$helpers->createOption( array(
	'name' => "<p>Liens <strong>AIDE</strong> du plugin Equidés: <a href='#add_equine'>Ajouter un équidé</a> · <a href='#edit_equine'>Modifier un équidé</a> · <a href='#email_equine'>Emails</a> · <a href='#faq_equine'>FAQs</a> · <a href='#link_equine'>Liens</a></p>",
	'type' => 'heading',
) );

$helpers->createOption( array(
	'type' => 'note',
	'name' => 'Aide du plugin <span class="equipeer-admin-color">ÉQUIDÉS</span><br><img style="margin-top: 1em;" src="'.EQUIPEER_URL.'assets/images/helper-2.jpg">',
	'desc' => '<img style="max-width: 100%; width: 100%;" src="'.EQUIPEER_URL.'assets/images/helper-1.jpg">'
) );

$helpers->createOption( array(
	'name'    => "Contenu de l'aide<br><span id='add_equine' class='equipeer-admin-color'>Ajouter un équidé</span>",
	'id'      => 'helper_add_new_equine_content',
	'type'    => 'editor',
	'desc'    => '',
	'default' => '',
) );

$helpers->createOption( array(
	'name'    => "Contenu de l'aide<br><span id='edit_equine' class='equipeer-admin-color'>Modifier un équidé</span>",
	'id'      => 'helper_edit_equine_content',
	'type'    => 'editor',
	'desc'    => '',
	'default' => '',
) );

$helpers->createOption( array(
	'name'    => "Contenu de l'aide<br><span id='edit_equine' class='equipeer-admin-color'>Catégories (Taxonomies)</span>",
	'id'      => 'helper_taxonomies_equine_content',
	'type'    => 'editor',
	'desc'    => '',
	'default' => '',
) );

$helpers->createOption( array(
	'name'    => "Contenu de l'aide<br><span id='email_equine' class='equipeer-admin-color'>Emails</span>",
	'id'      => 'helper_email_equine_content',
	'type'    => 'editor',
	'desc'    => '',
	'default' => '',
) );

$helpers->createOption( array(
	'name'    => "Contenu de l'aide<br><span id='faq_equine' class='equipeer-admin-color'>FAQ</span>",
	'id'      => 'helper_faq_equine_content',
	'type'    => 'editor',
	'desc'    => '',
	'default' => '',
) );

$helpers->createOption( array(
	'name'    => "Contenu de l'aide<br><span id='link_equine' class='equipeer-admin-color'>Liens</span>",
	'id'      => 'helper_link_equine_content',
	'type'    => 'editor',
	'desc'    => '',
	'default' => '',
) );

?>