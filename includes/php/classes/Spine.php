<?
class Spine {
	private $image_dir = '/postings/uploads/';
	
	private $image_dimensions = array();
	
	private $pad_h = 40;
	private $pad_v = 45;
	private $margin = 4;
			
	private $h = 0;
	private $v = 0;
	
	private $options = array(
		'bare' => false
		, 'share' => false
	);
	
	public function __construct($options = array()) {
		$this->options = array_merge($this->options, $options);
		
		$this->image_dimensions = array(
			array(264, 372)
			, array(136, 280)
			, array(180, 280)
			, array(136, 187)
			, array(190, 218)
			, array(195, 347)
			, array(387, 224)
			, array(196, 174)
			, array(282, 210)
			, array(237, 268)
			, array(258, 195)
			, array(193, 328)
			, array(367, 270)
			, array(225, 166)
			, array(330, 256)
			, array(147, 256)
			, array(228, 166)
		);
		/*$this->image_dimensions = array(
			array(440, 620)
			, array(228, 468)
			, array(300, 468)
			, array(228, 312)
			, array(318, 364)
			, array(326, 578)
			, array(646, 374)
			, array(328, 290)
			, array(470, 350)
			, array(396, 448)
			, array(430, 326)
			, array(322, 548)
			, array(612, 448)
			, array(376, 278)
			, array(550, 428)
			, array(246, 428)
			, array(380, 278)
		);
		foreach ($this->image_dimensions as $i => $dimensions) {
			list($width, $height) = $dimensions;
			
			$this->image_dimensions[$i] = array(floor($width * 0.6), floor($height * 0.6));
		}*/
		
		$this->h = $this->pad_h + $this->margin;
		$this->v = $this->pad_v + $this->margin;
	}
	
	public function get_images($posts) {
		$images = array();
		if (!empty($posts)) {
			foreach ($posts as $i => $post) {
				//$url = $this->image_dir . $post['imagename'];
				$url = $post['source'] . $post['imagename'];
				
				$image = $post;
				$image['url'] = $url;
				
				// Check if file exists
				//if (file_get_contents($url,0,null,0,1)) {
					if (empty($post['width'])) {
						$image_path = $_SERVER['DOCUMENT_ROOT'] . str_replace('http://' . $_SERVER['SERVER_NAME'], '', $url);
						list($width, $height, $type, $attr) = getimagesize($image_path);
						
						$image = array_merge($image,
							array(
								'width' => $width
								, 'height' => $height
							)
						);
					}
					
					array_push($images, $image);
				//}
			}
		}
		
		return $images;
	}
	
	public function output_explore($posts, $class = 'explore') {
		//$images = $this->get_images($posts);
		
		$is_partial = empty($class);
		?>
		<div class="explore">
			<?
			if (empty($posts)) {
				if (!$is_partial) {
					?>
					<p>No posts found.</p>
					<?
				}
			}
			else {
				?>
				<ul class="posts">
					<?
					foreach ($posts as $i => $post) {
						$vote_href = '/action/vote.php?vote_period_id=' . $post['vote_period_id'] . '&amp;posting_id=' . $post['posting_id'];
						$unvote_href = '/action/unvote.php?vote_period_id=' . $post['vote_period_id'] . '&amp;posting_id=' . $post['posting_id'];
						
						if (!IS_LOGGED_IN) {
							$vote_href = 'javascript:loginscreen(\'login\');';
							$unvote_href = $vote_href;
						}
						?>
						<li class="<?= !empty($post['is_voted']) ? ' voted' : '' ?>" data-posting_id="<?= $post['posting_id'] ?>" data-vote_period_id="<?= $post['vote_period_id'] ?>">
							<div class="user">
								<p class="avatar">
									<img src="<?= $post['avatar'] ?>&amp;width=50" alt="<?= $post['username'] ?>" />
								</p>
								<p>
									Inspiration by,
									<a href="<?= $this->user_profile_href($post['username']) ?>" class="username"><?= $post['username'] ?></a><?
									if (!empty($post['location'])) {
										?>, <span class="location"><?= $post['location'] ?></span>
										<?
									}
									?>
								</p>
							</div>
							<div class="image">
								<img src="<?= $post['image_url'] ?>" />
								<?
								/*
								<img src="http://content.dahliawolf.com/shop/product/image.php?file_id=2&width=240&height=360" />
								*/
								?>
							</div>
							<div class="info">
								<p class="description"><?= $post['description'] ?></p>
								<p class="votes">
									<span id="vote-count-<?= $post['posting_id'] ?>"><?= $post['votes'] ?></span>
									<a href="<?= $vote_href ?>" rel="vote" data-undo_href="<?= $unvote_href ?>">Vote</a>
								</p>
							</div>
						</li>
						<?
					}
					?>
				</ul>
				<?
			}
			?>
		</div>
		<?
	}
	
