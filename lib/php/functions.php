<?
// $fileInfo can be a file path or file extension
function getMimeType($fileInfo){
	if (strpos($fileInfo, '.') === false) {
		$fileType = $fileInfo;
	}
	else {
		$fileInfoList = pathinfo($fileInfo);
		$fileType = strtolower($fileInfoList['extension']);
	}
	
	switch ($fileType) {
		case 'js':
			$mime = 'application/x-javascript';
			break;
		case 'json':
			$mime = 'application/json';
			break;
		case 'jpg': case 'jpeg': case 'jpe':
			$mime = 'image/jpeg';
			break;
		case 'png': case 'gif': case 'bmp': case 'tiff':
			$mime = 'image/' . $fileType;
			break;
		case 'psd':
			$mime = 'image/x-photoshop';
			break;
		case 'bmp':
			$mime = 'image/x-ms-bmp';
			break;
		case 'css':
			$mime = 'text/css';
			break;
		case 'xml':
			$mime = 'application/xml';
			break;
		case 'doc':
			$mime = 'application/msword';
			break;
		case 'docx':
			 $mime = 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';
			 break;
		case 'xls': case 'xlsx': case 'xlt': case 'xlb': case 'xlm': case 'xld': case 'xla': case 'xlc': case 'xlw': case 'xll':
			$mime = 'application/vnd.ms-excel';
			break;
		case 'ppt': case 'pps': case 'pptx':
			$mime = 'application/vnd.ms-powerpoint';
			break;
		case 'rtf':
			$mime = 'application/rtf';
			break;
		case 'pdf':
			$mime = 'application/pdf';
			break;
		case 'html': case 'htm': case 'php': case 'shtml':
			$mime = 'text/html';
			break;
		case 'csv':
			$mime = 'text/csv';
			break;
		case 'txt':
			$mime = 'text/plain';
			break;
		case 'mpeg': case 'mpg': case 'mpe':
			$mime = 'video/mpeg';
			break;
		case 'mp3':
			$mime = 'audio/mpeg';
			break;
		case 'mp4':
			$mime = 'video/mp4';
			break;
		case 'wav':
			$mime = 'audio/wav';
			break;
		case 'aiff': case 'aif':
			$mime = 'audio/aiff';
			break;
		case 'avi':
			$mime = 'video/msvideo';
			break;
		case 'wmv':
			$mime = 'video/x-ms-wmv';
			break;
		case 'mov': case 'qt':
			$mime = 'video/quicktime';
			break;
		case 'zip':
			$mime = 'application/zip';
			break;
		case 'tar':
			$mime = 'application/x-tar';
			break;
		case 'swf':
			$mime = 'application/x-shockwave-flash';
			break;
		case 'flv':
			$mime = 'video/x-flv';
			break;
		case 'wma':
			$mime = 'audio/x-ms-wma';
			break;
		case 'rar':
			$mime = 'application/rar';
			break;
		case 'gtar': case 'tgz': case 'taz':
			$mime = 'application/x-gtar';
			break;
		
		default:
			return false;
	}
	return $mime;
}

function file_upload($name, $dir, $maxSize=false, $validTypes = false){
	$error = NULL;
	$random = substr(md5(time().rand(0, 1000000)), 2, 8);
	if ($_FILES[$name]['name'] == '') {
		die('file_upload() error: ' . $name . ' is blank.');
	}
	if (!is_dir($dir)) {
		die('file_upload() error: ' . $dir . ' is not a dir, duh! haha');
	}
	$tmpFile = $dir.$random;
	if (!move_uploaded_file($_FILES[$name]['tmp_name'], $tmpFile)) {
		die('file_upload() error: can not move ' . $_FILES[$name]['tmp_name'] . ' to ' . $dir);
	}
	
	if ($maxSize) { //val file size
		if (filesize($tmpFile) > ($maxSize)) {
			$error = 'File exceeded maximum size.';
		}
	}
	
	//get file extension
	$parts = explode('.', $_FILES[$name]['name']);
	$lastIndex = count($parts) - 1;
	$ext = strtolower($parts[$lastIndex]);
	unset($parts[$lastIndex]);
	$fileName = implode('.', $parts);
	
	//validate file type
	if (is_array($validTypes)) {
		//checkMime = mime_content_type($tmpFile);
		/*
		if (function_exists('finfo_open')) {
			$finfo = finfo_open(FILEINFO_MIME);
			$checkMime = finfo_file($finfo, $tmpFile);
			finfo_close($finfo);
		}
		else if (function_exists('mime_content_type')) {
			 $checkMime = mime_content_type($tmpFile);
		}
     	else {
			$checkMime = $_FILES[$name]['type'];
		} 
		*/
		
		$checkMime = getMimeType($ext);
		if (!$checkMime) {
			die('file_upload() error: cant not find mime type for: ' . $ext);
		}
		
		$validMimes = array();
		foreach ($validTypes as $type) {
			$mime = getMimeType($type);
			if (!$mime) {
				die('file_upload() error: cant not find mime type for:' . $type);
			}
			array_push($validMimes, $mime);
		}
		if (!in_array($checkMime, $validMimes)) {
			$error = 'File type is not supported.';
		}
	}
	
	if (is_array($validTypes) && !in_array($ext, $validTypes)) {
		$error = 'File extension is not supported.';
	}
	
	if ($error) {
		unlink($tmpFile);
		return $error;
	}
	
	return array(
		$tmpFile
		, $ext
		, $fileName
	);
}
?>