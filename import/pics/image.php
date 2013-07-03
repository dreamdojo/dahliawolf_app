<<<<<<< HEAD
<?
$imagename = !empty($_GET['imagename']) ? $_GET['imagename'] : NULL;
$height = !empty($_GET['height']) ? (int)$_GET['height'] : NULL;
$width = !empty($_GET['width']) ? (int)$_GET['width'] : NULL;

require $_SERVER['DOCUMENT_ROOT'] . '/lib/php/resize-image.php';

if (!empty($imagename)) {
	$file_path = $imagename;
	if (file_exists($file_path)) {
		$file = $file_path;

		$image = new SimpleImage($file);
		if (is_numeric($height) && is_numeric($width)) {
			$image->resize($width, $height);
		}
		else if (is_numeric($height)) {
			$image->resizeToHeight($height);
		}
		else if (is_numeric($width)) {
			$image->resizeToWidth($width);
		}
		$image->output();
	}
}
=======
<?
$imagename = !empty($_GET['imagename']) ? $_GET['imagename'] : NULL;
$height = !empty($_GET['height']) ? (int)$_GET['height'] : NULL;
$width = !empty($_GET['width']) ? (int)$_GET['width'] : NULL;

require $_SERVER['DOCUMENT_ROOT'] . '/lib/php/resize-image.php';

if (!empty($imagename)) {
	$file_path = $imagename;
	if (file_exists($file_path)) {
		$file = $file_path;

		$image = new SimpleImage($file);
		if (is_numeric($height) && is_numeric($width)) {
			$image->resize($width, $height);
		}
		else if (is_numeric($height)) {
			$image->resizeToHeight($height);
		}
		else if (is_numeric($width)) {
			$image->resizeToWidth($width);
		}
		$image->output();
	}
}
>>>>>>> 5edbe6c9174c69dcc5e6287ce151d3df30e4799d
?>