	private function vote_href($vote_period_id, $posting_id, $un = false) {
		if (IS_LOGGED_IN) {
			return CR . '/action/' . ($un ? 'un' : '') . 'vote.php?vote_period_id=' . $vote_period_id . '&amp;posting_id=' . $posting_id;
		}
		return 'javascript:loginscreen(\'login\');';
	}
	
	public function output($posts, $class = 'spine', $url = '/spine-chunk.php') {
		$images = $this->get_images($posts);
		$this->output_images($images, $class, $url);
	}

	public function output_images($images, $class, $url) {
		$is_partial = empty($class);
		
		if (empty($images)) {
			if (!$is_partial) {
				?>
				<div class="<?= $class ?>" style="padding-left: 0;">
					<p>No posts founds.</p>
				</div>
				<?
			}
		}
		else {
			if (!$is_partial) {
				?>
				<div class="<?= $class ?>"<?= !empty($url) ? ' data-url="' . $url . '"' : '' ?>>
				<?
			}
			foreach ($images as $i => $image) {
				$mod = $i % 17;
				
				if ($mod == 0 || $mod == 8 || $mod == 13) {
					if ($i > 0) {
						?></ul><?
					}
					?><ul class="images mod-<?= $mod ?>"><?
				}
				
				$details_url = CR . '/post-details.php?posting_id=' . $image['posting_id'];
				$full_details_url = $details_url;
				$full_image_url = $image['url'];
				
				$like_href = !empty($_SESSION['user']) ? '/action/like.php?posting_id=' . $image['posting_id'] : '';
				$unlike_href = !empty($_SESSION['user']) ? '/action/unlike.php?posting_id=' . $image['posting_id'] : '';
				
				if (!IS_LOGGED_IN) {
					$like_href = 'javascript:loginscreen(\'login\');';
					$unlike_href = $like_href;
				}
				
				$profile_url = $this->user_profile_href($image['username']);
				?><li class="posting-<?= $image['posting_id'] ?> image-<?= $mod ?><?= !empty($image['is_liked']) ? ' liked' : '' ?>" data-posting_id="<?= $image['posting_id'] ?>">
					<? if(!empty($_SESSION['user']) && $image['user_id'] == $_SESSION['user']['user_id']): ?> <a href="/action/delete_post.php?posting_id=<?= $image['posting_id'] ?>"><div class="del-post">delete</div></a><? endif ?>
                    <div class="image">
						<a href="<?= $details_url ?>" class="image" rel="modal">
							<?
							list($target_width, $target_height) = $this->image_dimensions[$mod];
							
							$target_ratio = $target_width / $target_height;
							$ratio = $image['width'] / $image['height'];
							
							if ($target_ratio >= $ratio) {
								$width = $target_width;
								$height = ceil($image['height'] * ($target_width / $image['width']));
							}
							else {
								$height = $target_height;
								$width = ceil($image['width'] * ($target_height / $image['height']));
							}
							/*data-width="<?= $image['width'] ?>"*/
							
							if ($this->options['bare']) {
								?>
								<img src="<?= $image['url'] ?>" data-src="<?= $image['url'] ?>" alt="<?= $image['description'] ?>" />
								<?
							}
							else {
								?>
								<img class="lazy" src="/images/blank.gif" data-src="<?= $image['url'] ?>" width="<?= $width ?>" height="<?= $height ?>" alt="<?= $image['description'] ?>" style="margin-top: -<?= floor(($height - $target_height) / 2) ?>px; margin-left: -<?= floor(($width - $target_width) / 2) ?>px;" />
								<?
							}
							?>
						</a>
						
						<p class="wild-4">
							<a href="<?= $like_href ?>" rel="like" data-undo_href="<?= $unlike_href ?>">Wild 4</a>
						</p>
					</div>
					
					<p class="username"><a href="<?= $profile_url ?>"><?= $image['username'] ?></a></p>
					
					<?
					if ($this->options['share']) {
						?>
						<ul class="share">
							<li class="facebook"><a href="https://www.facebook.com/sharer.php?u=<?= $full_details_url ?>" target="_blank">Facebook</a></li>
							<li class="pinterest"><a href="http://pinterest.com/pin/create/button/?url=<?= $full_image_url ?>" class="pin-it-button" count-layout="horizontal" target="_blank">Pinterest</a></li>
							<li class="twitter"><a href="https://twitter.com/share?url=<?= $full_details_url ?>" target="_blank">Twitter</a></li>
						</ul>
						<?
					}
					?>
					
					<p class="like">
						<span class="like-count-<?= $image['posting_id'] ?>"><?= $image['total_likes'] ?></span>
						<a href="<?= $like_href ?>" id="link-<?= $image['posting_id'] ?>" rel="like" data-undo_href="<?= $unlike_href ?>">Like</a>
					</p>
				</li><?
			}
			?>
			</ul>
			<?
			if (!$is_partial) {
				?>
				</div>
				<?
			}
		}
	}
	
