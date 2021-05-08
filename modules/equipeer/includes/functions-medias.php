<?php
/**
 * Blocking direct access to plugin
 */
defined('ABSPATH') or die('Are you crazy!');


if (!function_exists("equipeer_get_media_size")) {
	function equipeer_get_media_size($file) {
		if (!is_file($file)) {
			return 'O byte';
		} else {
			$size = filesize($file);
			if ($size >= 1073741824) $size = round($size / 1073741824 * 100) / 100 . " Go";
			elseif ($size >= 1048576) $size = round($size / 1048576 * 100) / 100 . " Mo";
			elseif ($size >= 1024) $size = round($size / 1024 * 100) / 100 . " Ko";
			else $size = $size . " bytes";
			return $size;
		}
	}
}


if (!function_exists("equipeer_get_media_mime")) {
	function equipeer_get_media_mime($file) {
		$fileinfo = finfo_open(FILEINFO_MIME_TYPE); // Retourne le type mime à l'extension mimetype
		$filemime = finfo_file($fileinfo, $file) . "\n";
		finfo_close($fileinfo);
		
		return $filemime;
	}
}


if (!function_exists("equipeer_get_file_extension")) {
	function equipeer_get_file_extension($filename) {
		$extension = explode('.', $filename);
		$extension = array_reverse($extension);
		$extension = $extension[0];
	
		return strtolower($extension);
	}
}


if (!function_exists("equipeer_set_byte_to_size")) {
	function equipeer_set_byte_to_size($p_sFormatted) {
		$aUnits = array('B'=>0, 'KB'=>1, 'MB'=>2, 'GB'=>3, 'TB'=>4, 'PB'=>5, 'EB'=>6, 'ZB'=>7, 'YB'=>8);
		$sUnit = strtoupper(trim(substr($p_sFormatted, -2)));
		if (intval($sUnit) !== 0) {
			$sUnit = 'B';
		}
		if (!in_array($sUnit, array_keys($aUnits))) {
			return false;
		}
		$iUnits = trim(substr($p_sFormatted, 0, strlen($p_sFormatted) - 2));
		if (!intval($iUnits) == $iUnits) {
			return false;
		}
		return $iUnits * pow(1024, $aUnits[$sUnit]);
	}
}
	
	
if (!function_exists("equipeer_get_image_infos")) {
	function equipeer_get_image_infos($image_path, $info = 'width') {
		// Get infos image
		$file_image = array_values(getimagesize($image_path));
		//use list on new array
		list($width, $height, $type, $attr) = $file_image;
	   
		switch($info) {
			default:       return $width;  break;
			case "height": return $height; break;
			case "type"  : return $type;   break;
			case "attr"  : return $attr;   break;
		}
	}
}


if (!function_exists("equipeer_image_orientation")) {
	function equipeer_image_orientation($file_path) {
		// Check if file exists
		if (file_exists($file_path)) {
			list($width, $height) = getimagesize($file_path);
			
			if( $width > $height)
				$orientation = "landscape";
			else
				$orientation = "portrait";
		} else {
			$orientation = false;
		}
		
		return $orientation;
	}
}


if (!function_exists("equipeer_image_url")) {
	function equipeer_image_url( $orientation, $tag_id, $photo_id, $photo_width, $photo_height, $alt, $nodisplay = false ) {
		switch($orientation) {
			case "landscape":
				// ----------------------------------
				// Image width 100%
				// ----------------------------------
				$photo_class = ($nodisplay) ? "img-fluid mx-auto d-none img-carousel-full img-width-100" : "img-fluid mx-auto d-block img-width-100 img-carousel-full";
			break;
			case "portrait":
			default:
				$photo_class = ($nodisplay) ? "img-fluid mx-auto img-carousel-full d-none" : "img-fluid mx-auto img-carousel-full d-block";
			break;
		}
		return wp_get_attachment_image( $photo_id, array("$photo_width", "$photo_height"), "", array( "class" => "$photo_class", "alt" => "$alt", "id" => "$tag_id" ) );
	}
}


if (!function_exists("equipeer_thumbnail_url")) {
	function equipeer_thumbnail_url( $orientation, $tag_id, $photo_id, $photo_width, $photo_height, $alt ) {
		switch($orientation) {
			case "landscape":
				// ----------------------------------
				// Image width 100%
				// ----------------------------------
				$photo_class = "card-img-top img-fluid thumbnail-type";
			break;
			case "portrait":
			default:
				$photo_class = "card-img-top img-fluid thumbnail-type";
			break;
		}
		return wp_get_attachment_image( $photo_id, array("$photo_width", "$photo_height"), "", array( "class" => "$photo_class", "alt" => "$alt", "id" => "$tag_id" ) );
	}
}


