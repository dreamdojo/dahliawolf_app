<?php
session_start();

$imgarraytype = array();
$startNum = $_GET['index'];
$endNum = $startNum + 1000;
$imgIndex = $_SESSION['image_index']; 

$url = 'http://api.dahliawolf.com/imagefeed/getImages.php';
$fields = array(
            'start_limit' => $startNum,
			'end_limit' => $endNum,
			'posted' => 2,
			'type' => 'all'
        );
//posted 0 = all
//posted 1 = posted
//posted 2 = not posted		
foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
rtrim($fields_string, '&');

$ch = curl_init();
curl_setopt($ch,CURLOPT_URL, $url);
curl_setopt($ch,CURLOPT_POST, count($fields));
curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

if(curl_exec($ch) === false)
	{
		echo 'Curl error: ' . curl_error($ch);
	}

$result = curl_exec($ch);
curl_close($ch);
$res = json_decode($result);
$instagram_count = 0;
$pinterest_count = 0;
$cat_cap = 50;
$array_index = $startNum;


//echo "<div id='test1'>".$res[0]->src."</div>";

foreach($res AS $val)
	{
		if($val->type == "webstagram" && $instagram_count < $cat_cap){
			echo '<div id="imgFrame-'.$imgIndex.'" style="overflow: hidden; position:relative; width:186px; height: 177px; z-index:100000; float: left; border:3px solid #484848; margin-right: 5px;" class="'; 
			echo "instagram";
			echo ' soc-img-frame"><img id="imgIndex-'.$imgIndex.'" src="'.$val->src.'" style="position:absolute; min-height:180px;" onclick="postit(\''.$val->big_src.'\', '.$imgIndex.')">';
			echo "</div>";
			$imgIndex++;
			$instagram_count++;
		}
		elseif($val->type == "pinterest" && $pinterest_count < $cat_cap){
			echo '<div id="imgFrame-'.$imgIndex.'" style="overflow: hidden; position:relative; width:186px; height: 177px; z-index:100000; float: left; border:3px solid #484848; margin-right: 5px;" class="'; 
			echo "pinterest";
			echo ' soc-img-frame"><img id="imgIndex-'.$imgIndex.'" src="'.$val->src.'" style="position:absolute; min-height:180px;" onclick="postit(\''.$val->big_src.'\', '.$imgIndex.')">';
			echo "</div>";
			$imgIndex++;
			$pinterest_count++;
		}
		$array_index++;
		if($pinterest_count >= $cat_cap && $instagram_count >= $cat_cap){
			break;
		}
	}
	$_SESSION['image_index'] = $imgIndex;
?>