<?
if (empty($_GET['posting_id'])) {
	die();
}
	require $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';
	require $_SERVER['DOCUMENT_ROOT'] . '/includes/php/initial-calls.php';

//print_r($_data);
?>
<div class="post-details-container posting-<?= $_data['post']['posting_id'] ?><?= !empty($_data['post']['is_liked']) ? ' liked' : '' ?>" data-posting_id="<?= $_data['post']['posting_id'] ?>">
	<a class="close"><img src="/skin/img/closegray.png" width="22" height="24" class="close" /></a>
	<div class="GrayContainer clearfix sysPinItemContainer">
		<div style="clear:both"></div>
		<div class="ImgLink PinImage">
			<img alt="Rep Yo Steez" class="pinCloseupImage sysPinImg" src="<?= $_data['post']['image_url'] ?>" width="<?= $_data['post']['width'] ?>">
		</div>
		<div style="padding-top: 3px; background-color: #b5b5b5;">
			<div style="height:30px; padding: 0 30px;">
				<div style="float:left; font-size: 14px; font-weight: bold; text-transform: uppercase; padding-top: 5px;">
					<a href="/<?= $_data['post']['username'] ?>"><?= $_data['post']['username'] ?></a>
				</div>
				<div style="float:right; font-size: 12px; font-weight: bold;">
					<span class="like-count-<?= $_data['post']['posting_id'] ?>"><?= $_data['post']['likes'] ?></span>
					<?
					//<a href="javascript:void(0)" id="LADD1907"><img src="/skin/img/broken.png" align="absmiddle" /></a>
					$like_href = '/action/like.php?posting_id=' . $_data['post']['posting_id'];
					$unlike_href = '/action/unlike.php?posting_id=' . $_data['post']['posting_id'];
					
					if (!IS_LOGGED_IN) {
						$like_href = 'javascript:loginscreen(\'login\');';
						$unlike_href = $like_href;
					}
					?>
					<a href="<?= $like_href ?>" rel="like" data-undo_href="<?= $unlike_href ?>">Wild 4</a>
				</div>
			</div>
		</div>
		<?
		// Owner
		if (!empty($_SESSION['user']) && $_SESSION['user']['user_id'] == $_data['post']['user_id']) {
			?>
			<div class="owner">
				<form action="/action/update_post.php" class="edit" method="post">
					<fieldset>
						<ul class="fields">
							<li>
								<label for="posting-description">Edit Description</label>
								<textarea id="posting-description" name="description"><?= $_data['post']['description'] ?></textarea>
							</li>
						</ul>
						<input type="hidden" name="posting_id" value="<?= $_data['post']['posting_id'] ?>" />
						<input type="submit" value="Edit Description" />
					</fieldset>
				</form>
			</div>
			<?
		}
		?>
		<div class="sysPinCmntList_Full PinComments">
			<?
			if (!empty($_data['comments'])) {
				foreach ($_data['comments'] as $comment) {
					$profile_url = '/profile.php?username=' . $comment['username'];
					$avatar_url = $comment['avatar'] . '&amp;width=44';
					?>
                    <? $hashified = socialize($comment['comment']); ?>
                    <div class="sysPinCmntItemContainer comment">
						<a class="CommenterImage" href="<?= $profile_url ?>"><img alt="<?= $comment['username'] ?>" src="<?= $avatar_url ?>"></a>
						<p class="CommenterMeta"><a class="CommenterName" href="<?= $profile_url ?>"><?= $comment['username'] ?></a> <span style="font-size:10px;color: #000;">SAYS</span><br/><?=  $hashified ?></p>
						<div class="cl"></div>
					</div>
					<?
				}
			}
			?>
		</div>
		<div id="comyes" style="<?= !isset($_GET['posted']) ? 'display:none; ' : '' ?>color:#3C0; margin-left:50px; padding-top:10px; font-size:14px;">Your comment has been posted.</div>
		<div style="text-align:center; padding-top: 15px;"><img src="/skin/img/leaveacomment.png" /></div>
		<div class="PinAddComment" id="PinAddComment">
			<div class="InputContainer">
				<form id="comform" method="post" action="/action/comment.php">
					<textarea id="thecomment" name="comment" class="CloseupComment socialize"></textarea>
                    <div id="comerrors" style="color:#cb0000; padding:5px;"></div>
					<div style="text-align: center;">
                    	<? if(!empty($_SESSION['user']) && !empty($_SESSION['user']['user_id'])): ?>
                        	<input id="publishButton" type="submit" value="PUBLISH" class="pub-butt"/>
                        <? else: ?>
                        	<input type="button" value="PUBLISH" class="pub-butt" onclick="loginscreen('login')"/>
						<? endif ?>
                    </div>
					<input type="hidden" name="posting_id" value="<?= $_data['post']['posting_id'] ?>" />
				</form>
			</div>
		</div>
		<?
		if (!empty($_data['post']['attribution_url'])) {
			$url_parts = parse_url($_data['post']['attribution_url']);
		}
		?>
		<div id="pin-from">
			<p class="colorless PinnerStats">Posted <?= ago(strtotime($_data['post']['created'])) ?> ago
				<?
				if (!empty($url_parts['host'])) {
					?>
					from <a href="<?= $_data['post']['attribution_url'] ?>" target="_blank" rel="nofollow"><?= $url_parts['host'] ?></a>
					<?
				}
				?>
			</p>
		</div>
		<div class="PinActivity">
			<h4><?= count($_data['post_likes']) ?> Likes</h4>
			<?
			if (!empty($_data['post_likes'])) {
				foreach ($_data['post_likes'] as $i => $post_like) {
					$profile_url = '/profile.php?username=' . $post_like['username'];
					$avatar_url = $post_like['avatar'] . '&amp;width=30';
					?>
					<a class="CommenterImage" href="<?= $profile_url ?>"><img alt="<?= $post_like['username'] ?>" src="<?= $avatar_url ?>" /></a>
					<?
				}
			}
			?>
		</div>    
	</div>
</div>

<script>
$('.socialize').bind('click', pplFinder.start);
</script>

<?
if (!isset($_GET['ajax'])) {
	include $_SERVER['DOCUMENT_ROOT'] . "/footer.php";
}
?>