	public function output_css() {
		$image_dimensions = $this->image_dimensions;
		$h = $this->h;
		$v = $this->v;
		?>
		.spine ul.images.mod-0 {
			height: <?= $image_dimensions[0][1] + $image_dimensions[4][1] + $image_dimensions[6][1] + (3 * $v) ?>px;
		}
		.spine ul.images.mod-8 {
			height: <?= $image_dimensions[8][1] + $image_dimensions[11][1] + (2 * $v) ?>px;
			margin-left: <?= floor($h * .75) ?>px;
		}
		.spine ul.images.mod-13 {
			height: <?= $image_dimensions[13][1] + $image_dimensions[15][1] + (2 * $v) ?>px;
			margin-left: <?= floor($h * -0.25) ?>px;
		}
		<?
		$position_map = array(
			0 => array(0, 0)
			, 1 => array($image_dimensions[0][0] + $h, 0)
			, 2 => array($image_dimensions[0][0] + $image_dimensions[1][0] + (2 * $h), 100) 
			, 3 => array($image_dimensions[0][0] + $h, $image_dimensions[1][1] + $v)
			, 4 => array($image_dimensions[0][0] - $image_dimensions[4][0], $image_dimensions[0][1] + $v)
			, 5 => array($image_dimensions[0][0] + $h, $image_dimensions[1][1] + $image_dimensions[3][1] + (2 * $v))
			, 6 => array($image_dimensions[0][0] - $image_dimensions[6][0], $image_dimensions[0][1] + $image_dimensions[4][1] + (2 * $v))
			, 7 => array($image_dimensions[6][0] + $image_dimensions[7][0] + (2 * $h) - ($image_dimensions[6][0] - $image_dimensions[0][0])
				, $image_dimensions[0][1] + $image_dimensions[4][1] + $image_dimensions[6][1] + (2 * $v) - $image_dimensions[7][1])
			
			, 8 => array(0, 0)
			, 9 => array($image_dimensions[8][0] + $h, 0)
			, 10 => array($image_dimensions[8][0] - $image_dimensions[11][0] - $image_dimensions[10][0] - $h, $image_dimensions[8][1] + $v)
			, 11 => array($image_dimensions[8][0] - $image_dimensions[11][0], $image_dimensions[8][1] + $v)
			, 12 => array($image_dimensions[8][0] + $h, $image_dimensions[9][1] + $v)
			
			, 13 => array(0, 0)
			, 14 => array($image_dimensions[13][0] + $h, 0)
			, 15 => array($image_dimensions[13][0] - $image_dimensions[15][0], $image_dimensions[13][1] + $v)
			, 16 => array($image_dimensions[13][0] + $h, $image_dimensions[14][1] + $v)
		);
		foreach ($image_dimensions as $i => $dimensions) {
			$mod = $i % 17;
			
			if (!empty($position_map[$mod])) {
				list($left, $top) = $position_map[$mod];
				?>
				.spine ul.images li.image-<?= $mod ?> {
					left: <?= $left ?>px;
					top: <?= $top ?>px;
				}
				<?
			}
			
			list($width, $height) = $dimensions;
			?>
			.spine ul.images li.image-<?= $mod ?> .image {
				width: <?= $width ?>px;
				height: <?= $height ?>px;
			}
			<?
		}
	}
	
	private function user_profile_href($username) {
		return CR . '/profile.php?username=' . $username;
		// return CR . '/' . $username;
	}
}
?>