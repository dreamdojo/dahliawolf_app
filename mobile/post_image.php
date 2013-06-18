
<? 
include 'action/functions-api.php';

if(!empty($_GET['id']) && $_GET['id'] > 0){
	$params = array(
			'id' => $_GET['id'],
			'status' => 'Approved',
		);
	$data = api_call('feed_image', 'get_feed_image', $params, true);
	
	$data = $data['data'];
}else{
	die();
}

?>
<style>
    textarea, input{padding:0px;}
	.pop-com{width: 91%;margin-top: 5%; min-height: 25% !important; height:25%; font-size:1em;}
	#sub-pop-butt{border: none;cursor: pointer;width: 36.5%; background-color:#F00; margin-top: 7%;}
	#back-butt{border: none;cursor: pointer;width: 48.5%; float:left; margin-left: 1%; height:50%; background-color:#c2c2c2;}
	#swipe-me{width:100%;}
	.options-box{left: 1%; bottom: 50px; width: 100%;background-color: #FFF;height: 100%;}
	.Form{padding:0px;}
	#thePinForm{height: 100%;}
</style>

<div id="opt-box" class="options-box">
    <form action="#" onSubmit="return postItem.postImage(<?= $_GET['id'] ?>, $('#pop-com-<?= $_GET['id'] ?>').val())" id="thePinForm" method="POST" class="Form PinForm" enctype="multipart/form-data">
    <textarea id="pop-com-<?= $_GET['id'] ?>" class="pop-com" name="description" placeholder="TAG THIS IMAGE, YO" ></textarea>
    <input type="image" src="images/pi-post-img.png" id="sub-pop-butt" >
    <input type="submit" style="display:none" id="form-sub">
    <input type="hidden" name="id" value="<?= $_GET['id'] ?>" />  
     </form>
</div>