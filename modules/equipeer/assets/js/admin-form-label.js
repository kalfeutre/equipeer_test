/* ---------------------------------------------- */
/* ---------------------------------------------- */
/*       CHANGE LABELS TEXT AND VISIBLITY         */
/* ---------------------------------------------- */
/* ---------------------------------------------- */

jQuery(window).on( 'load', function(event) {
	// Cancel the default action (navigation) of the click
	event.preventDefault();
	// Change LABELS Text and VISIBILITY
	equipeer_label_text();
});

jQuery(function($) {
	jQuery("select#discipline").on('change', function(e) {
		// Cancel the default action (navigation) of the click
		e.preventDefault();
		// Check if DISCIPLINE Select get a value
		if ( $( '#discipline' ).val() > 0 ) {
			var choice = confirm("Vous souhaitez changer de discipline ?");
			if (choice === true) equipeer_label_text();
		}
	});
});

function equipeer_label_text() {
	var equitab = {};
	var equitab_discipline = '';
	var discipline = jQuery( '#discipline' ).val();
	
	//console.log('Discipline: '+discipline);

	//equitab = equipeer_i18n_taxonomy( discipline );
	
	switch( discipline ) {
		case "35": // Autres
			equitab_discipline = 'AUTRES';
			equitab = {
				// PLAT
				equipeer_aptitudes_plat: "Aptitudes sportives : Monté sur le plat", // Metabox TITLE
				plat_souplesse: 'Souplesse',
				plat_sang: 'Sang',
				plat_disponibilite: 'Disponibilité',
				plat_bouche: 'Bouche',
				plat_confort: 'Confort cavalier',
				plat_caractere: 'Caractère',
				plat_stabilite: 'Stabilité',
				// OBSTACLES
				equipeer_aptitudes_obstacle: "Aptitudes sportives : Monté à l'obstacle", // Metabox TITLE
				obstacle_caractere: 'Caractère',
				obstacle_disponibilite: 'Disponibilité',
				obstacle_equilibre: 'Equilibre',
				obstacle_style: 'Style',
				obstacle_experience: 'Expérience',
				obstacle_stabilite: 'Stabilité',
				obstacle_7: '',
				obstacle_8: '',
				// QUALITE SAUT
				equipeer_aptitudes_saut: "Aptitudes sportives : Qualité de saut", // Metabox TITLE
				saut_envergure: 'Envergure',
				saut_moyen: 'Moyens',
				saut_style: 'Style',
				saut_equilibre: 'Equilibre',
				saut_intelligence: 'Intelligence',
				saut_respect: 'Respect',
				saut_7: '',
				saut_8: '',
				saut_9: '',
				saut_10: '',
				saut_11: '',
				saut_12: '',
				// RESULTATS EN COMPETITION
				competition_100: 'Classé 100',
				competition_110: 'Classé 110',
				competition_115: 'Classé 115',
				competition_120: 'Classé 120',
				competition_130: 'Classé 130',
				competition_135: 'Classé 135',
				competition_140: 'Classé 140',
				competition_140_plus: 'Classé 140 et +',
				competition_9: '',
				// DESCRIPTIF DETAILLE
				descriptif_detail_1: '',
				descriptif_detail_2: '',
				modele: 'Modèle : avant­-main, dos, arrière main',
				aplomb: 'Aplombs : antérieurs, postérieurs',
				allure: 'Qualité des allures : pas, trot, galop',
				comportement: 'Comportement : à l\'écurie, à pied, au transport, en longe, caractère général',
			};
		break;
		case "31": // CCE
			equitab_discipline = 'CCE';
			equitab = {
				// PLAT
				equipeer_aptitudes_plat: "Aptitudes sportives : Monté sur le plat", // Metabox TITLE
				plat_souplesse: 'Souplesse',
				plat_sang: 'Sang',
				plat_disponibilite: 'Disponibilité',
				plat_bouche: 'Bouche',
				plat_confort: 'Confort cavalier',
				plat_caractere: 'Caractère',
				plat_stabilite: 'Stabilité',
				// OBSTACLES
				equipeer_aptitudes_obstacle: "Aptitudes sportives : Monté à l'obstacle", // Metabox TITLE
				obstacle_caractere: 'Caractère',
				obstacle_disponibilite: 'Disponibilité',
				obstacle_equilibre: 'Equilibre',
				obstacle_style: 'Style',
				obstacle_experience: 'Expérience',
				obstacle_stabilite: 'Stabilité',
				obstacle_7: '',
				obstacle_8: '',
				// QUALITE SAUT
				equipeer_aptitudes_saut: "Aptitudes sportives : Qualité de saut", // Metabox TITLE
				saut_envergure: 'Envergure',
				saut_moyen: 'Moyens',
				saut_style: 'Style',
				saut_equilibre: 'Equilibre',
				saut_intelligence: 'Intelligence',
				saut_respect: 'Respect',
				saut_7: '',
				saut_8: '',
				saut_9: '',
				saut_10: '',
				saut_11: '',
				saut_12: '',
				// RESULTATS EN COMPETITION
				competition_100: 'Classé 100',
				competition_110: 'Classé 110',
				competition_115: 'Classé 115',
				competition_120: 'Classé 120',
				competition_130: 'Classé 130',
				competition_135: 'Classé 135',
				competition_140: 'Classé 140',
				competition_140_plus: 'Classé 140 et +',
				competition_9: '',
				// DESCRIPTIF DETAILLE
				descriptif_detail_1: '',
				descriptif_detail_2: '',
				modele: 'Modèle : avant­-main, dos, arrière main',
				aplomb: 'Aplombs : antérieurs, postérieurs',
				allure: 'Qualité des allures : pas, trot, galop',
				comportement: 'Comportement : à l\'écurie, à pied, au transport, en longe, caractère général',
			};
		break;
		case "30": // Dressage
			equitab_discipline = 'DRESSAGE';
			equitab = {
				// PLAT
				equipeer_aptitudes_plat: "Aptitudes sportives : Qualité des allures", // Metabox TITLE
				plat_souplesse: 'Pas - Rassemblé',
				plat_sang: 'Pas - Allongé',
				plat_disponibilite: 'Trot - Travail',
				plat_bouche: 'Trot - Allongé',
				plat_confort: 'Galop - Travail',
				plat_caractere: 'Galop - Allongé',
				plat_stabilite: '',
				// OBSTACLES
				equipeer_aptitudes_obstacle: "Aptitudes sportives : Qualité au travail", // Metabox TITLE
				obstacle_caractere: 'Souplesse',
				obstacle_disponibilite: 'Sang',
				obstacle_equilibre: 'Bouche',
				obstacle_style: 'Confort cavalier',
				obstacle_experience: 'Stabilité (mise en main)',
				obstacle_stabilite: 'Soumission (facilité d\'utilisation)',
				obstacle_7: 'Equilibre',
				obstacle_8: 'Rebond et amplitude',
				// QUALITE SAUT
				equipeer_aptitudes_saut: "Aptitudes sportives : Mouvements acquis", // Metabox TITLE
				saut_envergure: 'Arrêt',
				saut_moyen: 'Reculé',
				saut_style: 'Épaule en dedans',
				saut_equilibre: 'Appuyé',
				saut_intelligence: 'Changement de pied - Ferme à ferme',
				saut_respect: 'Changement de pied - Isolé',
				saut_7: 'Changement de pied - Lignes',
				saut_8: 'Galop à faux',
				saut_9: 'Appuyés au galop',
				saut_10: 'Pirouettes',
				saut_11: 'Passage',
				saut_12: 'Piaffé',
				// RESULTATS EN COMPETITION
				competition_100: 'Amateur 3',
				competition_110: 'Amateur 2',
				competition_115: 'Amateur 1',
				competition_120: 'Amateur Élite',
				competition_130: 'Pro 3',
				competition_135: 'Pro 2',
				competition_140: 'Pro 1',
				competition_140_plus: 'Pro Élite',
				competition_9: 'International',
				// DESCRIPTIF DETAILLE
				descriptif_detail_1: 'Type de ferrure',
				descriptif_detail_2: 'Type d\'embouchure',
				modele: 'Modèle : avant­-main, dos, arrière main',
				aplomb: 'Aplombs : antérieurs, postérieurs',
				allure: 'Comportement : à l\'écurie, à pied, transport, longe, paddock, tonte, extérieur, travail',
				comportement: 'Caractère général',
			};
		break;
		case "32": // Endurance
			equitab_discipline = 'ENDURANCE';
			equitab = {
				// PLAT
				equipeer_aptitudes_plat: "Aptitudes sportives : Monté sur le plat", // Metabox TITLE
				plat_souplesse: 'Souplesse',
				plat_sang: 'Sang',
				plat_disponibilite: 'Disponibilité',
				plat_bouche: 'Bouche',
				plat_confort: 'Confort cavalier',
				plat_caractere: 'Caractère',
				plat_stabilite: 'Stabilité',
				// OBSTACLES
				equipeer_aptitudes_obstacle: "Aptitudes sportives : Monté à l'obstacle", // Metabox TITLE
				obstacle_caractere: 'Caractère',
				obstacle_disponibilite: 'Disponibilité',
				obstacle_equilibre: 'Equilibre',
				obstacle_style: 'Style',
				obstacle_experience: 'Expérience',
				obstacle_stabilite: 'Stabilité',
				obstacle_7: '',
				obstacle_8: '',
				// QUALITE SAUT
				equipeer_aptitudes_saut: "Aptitudes sportives : Qualité de saut", // Metabox TITLE
				saut_envergure: 'Envergure',
				saut_moyen: 'Moyens',
				saut_style: 'Style',
				saut_equilibre: 'Equilibre',
				saut_intelligence: 'Intelligence',
				saut_respect: 'Respect',
				saut_7: '',
				saut_8: '',
				saut_9: '',
				saut_10: '',
				saut_11: '',
				saut_12: '',
				// RESULTATS EN COMPETITION
				competition_100: 'Classé 100',
				competition_110: 'Classé 110',
				competition_115: 'Classé 115',
				competition_120: 'Classé 120',
				competition_130: 'Classé 130',
				competition_135: 'Classé 135',
				competition_140: 'Classé 140',
				competition_140_plus: 'Classé 140 et +',
				competition_9: '',
				// DESCRIPTIF DETAILLE
				descriptif_detail_1: '',
				descriptif_detail_2: '',
				modele: 'Modèle : avant­-main, dos, arrière main',
				aplomb: 'Aplombs : antérieurs, postérieurs',
				allure: 'Qualité des allures : pas, trot, galop',
				comportement: 'Comportement : à l\'écurie, à pied, au transport, en longe, caractère général',
			};
		break;
		case "33": // Hunter
			equitab_discipline = 'HUNTER';
			equitab = {
				// PLAT
				equipeer_aptitudes_plat: "Aptitudes sportives : Monté sur le plat", // Metabox TITLE
				plat_souplesse: 'Souplesse',
				plat_sang: 'Sang',
				plat_disponibilite: 'Disponibilité',
				plat_bouche: 'Bouche',
				plat_confort: 'Confort cavalier',
				plat_caractere: 'Caractère',
				plat_stabilite: 'Stabilité',
				// OBSTACLES
				equipeer_aptitudes_obstacle: "Aptitudes sportives : Monté à l'obstacle", // Metabox TITLE
				obstacle_caractere: 'Caractère',
				obstacle_disponibilite: 'Disponibilité',
				obstacle_equilibre: 'Equilibre',
				obstacle_style: 'Style',
				obstacle_experience: 'Expérience',
				obstacle_stabilite: 'Stabilité',
				obstacle_7: '',
				obstacle_8: '',
				// QUALITE SAUT
				equipeer_aptitudes_saut: "Aptitudes sportives : Qualité de saut", // Metabox TITLE
				saut_envergure: 'Envergure',
				saut_moyen: 'Moyens',
				saut_style: 'Style',
				saut_equilibre: 'Equilibre',
				saut_intelligence: 'Intelligence',
				saut_respect: 'Respect',
				saut_7: '',
				saut_8: '',
				saut_9: '',
				saut_10: '',
				saut_11: '',
				saut_12: '',
				// RESULTATS EN COMPETITION
				competition_100: 'Classé 100',
				competition_110: 'Classé 110',
				competition_115: 'Classé 115',
				competition_120: 'Classé 120',
				competition_130: 'Classé 130',
				competition_135: 'Classé 135',
				competition_140: 'Classé 140',
				competition_140_plus: 'Classé 140 et +',
				competition_9: '',
				// DESCRIPTIF DETAILLE
				descriptif_detail_1: '',
				descriptif_detail_2: '',
				modele: 'Modèle : avant­-main, dos, arrière main',
				aplomb: 'Aplombs : antérieurs, postérieurs',
				allure: 'Qualité des allures : pas, trot, galop',
				comportement: 'Comportement : à l\'écurie, à pied, au transport, en longe, caractère général',
			};
		break;
		case "34": // Western
			equitab_discipline = 'WESTERN';
			equitab = {
				// PLAT
				equipeer_aptitudes_plat: "Aptitudes sportives : Monté sur le plat", // Metabox TITLE
				plat_souplesse: 'Souplesse',
				plat_sang: 'Sang',
				plat_disponibilite: 'Disponibilité',
				plat_bouche: 'Bouche',
				plat_confort: 'Confort cavalier',
				plat_caractere: 'Caractère',
				plat_stabilite: 'Stabilité',
				// OBSTACLES
				equipeer_aptitudes_obstacle: "Aptitudes sportives : Monté à l'obstacle", // Metabox TITLE
				obstacle_caractere: 'Caractère',
				obstacle_disponibilite: 'Disponibilité',
				obstacle_equilibre: 'Equilibre',
				obstacle_style: 'Style',
				obstacle_experience: 'Expérience',
				obstacle_stabilite: 'Stabilité',
				obstacle_7: '',
				obstacle_8: '',
				// QUALITE SAUT
				equipeer_aptitudes_saut: "Aptitudes sportives : Qualité de saut", // Metabox TITLE
				saut_envergure: 'Envergure',
				saut_moyen: 'Moyens',
				saut_style: 'Style',
				saut_equilibre: 'Equilibre',
				saut_intelligence: 'Intelligence',
				saut_respect: 'Respect',
				saut_7: '',
				saut_8: '',
				saut_9: '',
				saut_10: '',
				saut_11: '',
				saut_12: '',
				// RESULTATS EN COMPETITION
				competition_100: 'Classé 100',
				competition_110: 'Classé 110',
				competition_115: 'Classé 115',
				competition_120: 'Classé 120',
				competition_130: 'Classé 130',
				competition_135: 'Classé 135',
				competition_140: 'Classé 140',
				competition_140_plus: 'Classé 140 et +',
				competition_9: '',
				// DESCRIPTIF DETAILLE
				descriptif_detail_1: '',
				descriptif_detail_2: '',
				modele: 'Modèle : avant­-main, dos, arrière main',
				aplomb: 'Aplombs : antérieurs, postérieurs',
				allure: 'Qualité des allures : pas, trot, galop',
				comportement: 'Comportement : à l\'écurie, à pied, au transport, en longe, caractère général',
			};
		break;
		case "28": // CSO
			equitab_discipline = 'CSO';
			equitab = {
				// PLAT
				equipeer_aptitudes_plat: "Aptitudes sportives : Monté sur le plat", // Metabox TITLE
				plat_souplesse: 'Souplesse',
				plat_sang: 'Sang',
				plat_disponibilite: 'Disponibilité',
				plat_bouche: 'Bouche',
				plat_confort: 'Confort cavalier',
				plat_caractere: 'Caractère',
				plat_stabilite: 'Stabilité',
				// OBSTACLES
				equipeer_aptitudes_obstacle: "Aptitudes sportives : Monté à l'obstacle", // Metabox TITLE
				obstacle_caractere: 'Caractère',
				obstacle_disponibilite: 'Disponibilité',
				obstacle_equilibre: 'Equilibre',
				obstacle_style: 'Style',
				obstacle_experience: 'Expérience',
				obstacle_stabilite: 'Stabilité',
				obstacle_7: '',
				obstacle_8: '',
				// QUALITE SAUT
				equipeer_aptitudes_saut: "Aptitudes sportives : Qualité de saut", // Metabox TITLE
				saut_envergure: 'Envergure',
				saut_moyen: 'Moyens',
				saut_style: 'Style',
				saut_equilibre: 'Equilibre',
				saut_intelligence: 'Intelligence',
				saut_respect: 'Respect',
				saut_7: '',
				saut_8: '',
				saut_9: '',
				saut_10: '',
				saut_11: '',
				saut_12: '',
				// RESULTATS EN COMPETITION
				competition_100: 'Classé 100',
				competition_110: 'Classé 110',
				competition_115: 'Classé 115',
				competition_120: 'Classé 120',
				competition_130: 'Classé 130',
				competition_135: 'Classé 135',
				competition_140: 'Classé 140',
				competition_140_plus: 'Classé 140 et +',
				competition_9: '',
				// DESCRIPTIF DETAILLE
				descriptif_detail_1: '',
				descriptif_detail_2: '',
				modele: 'Modèle : avant­-main, dos, arrière main',
				aplomb: 'Aplombs : antérieurs, postérieurs',
				allure: 'Qualité des allures : pas, trot, galop',
				comportement: 'Comportement : à l\'écurie, à pied, au transport, en longe, caractère général',
			};
		break;
		default: // CSO if nothing
			equitab_discipline = 'INCONNUE';
			equitab = {
				// PLAT
				equipeer_aptitudes_plat: "Aptitudes sportives : Monté sur le plat", // Metabox TITLE
				plat_souplesse: 'Souplesse',
				plat_sang: 'Sang',
				plat_disponibilite: 'Disponibilité',
				plat_bouche: 'Bouche',
				plat_confort: 'Confort cavalier',
				plat_caractere: 'Caractère',
				plat_stabilite: 'Stabilité',
				// OBSTACLES
				equipeer_aptitudes_obstacle: "Aptitudes sportives : Monté à l'obstacle", // Metabox TITLE
				obstacle_caractere: 'Caractère',
				obstacle_disponibilite: 'Disponibilité',
				obstacle_equilibre: 'Equilibre',
				obstacle_style: 'Style',
				obstacle_experience: 'Expérience',
				obstacle_stabilite: 'Stabilité',
				obstacle_7: '',
				obstacle_8: '',
				// QUALITE SAUT
				equipeer_aptitudes_saut: "Aptitudes sportives : Qualité de saut", // Metabox TITLE
				saut_envergure: 'Envergure',
				saut_moyen: 'Moyens',
				saut_style: 'Style',
				saut_equilibre: 'Equilibre',
				saut_intelligence: 'Intelligence',
				saut_respect: 'Respect',
				saut_7: '',
				saut_8: '',
				saut_9: '',
				saut_10: '',
				saut_11: '',
				saut_12: '',
				// RESULTATS EN COMPETITION
				competition_100: 'Classé 100',
				competition_110: 'Classé 110',
				competition_115: 'Classé 115',
				competition_120: 'Classé 120',
				competition_130: 'Classé 130',
				competition_135: 'Classé 135',
				competition_140: 'Classé 140',
				competition_140_plus: 'Classé 140 et +',
				competition_9: '',
				// DESCRIPTIF DETAILLE
				descriptif_detail_1: '',
				descriptif_detail_2: '',
				modele: 'Modèle : avant­-main, dos, arrière main',
				aplomb: 'Aplombs : antérieurs, postérieurs',
				allure: 'Qualité des allures : pas, trot, galop',
				comportement: 'Comportement : à l\'écurie, à pied, au transport, en longe, caractère général',
			};
		break;
	}

	// Change LABELS TEXT
	if (equitab) {
		for( var key in equitab ) {
			// Debug CONSOLE
			//console.log( 'Key: '+key+' = '+equitab[key] );
			// Check if key is a TITLE
			var res = key.split("_");
			if (res[0] == 'equipeer') {
				// Change Metabox TITLE
				jQuery( '#'+key.replace(/_/g, "-")+' h2 span' ).text( equitab[key] );
			} else {
				// Check if block is visible
				var display_value = (equitab[key] === '') ? 'none' : 'block';
				jQuery( '#block_'+key+' label' ).text( equitab[key] );
				jQuery( '#block_'+key ).css( 'display', display_value );
			}
		}
	}
}