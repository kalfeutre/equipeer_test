<?php
 // Security Check
if (!$_GET['from'] && $_GET['from'] != 'admin' && $_GET['from'] != 'front') {
	die( "You cannot load this file directly!");
}
// ---------------------------------
// --- INITIALISATION
// ---------------------------------	
$wsdl_login    = "equipeer";
$wsdl_password = "fY7!LaSS;kF";
$wsdl_appli_id = $wsdl_login . "_website";
$wsdl_url      = "http://ws3g.haras-nationaux.fr/services/HorseEsperiProServices?wsdl"; 
$wsdl_language = "fr";
$wsdl_sire     = trim($_GET['sire']);
$wsdl_from     = trim($_GET['from']);
// --------------------------------------------
// --- Get Horse Informations
// --------------------------------------------
wsdl_get_sire($wsdl_login, $wsdl_password, $wsdl_sire, $wsdl_from, $wsdl_url, $wsdl_appli_id); 
// --------------------------------------------
// --- Function Soap Request
// --------------------------------------------
function wsdl_get_sire($wsdl_login, $wsdl_password, $wsdl_sire, $wsdl_from, $wsdl_url, $wsdl_appli_id) {
	// ---------------------------------	
	// --- Creation de l'objet de param
	// ---------------------------------
	$wsdl_params = new StdClass(); 
	$wsdl_params->context = new StdClass(); 
	$wsdl_params->context->isoLangage    = $wsdl_language; 
	$wsdl_params->context->utilisateurID = $wsdl_login; 
	$wsdl_params->context->applicationID = $wsdl_appli_id; 
	$wsdl_params->typeId                 = "SIRE"; 
	$wsdl_params->valueId                = "$wsdl_sire"; 
	// ---------------------------------	
	// --- Les options pour SOAPCLIENT
	// ---------------------------------
	$wsdl_soap_options = array( 
		"login"    => $wsdl_login
	   ,"password" => $wsdl_password
	   ,"encoding" => 'ISO-8859-1'
	); 
	// ---------------------------------
	try { 
		// ---------------------------------	
		// --- Connexion au WebService
		// ---------------------------------	 
		$wsdl_webservice = new SoapClient($wsdl_url, $wsdl_soap_options); 
		// ---------------------------------	
		// --- Appel Webservice Function object
		// ---------------------------------
		//print_r($wsdl_params);
		$resultHorseInformation = $wsdl_webservice->horseInformation($wsdl_params);
		// ---------------------------------	
		// --- Show results
		// ---------------------------------
		//print_r( $resultHorseInformation );
		$result_array = [];
		$result_array['date']   = $resultHorseInformation->HorseInformationOut->birthDate;
		$result_array['nom']    = $resultHorseInformation->HorseInformationOut->birthName;
		$result_array['race']   = $resultHorseInformation->HorseInformationOut->breedLabel;
		$result_array['robe']   = $resultHorseInformation->HorseInformationOut->colourLabel;
		$result_array['taille'] = $resultHorseInformation->HorseInformationOut->height;
		$result_array['sexe']   = $resultHorseInformation->HorseInformationOut->sexLabel;
		$result_array['sireN']  = $resultHorseInformation->HorseInformationOut->sireNumber;
		$result_array['sireK']  = $resultHorseInformation->HorseInformationOut->sireKey;
		echo json_encode($result_array);
	} 
	catch(Exception $e) {
		// ---------------------------------
		// --- Exception si pas d'abonnement ou compte inexistant ou erreur de SIRE
		// ---------------------------------
		print_r( $e->getMessage() ); 
	} 
}

?>