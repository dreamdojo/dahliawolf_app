<?php

function rgb2html($r, $g=-1, $b=-1)
{
    if (is_array($r) && sizeof($r) == 3)
        list($r, $g, $b) = $r;

    $r = intval($r); $g = intval($g);
    $b = intval($b);

    $r = dechex($r<0?0:($r>255?255:$r));
    $g = dechex($g<0?0:($g>255?255:$g));
    $b = dechex($b<0?0:($b>255?255:$b));

    $color = (strlen($r) < 2?'0':'').$r;
    $color .= (strlen($g) < 2?'0':'').$g;
    $color .= (strlen($b) < 2?'0':'').$b;
    return $color;
}

function getClosest($search) {
    $colorArray[0] = 'BLACK';
    $colorArray[255] = 'BLUE';
    $colorArray[32768] = 'GREEN';
    $colorArray[8388736] = 'PURPLE';
    $colorArray[12632256] = 'GREY';
    $colorArray[16711680] = 'RED';
    $colorArray[16776960] = 'YELLOW';
    $colorArray[16777215] = 'WHITE';

    $arr = array(0, 255, 32768, 8388736, 12632256, 16711680, 16776960, 16777215);

    $closest = null;
    foreach($arr as $item) {
        if($closest == null || abs($search - $closest) > abs($item - $search)) {
            $closest = $item;
        }
    }
    return $colorArray[$closest];
}

function getTag($dec) {

    switch($dec) {
        case $dec <= hexdec('222222'):
            return 'BLACK';
        case $dec < hexdec('808080'):
            return 'GRAY';
        case $dec < hexdec('e4e4e4'):
            return 'YELLOW';
        case $dec < hexdec('f0ff00'):
            return 'CYAN / AQUA';
        case $dec < 16711680 :
            return 'RED';
        case $dec < hexdec('FFFFFF'):
            return 'WHITE';
    }
}

if($_GET['image']) {
    $img = $_GET['image'];
} else {
    $img = "image.jpg";
}

$dir = './';
foreach(glob($dir.'*.jpg') as $img): ?>
<?
$imgDimensions = getimagesize($img);
switch($imgDimensions["mime"]){
    case "image/jpeg":
        $im = imagecreatefromjpeg($img); //jpeg file
        break;
    case "image/gif":
        $im = imagecreatefromgif($img); //gif file
        break;
    case "image/png":
        $im = imagecreatefrompng($img); //png file
        break;
    default:
        $im=false;
        break;
}

$center = $imgDimensions[0]/2;
$middle = $imgDimensions[1]/2;
$point = array($center, $middle);
$area = -$imgDimensions[0]*.25;

for($x = $area; $x < abs($area); $x++) {
    $rgb = imagecolorat($im, $point[0]+$x, $point[1]+$x);

    $r = ($rgb >> 16) & 0xFF;
    $g = ($rgb >> 8) & 0xFF;
    $b = $rgb & 0xFF;

    $matrix[$x] = rgb2html($r, $g, $b);
}

$values = array_count_values($matrix);
$result = array_search(max($values), $values);
$res_color = hexdec($result);
?>
<style>body{width: 1200px; margin: 0px auto;}</style>
<div style="height: 200px; overflow: hidden; border: #c2c2c2 thin solid;">
    <img style="height: 100%; float: left;" src="<?= $img ?>">
    <div style="float: left; font-size: 30px; text-align: center; width: 200px;margin-top: 87px;">?=</div>
    <div style="width: 100px; height: 100px; background-color: #<?= $result ?>; border: #000 thin solid; float: left;margin-top: 56px;"></div>
    <div style="float: left;margin-top: 100px;margin-left: 23px;">#<?= $result ?></div>
    <div style=" clear:left;width: 500px;"><? //var_dump($matrix) ?></div>
</div>

<? endforeach ?>