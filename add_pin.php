<?
session_start();
define('IS_LOGGED_IN', !empty($_SESSION) && !empty($_SESSION['user']) && !empty($_SESSION['token']));

if (IS_LOGGED_IN) {
	require $_SERVER['DOCUMENT_ROOT'] . '/includes/php/functions-api.php';
	
	$user_id = $_SESSION['user']['user_id'];
	$upload_dir = '/postings/uploads/';
	$source = 'http://' . $_SERVER['HTTP_HOST'] . $upload_dir;
	
	// get contents of remote file & save
	$imagename = time() . basename($_GET['image_src']);
	$image_url = $_SERVER['DOCUMENT_ROOT'] . $upload_dir . $imagename;
	
	// Grab and save remote image
	$image = @file_get_contents($_GET['url']);
	
	if ($image) {
		file_put_contents($image_url, $image);
		$dimensions = @getimagesize($image_url);
		
		// make api to add_post_image
		$params = array(
			'imagename' => $imagename
			, 'domain' => urldecode($_GET['domain'])
			, 'attribution_url' => urldecode($_GET['sourceurl'])
			, 'source' => $source
			, 'user_id' => $user_id
			, 'description' => $_GET['description']
			, 'dimensionsX' => $dimensions[0]
			, 'dimensionsY' => $dimensions[1]


		);

        if(isset($_GET['t']))$params['t'] = true;

        //var_dump($_GET);
        //var_dump($params);

		$data = api_call('posting', 'add_post_image', $params, true);

		$data = json_decode($data);
        /*
        //http://www.dahliawolf.com/add_pin?
        url=http%3A//images02.nastygal.com/resources/nastygal/images/products/processed/27104.0.browse-m.jpg&
        sourceurl=http%3A//www.nastygal.com/clothes/&
        domain=www.nastygal.com&
        description=posted from nasty gal&
        title=Clothes%20at%20Nasty%20Gal
        */
	}
}else{
	echo 'YOU NEED TO LOGIN TO DAHLIAWOLF TO POST IMAGE';
}?>

<? if(IS_LOGGED_IN): ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Untitled Document</title>
</head>
<style>
body{text-align:center;}
#contentFrame{width:100%; height:95%; margin: 0px auto; background-color:#e6e6e6; border:#b9b9b9 thin solid;}
.titleHead{margin-top: 10px;font-size: 20px; color:#838383;}
#timer{ right: 20px;color: red;font-size: 40px;background-image: url(/images/popCountCircle.png);background-size: 100% 100%;float: left;height: 100px;width: 90px;background-repeat: no-repeat;margin-left: 29px; text-align:center;}
.dwTitle{height: 47px; margin-top:5px;}
.dwTitle img{height: 22px;margin-top: 8px;}
.stuff{text-align: left;width: 280px;margin: 0px auto; height:100px; overflow:hidden;}
#clock{margin-top: 26px;}
.clickHere{font-size: 17px;text-transform: uppercase;color: #666666;margin-top: 15px;}
.clickHere a{color:#c96577}
.imgFrame{height:100%; width: 150px; overflow:hidden; text-align:center; float:left;}
.imgFrame img{height: 100%; float:left;}
</style>
<body>
<div id="contentFrame">
    <div class="titleHead">COOL PIC, KEEP'M COMIN ;)</div>
    <div class="dwTitle"><img src="http://www.dahliawolf.com/images/popTitle.png"></div>
    <div class="stuff">
        <div class="imgFrame"><img src="<?= $_GET['url'] ?>" /></div>
        <div id="timer"><p id="clock">10</p></div>
    </div>
    <div class="clickHere">Click <a href="http://www.dahliawolf.com/post/<?= $data['data']['posting_id'] ?>" target="_none">HERE</a> to view post</div>
</div>
</body>
</html>
<script>
time = 10;

setInterval(function(){
	time--;
	document.getElementById('clock').innerHTML = time;
	if(time < 0){
		window.close();
	}
}, 1000);
</script>
<? endif ?>