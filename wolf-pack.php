<?
$pageTitle = "Wolf Pack";
include $_SERVER['DOCUMENT_ROOT'] . "/head.php";
include $_SERVER['DOCUMENT_ROOT'] . "/header.php";
foreach($friends as $friend){
	$following[$friend['user_id']] = true;
}
?>
<div class="packlist">
	<div id="pack-title">
		<p style="width:250px;display: inline-block;margin-bottom: 10px;">PACK LEADERS</p>
		<div class="wolf-pack-user-rank"><img src="/skin/img/yourrank.png" /><?= $_data['rank'] ?></div>
	</div>
    <div id='wolfpack'>
    	<?
    	if (!empty($_data['users'])) {
    		foreach ($_data['users'] as $i => $user) {
    			//$profile_url = '/profile?username=' . $user['username'];
    			$profile_url = '/' . $user['username'];
    			?>
    			<div class='wolfpack-user-block' style='margin-left:<?= ($i % 3) * 45 ?>px'>
		    		<div class='wolfpack-box-<?= $i % 2 ? 'even' : 'odd' ?>'>
		    			<div class='prof-frame <? echo ($user['username'] == $_SESSION['user']['username'] ? 'selfie' : '') ?>'>
		    				<a href='<?= $profile_url ?>'><img class='wolfpack-user-image' src='<?= $user['avatar'] ?>&amp;width=190'></a>
		    			</div>
		    			<div class='wolfpack-user-data'>
		    				<div class='wolfpack-user-name'>
		    					<a href='<?= $profile_url ?>'><?= $user['username'] ?></a>
		    				</div>
		    				<div class='wolfpack-user-points'>POINTS <?= $user['points'] ?></div>
		    				<div class='wolfpack-user-rank'><p class='user-rank'>RANK</p><?= $user['rank'] ?></div>
                            <div class="wolf-pack-button">
                            	<? if (IS_LOGGED_IN && $user['user_id'] != $_SESSION['user']['user_id']): ?>
										<? if( !empty($following[$user['user_id']]) ){ 
												$is_followed = true;
											}else{
												$is_followed = false;
											}
										
										?>
                                        <div style="text-align: center;" class="sysBoardFollowAllButton<?= $is_followed ? ' hidden' : '' ?>" id="SFADD71">
											<a href="/action/follow?user_id=<?= $user['user_id'] ?>" class="Button12 Button OrangeButton" rel="follow">
												<strong>Follow</strong><span></span>
											</a>
										</div>
										<div style="text-align: center;" class="sysBoardUnFollowAllButton<?= !$is_followed ? ' hidden' : '' ?>" id="SFREM71">
											<a href="/action/unfollow?user_id=<?= $user['user_id'] ?>" class="Button12 Button OrangeButton disabled" rel="unfollow">
												<strong>Unfollow</strong><span></span>
											</a>
										</div>
								<? endif ?>
                            </div>
		    			</div>
		    		</div>
		    	</div>
    			<?
			}
		}
		?>
    </div>
</div>
<?
include $_SERVER['DOCUMENT_ROOT'] . "/footer.php";
?>