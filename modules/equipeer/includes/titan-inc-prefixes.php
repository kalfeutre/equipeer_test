<?php
/**
 * Blocking direct access to plugin
 */
defined('ABSPATH') or die('Are you crazy!');

$all_types = equipeer_get_all_type_horses(); // name, value
if ($all_types) {
	foreach( $all_types as $type ) {
		// ---------------------------------------------
		if ($type['value'] == 'horse') {
			$prefixes->createOption( array(
				'name' => 'Discipline pour ' . __( $type['name'], EQUIPEER_ID ),
				'type' => 'heading'
			) );
		}
		// ---------------------------------------------
		switch($type['value']) {
			case "horse":
				$prefixes->createOption( array(
					  'name'    => 'Autres',
					  'id'      => 'discipline_'.$type['value'].'_prefix_35',
					  'type'    => 'text',
					  'desc'    => '',
					  'default' => 'AU'
				) );
				// ---------------------------------------------
				$prefixes->createOption( array(
					  'name'    => 'CCE',
					  'id'      => 'discipline_'.$type['value'].'_prefix_31',
					  'type'    => 'text',
					  'desc'    => '',
					  'default' => 'CE'
				) );
				// ---------------------------------------------
				$prefixes->createOption( array(
					  'name'    => 'CSO',
					  'id'      => 'discipline_'.$type['value'].'_prefix_28',
					  'type'    => 'text',
					  'desc'    => '',
					  'default' => 'SO'
				) );
				// ---------------------------------------------
				$prefixes->createOption( array(
					  'name'    => 'Dressage',
					  'id'      => 'discipline_'.$type['value'].'_prefix_30',
					  'type'    => 'text',
					  'desc'    => '',
					  'default' => 'DR'
				) );
				// ---------------------------------------------
				$prefixes->createOption( array(
					  'name'    => 'Endurance',
					  'id'      => 'discipline_'.$type['value'].'_prefix_32',
					  'type'    => 'text',
					  'desc'    => '',
					  'default' => 'EN'
				) );
				// ---------------------------------------------
				$prefixes->createOption( array(
					  'name'    => 'Hunter',
					  'id'      => 'discipline_'.$type['value'].'_prefix_33',
					  'type'    => 'text',
					  'desc'    => '',
					  'default' => 'AU'
				) );
				// ---------------------------------------------
				$prefixes->createOption( array(
					  'name'    => 'Western',
					  'id'      => 'discipline_'.$type['value'].'_prefix_34',
					  'type'    => 'text',
					  'desc'    => '',
					  'default' => 'WE'
				) );
				// ---------------------------------------------
			break;
			case "pony":
				//$prefixes->createOption( array(
				//	'type' => 'note',
				//	'desc' => 'Pas de discipline pour le moment ;-)'
				//) );
			break;
		}
	}
}