if (!function_exists("equipeer_is_image")) {
	function equipeer_is_image($image_path) {
	   // Get if infos image
	   $file = array_values(getimagesize($image_path));
	   //use list on new array
	   list($width, $height, $type, $attr) = $file;
	   
	   if ($width > 0)
		  return true; // Is an image
	   else
		  return false; // Is not an image
	}
}

	
if (!function_exists("equipeer_get_type_mime_image_inv")) {
	function equipeer_get_type_mime_image_inv($type) {
		switch (strtolower($type)) {
			// ------------------
			// Type image
			// ------------------
			case 'image/jpeg':						return 'jpeg';
			case 'image/jpeg':						return 'jpg';
			case 'image/jpeg':						return 'jpe';
			case 'image/png':						return 'png';
			case 'image/gif':						return 'gif';
			case 'image/tiff':						return 'tif';
			case 'image/tiff':						return 'tiff';
			case 'application/x-shockwave-flash':	return 'swf';
			case 'image/psd':						return 'psd';
			case 'image/bmp':						return 'bmp';
			case 'image/jp2':						return 'jp2';
			case 'image/iff':						return 'iff';
			case 'image/vnd.wap.wbmp':				return 'wbmp';
			case 'image/xbm':						return 'xbm';
			case 'image/vnd.microsoft.icon':		return 'ico';
	
			default: return false;
		}
	}
}
	
	
if (!function_exists("equipeer_get_type_mime_video_inv")) {
	function equipeer_get_type_mime_video_inv($type) {
		switch (strtolower($type)) {
			// ------------------
			// Type video
			// ------------------
			case 'video/mpeg':		return 'mpg';
			case 'video/mp4':		return 'mp4';
			case 'video/quicktime':	return 'mov';
			case 'video/x-ms-wmv':	return 'wmv';
			case 'video/x-msvideo':	return 'avi';
			case 'video/x-flv':		return 'flv';
	
			default: return false;
		}
	}
}


if (!function_exists("equipeer_get_filemtime")) {
	function equipeer_get_filemtime($filename, $date = "en") {
		// Test if the file exist
		if (file_exists($filename)) {
			if ($date == "fr") return date ("d-m-Y", filemtime($filename));
			else return date ("Y-m-d", filemtime($filename));
		} else {
			return false;
		}
	}
}

if (!function_exists("equipeer_sec_2_hms")) {
	function equipeer_sec_2_hms($sec, $padHours = false) {
		$hms     = "";
		$hours   = intval(intval($sec) / 3600);
		$hms    .= ($padHours) ? str_pad($hours, 2, "0", STR_PAD_LEFT). ':' : $hours. ':';
		$minutes = intval(($sec / 60) % 60);
		$hms    .= str_pad($minutes, 2, "0", STR_PAD_LEFT). ':';
		$seconds = intval($sec % 60);
		$hms     .= str_pad($seconds, 2, "0", STR_PAD_LEFT);
	
		return $hms;
	}
}

	
if (!function_exists("equipeer_hms_2_sec")) {
	function equipeer_hms_2_sec($hms) {
		list($h, $m, $s) = explode (":", $hms);
		$seconds = 0;
		$seconds += (intval($h) * 3600);
		$seconds += (intval($m) * 60);
		$seconds += (intval($s));
		return $seconds;
	}
}

function equipeer_movie_duration($path_movie) {
    if (is_object($utils_movie = new ffmpeg_movie("$path_movie"))) {
        return $utils_movie->getDuration();
    } else {
        return false;
    }
}

function equipeer_movie_bitrate($path_movie) {
    if (is_object($utils_movie = new ffmpeg_movie("$path_movie"))) {
        return $utils_movie->getBitRate();
    } else {
        return false;
    }
}

function equipeer_movie_framecount($path_movie) {
    if (is_object($utils_movie = new ffmpeg_movie("$path_movie"))) {
        return $utils_movie->getFrameCount();
    } else {
        return false;
    }
}

function equipeer_movie_videocodec($path_movie) {
    if (is_object($utils_movie = new ffmpeg_movie("$path_movie"))) {
        return $utils_movie->getVideoCodec();
    } else {
        return false;
    }
}

function equipeer_movie_audiocodec($path_movie) {
    if (is_object($utils_movie = new ffmpeg_movie("$path_movie"))) {
        return $utils_movie->getAudioCodec();
    } else {
        return false;
    }
}

function equipeer_movie_audiochannel($path_movie) {
    if (is_object($utils_movie = new ffmpeg_movie("$path_movie"))) {
        return $utils_movie->getAudioChannels();
    } else {
        return false;
    }
}

?>