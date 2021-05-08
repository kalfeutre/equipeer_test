<!DOCTYPE html>
<html lang="fr">
<head>
	<?php
	error_reporting(E_ALL);
	ini_set("display_errors", 1);
	// ---------------------------------------
	//include_once( '/var/www/html/sandbox/mpdf/mpdf/mpdf.php');
	require_once __DIR__ . '/vendor/autoload.php';
	$mpdf = new \Mpdf\Mpdf();
	?>

	<!-- Basic Page Needs
	–––––––––––––––––––––––––––––––––––––––––––––––––– -->
	<meta charset="utf-8">
	<title>Page test - EQUIPEER Génération de PDFs - Admin</title>
	<meta name="description" content="">
	<meta name="author" content="">
  
	<!-- Mobile Specific Metas
	–––––––––––––––––––––––––––––––––––––––––––––––––– -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
  
	<!-- FONT
	–––––––––––––––––––––––––––––––––––––––––––––––––– -->
	<link href="//fonts.googleapis.com/css?family=Raleway:400,300,600" rel="stylesheet" type="text/css">
  
	<!-- CSS
	–––––––––––––––––––––––––––––––––––––––––––––––––– -->
	<link rel="stylesheet" href="css/normalize.css">
	<link rel="stylesheet" href="css/skeleton.css">
  
	<!-- Favicon
	–––––––––––––––––––––––––––––––––––––––––––––––––– -->
	<link rel="icon" type="image/png" href="images/favicon.png">
  
	<!-- JS
	–––––––––––––––––––––––––––––––––––––––––––––––––– -->
	<script src="//code.jquery.com/jquery-3.4.1.js"></script>
	
	</head>
	<body>
		
		<!-- Primary Page Layout
		–––––––––––––––––––––––––––––––––––––––––––––––––– -->
		<div class="container">
			<div class="row">
				<div class="" style="">
		
					<h1>Génération de PDFs test</h1>
	
					<?php
					// __DIR__
					// Ex : var/www/vhosts/equipeer.com/httpdocs/modules/equipeer/unit-test/pdf
					$DIR = __DIR__ . DIRECTORY_SEPARATOR;
					// $_SERVER['REQUEST_URI']
					// Ex : https://equipeer.com/modules/equipeer/unit-test/pdf/
					$URL = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
					// --------------------------------------
					$created  = "Créé le " . date('d-m-Y');
					$filename = 'test.pdf';
					$filename_expert = 'test_expert.pdf';
					// ---------------------------------------
					defined('ADMIN_TPLS_PATH') or define('ADMIN_TPLS_PATH', $DIR . 'tpl/');
					defined('ADMIN_TPLS_URL') or define('ADMIN_TPLS_URL', $URL . 'tpl/');
					defined('ADMIN_TMP_PATH') or define('ADMIN_TMP_PATH', $DIR . 'upload/');
					defined('ADMIN_TMP_URL') or define('ADMIN_TMP_URL', $URL . 'upload/');
					defined('ADMIN_SAMPLE') or define('ADMIN_SAMPLE', $URL . 'samples/');
					// ---------------------------------------
					$page_1_tpl    = ADMIN_TPLS_PATH . 'page_1.html';
					$page_2_tpl    = ADMIN_TPLS_PATH . 'page_2_client.html';
					$page_3_tpl    = ADMIN_TPLS_PATH . 'page_3_expert.html';
					$page_note_tpl = ADMIN_TPLS_PATH . 'page_note.html';
					// ---------------------------------------
					// ---------------------------------------
					//$mpdf = new Mpdf();
					$mpdf->SetProtection(array('copy','print'));
					$mpdf->SetTitle( 'Titre TEST - CLIENT' );  // PDF Title
					$mpdf->SetAuthor( 'EQUIPEER SPORT' ); // PDF Author
					$mpdf->SetWatermarkText( 'EQUIPEER TEST' ); // Watermark
					$mpdf->showWatermarkText = true; // Afficher un watermark
					$mpdf->watermark_font = 'DejaVuSansCondensed';
					$mpdf->watermarkTextAlpha = 0.1;
					$mpdf->SetDisplayMode('fullpage');
					// --- Page de garde
					$page_1 = ""; 
					$page_1 = file_get_contents( $page_1_tpl );
					$page_1 = @preg_replace("/{PAGE_1_CREATED}/", $created, $page_1);
					$page_1 = @preg_replace("/{PAGE_1_SELECTION_TEXT}/", 'Selection of expert ads', $page_1);
					// --- Write PAGE
					@$mpdf->AddPage('P', 'EVEN');
					@$mpdf->WriteHTML($page_1);
					// -------------- Page HORSE -------------
					$page_2 = "";
					$page_2 = file_get_contents( $page_2_tpl );
					// --- Write PAGE
					$ids = 'so201.jpg,so236.jpg';
					if (!empty($ids)) {
						$_ids = explode(",", $ids);
						foreach($_ids as $id) {
							// ----------------------------------------
							// --- Infos
							// ----------------------------------------
							$page_2 = "";
							$page_2 = file_get_contents( $page_2_tpl );
							// --------- IMAGES / THUMBNAILS ----------
							// ----------------------------------------
							$photo_1_url = ADMIN_SAMPLE . $id;
							$thumb_1_url = ADMIN_SAMPLE . 'thumb1.jpg';
							$thumb_2_url = ADMIN_SAMPLE . 'thumb2.jpg';
							$thumb_3_url = ADMIN_SAMPLE . 'thumb3.jpg';
							// ----------------------------------------
							$page_2 = @preg_replace("/{HEADER_TXT}/", 'Réf. SO-0201 - CHEVAL - CSO', $page_2);
							$page_2 = @preg_replace("/{PAGE_2_IMG1}/", $photo_1_url, $page_2);
							$page_2 = @preg_replace("/{PAGE_2_THB1}/", $thumb_1_url, $page_2);
							$page_2 = @preg_replace("/{PAGE_2_THB2}/", $thumb_2_url, $page_2);
							$page_2 = @preg_replace("/{PAGE_2_THB3}/", $thumb_3_url, $page_2);
							// ----------------------------------------
							$page_2 = @preg_replace("/{DESCRIPTION1}/", "SELLE FRANÇAIS - par MAGIC D'ELLE - HONGRE - BAI - 174cm - 12 Ans", $page_2);
							$page_2 = @preg_replace("/{DESCRIPTION2}/", "LOCALISATION : CALVADOS (FRANCE)", $page_2);
							$page_2 = @preg_replace("/{DESCRIPTION_L1_TEXT}/", "NIVEAU ACTUEL", $page_2);
							$page_2 = @preg_replace("/{DESCRIPTION_L1}/", "140cm", $page_2);
							$page_2 = @preg_replace("/{DESCRIPTION_R1_TEXT}/", "POTENTIEL", $page_2);
							$page_2 = @preg_replace("/{DESCRIPTION_R1}/", "140cm +", $page_2);
							$page_2 = @preg_replace("/{IMPRESSION}/", "Cheval expérimenté, évoluant régulièrement sur des épreuves 145. Idéal pour un cavalier désireux de faire ses gammes sur de grosses épreuves.", $page_2);
							$page_2 = @preg_replace("/{PRICE}/", "PRIX : > 80.000 €", $page_2);
							// --- Write PAGE
							@$mpdf->AddPage('P', 'ODD');
							@$mpdf->WriteHTML($page_2);
						}
					}
					//// --- Page de note
					$page_note_client = file_get_contents( $page_note_tpl );
					$page_note_client = @preg_replace("/{EQUIPEER_BG_PAGE_NOTE}/", ADMIN_TMP_URL . "bg/page-note.png", $page_note_client);
					// --- Write PAGE
					@$mpdf->AddPage('P', 'EVEN');
					@$mpdf->WriteHTML($page_note_client);
					// ---------------------------------------
					//$mpdf->debug = true;
					$file_client = $filename;
					@$mpdf->debug = true;
					@$mpdf->Output( ADMIN_TMP_PATH . $file_client );
					
					echo '<p>Fichier test client généré : <a target="_blank" href="upload/test.pdf">FICHIER</a><p>';
					
					// ---------------------------------------
					// Autre document
					// ---------------------------------------
					$mpdf = new \Mpdf\Mpdf();
					$mpdf->SetProtection(array('copy','print'));
					$mpdf->SetTitle( 'Titre - TEST EXPERT' );  // PDF Title
					$mpdf->SetAuthor( 'EXPERT EQUIPEER' ); // PDF Author
					$mpdf->SetWatermarkText( 'EXPERT TEST' ); // Watermark
					$mpdf->showWatermarkText = true; // Afficher un watermark
					$mpdf->watermark_font = 'DejaVuSansCondensed';
					$mpdf->watermarkTextAlpha = 0.1;
					$mpdf->SetDisplayMode('fullpage');
					// ---------------------------------------
					// --------------- PAGE 3 ----------------
					// ---------------------------------------
					// --- Page de garde
					$page_1_expert = ""; 
					$page_1_expert = file_get_contents( $page_1_tpl );
					$page_1_expert = @preg_replace("/{PAGE_1_CREATED}/", $created, $page_1_expert);
					$page_1_expert = @preg_replace("/{PAGE_1_SELECTION_TEXT}/", 'Selection of expert ads', $page_1_expert);
					// --- Write PAGE
					@$mpdf->AddPage('P', 'EVEN');
					@$mpdf->WriteHTML($page_1_expert);
					// ---------------------------------------
					if (!empty($ids)) {
						$_ids = explode(",", $ids);
						foreach($_ids as $id) {
							// ----------------------------------------
							// --- Infos
							// ----------------------------------------
							$page_2_expert = "";
							$page_2_expert = file_get_contents( $page_2_tpl );
							// --------- IMAGES / THUMBNAILS ----------
							// ----------------------------------------
							$photo_1_url = ADMIN_SAMPLE . $id;
							$thumb_1_url = ADMIN_SAMPLE . 'thumb1.jpg';
							$thumb_2_url = ADMIN_SAMPLE . 'thumb2.jpg';
							$thumb_3_url = ADMIN_SAMPLE . 'thumb3.jpg';
							// ----------------------------------------
							$page_2_expert = @preg_replace("/{HEADER_TXT}/", 'Réf. SO-0201 - CHEVAL - CSO', $page_2_expert);
							$page_2_expert = @preg_replace("/{PAGE_2_IMG1}/", $photo_1_url, $page_2_expert);
							$page_2_expert = @preg_replace("/{PAGE_2_THB1}/", $thumb_1_url, $page_2_expert);
							$page_2_expert = @preg_replace("/{PAGE_2_THB2}/", $thumb_2_url, $page_2_expert);
							$page_2_expert = @preg_replace("/{PAGE_2_THB3}/", $thumb_3_url, $page_2_expert);
							// ----------------------------------------
							$page_2_expert = @preg_replace("/{DESCRIPTION1}/", "SELLE FRANÇAIS - par MAGIC D'ELLE - HONGRE - BAI - 174cm - 12 Ans", $page_2_expert);
							$page_2_expert = @preg_replace("/{DESCRIPTION2}/", "LOCALISATION : CALVADOS (FRANCE)", $page_2_expert);
							$page_2_expert = @preg_replace("/{DESCRIPTION_L1_TEXT}/", "NIVEAU ACTUEL", $page_2_expert);
							$page_2_expert = @preg_replace("/{DESCRIPTION_L1}/", "140cm", $page_2_expert);
							$page_2_expert = @preg_replace("/{DESCRIPTION_R1_TEXT}/", "POTENTIEL", $page_2_expert);
							$page_2_expert = @preg_replace("/{DESCRIPTION_R1}/", "140cm +", $page_2_expert);
							$page_2_expert = @preg_replace("/{IMPRESSION}/", "CHEVAL EXPÉRIMENTÉ, ÉVOLUANT RÉGULIÈREMENT SUR DES ÉPREUVES 145. IDÉAL POUR UN CAVALIER DÉSIREUX DE FAIRE SES GAMMES SUR DE GROSSES ÉPREUVES.", $page_2_expert);
							// --- Write PAGE
							@$mpdf->AddPage('P', 'ODD');
							@$mpdf->WriteHTML($page_2);
							// ---------------------------------------
							// --------------- PAGE 3 ----------------
							// ---------------------------------------
							$page_3_expert = "";
							$page_3_expert = file_get_contents( $page_3_tpl );
							// ---------------------------------------
							$page_3_expert = @preg_replace("/{HEADER_TXT}/", "Réf. SO-0201 - CHEVAL - CSO - Détail", $page_3_expert);
							$page_3_expert = @preg_replace("/{PRICE}/", "PRIX : 87.550 €", $page_3_expert);
							$page_3_expert = @preg_replace("/{PAGE_3_CONTENT}/", "TEST", $page_3_expert);
							// ---------------------------------------
							@$mpdf->AddPage('P', 'EVEN');
							@$mpdf->WriteHTML($page_3_expert);
							// ---------------------------------------
						}
					}
					// ---------------------------------------
					//// --- Page de note
					$page_note_expert = file_get_contents( $page_note_tpl );
					$page_note_expert = @preg_replace("/{EQUIPEER_BG_PAGE_NOTE}/", ADMIN_TMP_URL . "bg/page-note.png", $page_note_expert);
					// --- Write PAGE
					@$mpdf->AddPage('P', 'EVEN');
					@$mpdf->WriteHTML($page_note_expert);
					// ---------------------------------------
					@$mpdf->AddPage('P', 'EVEN');
					@$mpdf->WriteHTML($page_1);
					@$mpdf->debug = true;
					@$mpdf->Output( ADMIN_TMP_PATH . $filename_expert );
					
					echo '<p>Fichier test expert généré : <a target="_blank" href="upload/test_expert.pdf">FICHIER</a><p>';
					
					?>
					
				</div>
			</div>
		</div>
		
	</body>
</html>