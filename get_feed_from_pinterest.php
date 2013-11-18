<?php
session_start();

function getimg($url)	{
	$doc = new DOMDocument();
	@$doc->loadHTML($url);
	$tags = $doc->getElementsByTagName('img');
	foreach ($tags as $tag) {
	   return $tag->getAttribute('src');
	}
}

function cleanit($text) {
	return strip_tags(stripslashes($text));
}
if( !empty($_POST['pinterest_user']) ) {
	$pinterest_user = $_POST['pinterest_user'];
}

if (!empty($pinterest_user))	{
	if(isset($pinterest_user))	{
		$ch = curl_init("http://pinterest.com/".$pinterest_user."/feed.rss");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		$data = curl_exec($ch);
		curl_close($ch);

		$xml = new SimpleXmlElement($data, LIBXML_NOCDATA);
		$cnt = count($xml->channel->item);

		for($i=0; $i<$cnt; $i++){
			$img    = $xml->channel->item[$i]->description;
			$title  = $xml->channel->item[$i]->title;
			$description 		= split("<p>",$img);
			$fulldescription 	= substr($description[2], 0, -4);
			$unixdate 			= strtotime($xml->channel->item[$i]->pubDate);
			$source 			= "http://www.pinterest.com";
			$hashash 			= strpos($img,$hashtag);
			$theurl 			= getimg($img);
			$caption 			= $fulldescription;
			$description 		= cleanit($caption);
			$sourceurl 			= cleanit($source);
			$url 				= cleanit($theurl);	
			$big_url	 		= $url;//substr($url, 0, -6).substr($url,-4);
			$big_url			= str_replace('192', '736', $big_url);
			$money[] 			= array('images' => array('thumbnail' => array('url' => $url), 'standard_resolution' => array('url' => $big_url), 'source' => array('src' => 'pinterest')));
		}
		header('Content-Type: application/json');
		echo json_encode(array('data' => $money));
		//return;
	}
}else{
	echo 'error duh';
}
?>

