<?php
$img_array = array('/post-details.php' => 'guide_vote.png', '/post-bank.php' => 'guide_post.png', '/explore.php' => 'guide_shop.png');


$img = $img_array[$self];

?>
<style>
#guide-pop-overlay{position:fixed; left:0px; top:0px; width:100%; height:100%; z-index:10000009;background-color: #000;opacity: .8;}
#guide-pop{background-color:#101010; border:#c2c2c2 thin solid; box-shadow:#666 2px; position:fixed; left:50%; top:0px; margin-left: -40%;margin-top: 4%; z-index: 100000000000;width: 80%; height:90%; border-radius: 1em;}
#guide-pop img{ margin-top:3%;width:98%; margin-left:1%; position:relative;}
</style>
<div id="guide-pop-overlay"></div>
<div id="guide-pop">
	<img src="images/<?= $img ?>">
</div>

<script>
$('#guide-pop, #guide-pop-overlay').bind('mousedown', function(){
	$('#guide-pop, #guide-pop-overlay').fadeOut(200);
})
</script>