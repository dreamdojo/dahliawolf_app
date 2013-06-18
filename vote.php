<?
$pageTitle = "Vote";
include "head.php";
include "header.php"; 

if (empty($_data['posts'])) {
	?>
<div style="background-color:#616161; height:796px;">       
        <center><a href="#" onclick="showpostitdiv()"><img src="skin/img/vote-soon.jpg" /></a></center>
         </div><div style="background-color:black; height:400px">       
</div>
	<?
}
else {
?>
<div id="vote-box">
       <div id="vb-left-buffer">
   		</div>
       
       <div id="wild-section">
       	<img src="/skin/img/bar.png" id="left-block"/>
        <img src="/skin/img/like.png" id="wild4"/>
       </div>
		<div id="product-section">
			<?
			foreach ($_data['posts'] as $i => $post) {
				$vote_href = '/action/vote.php?vote_period_id=' . $post['vote_period_id'] . '&amp;posting_id=' . $post['posting_id'];
				$unvote_href = '/action/unvote.php?vote_period_id=' . $post['vote_period_id'] . '&amp;posting_id=' . $post['posting_id'];
				
				if (!IS_LOGGED_IN) {
					$vote_href = 'javascript:loginscreen(\'login\');';
					$unvote_href = $vote_href;
				}
				?>
				<div class="vote-prod hide<?= !empty($post['is_voted']) ? ' voted' : '' ?>" id="prod-<?= $i ?>" data-posting_id="<?= $post['posting_id'] ?>" data-vote_period_id="<?= $post['vote_period_id'] ?>">
					<a href="<?= $vote_href ?>" rel="vote" data-undo_href="<?= $unvote_href ?>"></a>
					<div class="pop">
						<p class="heading">
							<span>
								Thank You<br />For Voting
							</span>
						</p>
						<p class="message">
							<span>
								Pre-Order &amp;<br />Get 50% Off
							</span>
						</p>
					</div>
					<img src="<?= $post['image_url'] ?>" />
					<div class="prod-info" id="pi-<?= $i ?>">
						<div class="prod-votes"><span id="vote-count-<?= $post['posting_id'] ?>"><?= $post['votes'] ?></span> <span class="label">Votes</span></div>
						<div class="prod-inspure"><?= $post['username'] ?></div>
					</div>
				</div>
				<?
			}
			?>
		</div>
       <div id="next-section">
       	<img src="/skin/img/right.png" id="binger"/>
       	<img src="/skin/img/arrow.png" id="rarrow" />
       </div>
  </div>
  <div id="vb-right-buffer">
   </div>

<script>
   <?
   /*
   var products_max = 6;
   var index = 0;
   
   var products = new Array();
      	products[0] = new Array();
	products[0].like = "javascript:vote_yes('1879', 'A_L1879', 'R_L1879');";
	products[0].unlike = "javascript:vote_no('1879', 'R_L1879', 'A_L1879');";
	products[0].likes = 2;
	products[0].isliked = 0;
      	products[1] = new Array();
	products[1].like = "javascript:vote_yes('1878', 'A_L1878', 'R_L1878');";
	products[1].unlike = "javascript:vote_no('1878', 'R_L1878', 'A_L1878');";
	products[1].likes = 1;
	products[1].isliked = 0;
      	products[2] = new Array();
	products[2].like = "javascript:vote_yes('1877', 'A_L1877', 'R_L1877');";
	products[2].unlike = "javascript:vote_no('1877', 'R_L1877', 'A_L1877');";
	products[2].likes = 1;
	products[2].isliked = 0;
      	products[3] = new Array();
	products[3].like = "javascript:vote_yes('1874', 'A_L1874', 'R_L1874');";
	products[3].unlike = "javascript:vote_no('1874', 'R_L1874', 'A_L1874');";
	products[3].likes = 3;
	products[3].isliked = 0;
      	products[4] = new Array();
	products[4].like = "javascript:vote_yes('1872', 'A_L1872', 'R_L1872');";
	products[4].unlike = "javascript:vote_no('1872', 'R_L1872', 'A_L1872');";
	products[4].likes = 4;
	products[4].isliked = 0;
      	products[5] = new Array();
	products[5].like = "javascript:vote_yes('1871', 'A_L1871', 'R_L1871');";
	products[5].unlike = "javascript:vote_no('1871', 'R_L1871', 'A_L1871');";
	products[5].likes = 4;
	products[5].isliked = 0;
    */
    ?>
	var products_max = <?= count($_data['posts']) ?>;
	var index = 0;
	var products = new Array();
	<?
	foreach ($_data['posts'] as $i => $post) {
		?>
		products[<?= $i ?>] = new Array();
		//products[5].like = "javascript:vote_yes('1871', 'A_L1871', 'R_L1871');";
		//products[5].unlike = "javascript:vote_no('1871', 'R_L1871', 'A_L1871');";
		products[<?= $i ?>].likes = <?= $post['total_votes'] ?>;
		products[<?= $i ?>].isliked = <?= !empty($post['is_voted']) ? 1 : 0 ?>;
		<?
	}
	?>

   //***************** INITIALIZE VOTE SECTION ************************************
   $('#prod-'+index).css('left', 0);
   $('#pi-'+index).show();
   if(products[index].isliked){
		$('#wild4').attr('src', '/skin/img/wild_like.png');
		$('#wild4').attr('onclick', products[index].unlike);
	}else{
		$('#wild4').attr('src', '/skin/img/like.png');
		$('#wild4').attr('onclick', products[index].like);
	}
   
   //*************** BIND TO NEXT BUTTIN ******************************************
   $('#next-section').bind('click', function(){
		$('#pi-'+index).hide();
		$('#prod-'+index).stop(true, false).animate({ left: '-'+1000 }, 1000, function(){
			$('#prod-'+index).css('left', 1000);
		});
		index++;
		if(index>=products_max){
			index = 0;
		}
		$('#prod-'+index).stop(true, true).animate({ left: 0 }, 1000, function(){
			if(products[index].isliked){
				$('#wild4').attr('src', '/skin/img/wild_like.png');
				$('#wild4').attr('onclick', products[index].unlike);
			}else{
				$('#wild4').attr('src', '/skin/img/like.png');
				$('#wild4').attr('onclick', products[index].like);
			}
			$('#pi-'+index).fadeIn(100);
		});
   });
   
   function vote_yes(Id, A_L, R_L){
  		products[index].likes++;
		$('#wild4').attr('src', '/skin/img/wild_like.png');
		$('#vote-count-'+index).html(products[index].likes+' VOTES');
		$('#wild4').attr('onclick', products[index].unlike);
		ADD_LIKE(Id, A_L, R_L);
   }
   function vote_no(Id, R_L, A_L){
  		products[index].likes--;
		$('#wild4').attr('src', '/skin/img/like.png');
		$('#vote-count-'+index).html(products[index].likes+' VOTES');
		$('#wild4').attr('onclick', products[index].like);
		REM_LIKE(Id, R_L, A_L);
   }
   
   
   $('#wild4').hover(function(){
   	   $('#wild4').css('opacity', .8);
   },function(){
	   $('#wild4').css('opacity', 1);
   });
   $('#rarrow').hover(function(){
   	   $('#rarrow').attr('src', '/skin/img/arrow_rollover.png');
   },function(){
	   $('#rarrow').attr('src', '/skin/img/arrow.png');
   });
   </script>
<?
}
?>
<style type="text/css">
	html {
		background: #000;
	}
</style>
<?php include "footer.php" ?>
