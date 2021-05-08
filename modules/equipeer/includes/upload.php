<?php
// -----------------------------------
// --------- UPLOAD / DELETE ---------
// -----------------------------------
$photo_allowed_max    = 20000*1024;   // 20 Mo
$video_allowed_max    = 100000*1024;   // 100 Mo
$document_allowed_max = 10000*1024;   // 10 Mo
// -----------------------------------
$json = array();
// -----------------------------------
$op        = trim($_POST['mediaAction']); // upload | delete
$mediaType = trim($_POST['mediaType']);   // photo | video | document
$mediaNum  = intval($_POST['mediaNum']);  // 1 | 2 | 3 | 4
$mediaPath = "/var/www/vhosts/equipeer.com/httpdocs/uploads/";
// -----------------------------------
// --- check if TMP directory exists
$mediaDir  = $mediaPath . trim($_POST['mediaPath']) . "/" . trim($_POST['mediaTime']) . "/";
if (!file_exists($mediaDir)) {
    mkdir($mediaDir, 0777, true);
	chmod($mediaPath . trim($_POST['mediaPath']) . "/", 0777); // First directory
	chmod($mediaDir, 0777); // Second directory
}
// -----------------------------------
switch($op) {
	case "delete":
		// -----------------------------------
		// --------- Media to Delete ---------
		// -----------------------------------
		$mediaToDelete = $mediaType . '_' . $mediaNum .'.*';
		//unlink
		if ( $mediaToDelete ) { 
			$filePath = $mediaDir.$mediaToDelete;
			// Delete file
			$fileToDelete = array_map('unlink', glob("$filePath")); 
			if ($fileToDelete) {
				$json = 'success'; 
			} else {
				$json = 'failed';
			} 
		} else {
			$json = 'error';
		}
	break;
	//default:
	case "upload":
		// ----------------------------------------
		$mediaToUpload = $_FILES['upl_'.$mediaType.'_'.$mediaNum]; // Ex: $_FILES['upl_photo_1']
		$fileName      = $mediaType . '_' . $mediaNum . '.' . pathinfo($mediaToUpload['name'], PATHINFO_EXTENSION);
		$filePath      = $mediaDir.$fileName;
		$fileType      = pathinfo($filePath, PATHINFO_EXTENSION); 
		// ----------------------------------------
		switch($mediaType) {
			case "photo":
				$allowTypes = array('jpg', 'png', 'jpeg', 'gif');
				$allowMax   = $photo_allowed_max;
			break;
			case "video":
				$allowTypes = array('avi', 'mp4', 'mpeg', 'ogg', 'mov');
				$allowMax   = $video_allowed_max;
			break;
			case "document":
				$allowTypes = array('pdf', 'doc', 'docx');
				$allowMax   = $document_allowed_max;
			break;
		}
		// ----------------------------------------
		if ( !empty($mediaToUpload) ) {
			if ($mediaToUpload["size"] > $allowMax) { // Check file size
				$json = 'filetoolarge';
			} elseif (in_array($fileType, $allowTypes)) { // Check whether file type is valid 
				// Upload file to the server 
				if (move_uploaded_file($mediaToUpload['tmp_name'], $filePath)) {
					chmod($filePath, 0777);
					$json = 'success'; 
				} else {
					$json = 'failed';
				}
			} else {
				$json = 'notallowed - '.$fileType;
			}
		} else {
			$json = 'emptyfile';
		}
		// ----------------------------------------
	break;
}

header('Content-Type: application/json');
echo json_encode($json);
?>