<?php
/**
 * Blocking direct access to plugin
 */
defined('ABSPATH') or die('Are you crazy!');

/**
 * Return translated text using dictionary attached
 * French to English only
 *
 * @param	$text		Text to translate
 *
 * @return string
 */
if (!function_exists("eq_translate")) {
	function eq_translate($text, $force_translate = false) {
		// ----------------------------------------
		// Check language
		// ----------------------------------------
		if (ICL_LANGUAGE_CODE == 'fr' && $force_translate) return $text;
		// ----------------------------------------
		// Include once translated strings
		// ----------------------------------------
		// Messages for FR to EN (PERMALINK ONLY)
		// String Characters FR:
		// - without accent 
		// - without space, without punctuation (replacement by -)
		// - ! required: in lower case
		// ----------------------------------------
		$eqDicts = array(
			// Categories
			 'cso' => "Show jumping"
			,'poney' => 'Pony'
			,'dressage' => 'Dressage'
			,'hunter' => 'Hunter'
			,'endurance' => 'Endurance'
			,'elevage' => 'Breeding'
			,'autres' => 'Other'
			// Sexes
			,'etalon' => 'Stallion'
			,'hongre' => 'Gelding'
			,'jument' => 'Mare'
			,'male' => 'Male'
			// Races
			,'american-warmblood' => 'American warmblood'
			,'anglo-arabe' => 'Anglo-Arabian'
			,'apaloosa' => 'Appaloosa'
			,'appaloosa' => 'Appaloosa'
			,'aqps' => 'AQPS'
			,'bwp' => 'Belgian Warmblood'
			,'caballo-de-deporte-espanol' => 'Caballo de Deporte Español'
			,'cheval-de-sport-belge-(sbs)' => 'Belgian Sport Horse'
			,'connemara' => 'Connemara'
			,'dartmund' => 'Dortmund'
			,'dortmund' => 'Dortmund'
			,'deutsches-reitpony' => 'German riding pony'
			,'hanovrien' => 'Hanoverian horse'
			,'holsteiner' => 'Holsteiner'
			,'irish-sport-horse' => 'Irish Sport Horse'
			,'kwpn' => 'Dutch Warmblood'
			,'lusitanien' => 'Lusitano'
			,'new-forest' => 'New Forest Pony'
			,'origines-constatees' => 'Crossbred horse'
			,'oldenburger' => 'Oldenburger'
			,'paint-horse' => 'American Paint Horse'
			,'pfs' => 'French Saddle Pony'
			,'pottock' => 'Pottok'
			,'pur-race-espagnole' => 'Andalusian horse'
			,'pur-sang' => 'Thoroughbred'
			,'pur-sang-arabe' => 'Arabian horse'
			,'quarter' => 'American Quarter Horse'
			,'quarter-horse' => 'American Quarter Horse'
			,'rheinland' => 'Rhenish Warmblood'
			,'sbs' => 'Belgian Sport Horse'
			,'selle-francais' => 'Selle Français'
			,'selle-italien' => 'Sella Italiano'
			,'selle-luxembourgeois' => 'Luxembourg Warmblood'
			,'trakhener' => 'Trakehner'
			,'trakehner' => 'Trakehner'
			,'trotteur-francais' => 'French Trotter'
			,'welsh' => 'Welsh pony'
			,'zangersheide' => 'Zangersheide'
			// Robes
			,'alezan' => 'chestnut'
			,'bai' => 'bay'
			,'bai-brun' => 'dark bay'
			,'bai-fonce' => 'dark bay'
			,'creme' => 'cream'
			,'gris' => 'grey'
			,'noir-pangare' => 'black'
			,'palomino' => 'palomino'
			,'pie' => 'piebald'
			,'isabelle' => 'dun'
			// Niveaux equestres
			,'debutant' => 'beginner'
			,'confirme' => 'advanced'
			,'expert' => 'expert'
			// Potentiels / Niveaux
			,'n.c.' => 'N/A'
			,'pas-sorti-en-concours' => 'Did not participate in a competition'
			,'cycle-libre' => 'Cycle libre'
			,'parcours-4-ans' => '4 year old class'
			,'parcours-5-ans' => '5 year old class'
			,'parcours-6-ans' => '6 year old class'
			,'parcours-7-ans' => '7 year old class'
			,'amateur-3' => 'Medium'
			,'amateur-2' => 'Advanced medium'
			,'amateur-1' => 'Advanced'
			,'amateur-elite' => 'St. Georges'
			//,'amateur-3' => 'Training'
			//,'amateur-2' => 'Training'
			//,'amateur-1' => 'Modified'
			//,'amateur-elite' => 'Preliminary'
			,'pro-3' => 'St. Georges'
			,'pro-2' => 'Intermediate I'
			,'pro-1' => 'Intermediate II'
			,'pro-elite' => 'Grand Prix'
			//,'pro-3' => 'Preliminary'
			//,'pro-2' => 'Preliminary'
			//,'pro-1' => 'Intermediate'
			//,'pro-elite' => 'Advanced'
			,'international' => 'International competion'
			,'vitesse-limitee' => 'Limited speed rides'
		);
		// ----------------------------------------
		// Text Format
		// ----------------------------------------
		$_text = trim( strtolower( ( equipeer_rewrite_string($text) ) ) );
		$translation = $eqDicts[$_text];
		// ----------------------------------------
		return ($translation != '') ? $translation : $text;
		// ----------------------------------------
	}
}