<?
class Spine {
	private $image_dir = '/postings/uploads/';
	
	
	private $pad_h = 40;
	private $pad_v = 45;
	private $margin = 4;
			
	private $h = 0;
	private $v = 0;
	
	private $image_dimensions = array(
		array(330, 496)
		, array(300, 450)
		, array(390, 390)
		, array(360, 540)
		, array(420, 633)
		, array(450, 645)
		, array(300, 450)
		, array(334, 334)
		
		, array(390, 519)
		, array(360, 450)
		, array(450, 450)
		, array(420, 560)
		, array(300, 533)
		, array(334, 334)
		, array(390, 390)
		, array(365, 548)
	);
	
	private static $spine_limit = 16;
	private $spine_chunk_breaks = array(
		0 => 8
		, 8 => 8
	);
	
	private $options = array(
		'bare' => false
		, 'share' => false
	);
	
	public function __construct($options = array()) {
		$this->options = array_merge($this->options, $options);
		
		$this->h = $this->pad_h + $this->margin;
		$this->v = $this->pad_v + $this->margin;
	}
	
	public function get_spine_limit() {
		return self::$spine_limit;
	}
	
	public function get_images($posts) {
		$images = array();
		if (!empty($posts)) {
			foreach ($posts as $i => $post) {
				//$url = $this->image_dir . $post['imagename'];
				//$url = $post['source'] . $post['imagename'];
				$url = $post['image_url'];
				
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
        <style>
            .explore-prod-presale-box{position: absolute; width: 80px; height: 100px; right: 0px; bottom: 0px; background-color: #e6768e; color: #fff; line-height: 18px; text-align: center;}
            .explore-prod-presale-box div:nth-child(1){padding-top: 21px;}
            .explore-prod-presale-box div:nth-child(2){font-weight: bolder;}
            .explore-prod-presale-box div:nth-child(3){font-size: 11px;}
        </style>
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
						//var_dump($post);
						$vote_href = '/action/vote?vote_period_id=' . $post['vote_period_id'] . '&amp;posting_id=' . $post['posting_id'];
						$unvote_href = '/action/unvote?vote_period_id=' . $post['vote_period_id'] . '&amp;posting_id=' . $post['posting_id'];
						
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
								<div>
                                    <p style="margin: 0 0 .5em;">
                                        Inspiration by
                                        <a href="<?= $this->user_profile_href($post['username']) ?>" class="username"><?= $post['username'] ?></a><?
                                        if (!empty($post['location'])) {
                                            ?>, <span class="location"><?= $post['location'] ?></span>
                                            <?
                                        }
                                        ?>
                                    </p>
                                    <p class="view-inpirations" onclick="product.show(<?= $post['product_id'] ?>)">
                                    	<img src="images/cam-bam.png" />
                                        <div class="view-insp" onclick="product.show(<?= $post['product_id'] ?>)">VIEW INSPIRATIONS</div>
                                    </p>
                                </div>
							</div>
							<div class="image">
								<div class="spine-social-box" style="width: 37px;">
                                    <div class="spine-alien" onmouseover="$('this').children('.share').show();">
                                        <ul class="share">
                                            <div class="divot"></div>
                                            <div class="bridge"></div>
                                            <li class="facebook"><a href="#" onclick="sendMessageProduct(<?= $post['product_id'] ?>)">Facebook</a></li>
                           
                                            <li class="twitter"><a href="https://twitter.com/intent/tweet?original_referer=http://www.dahliawolf.com&url=http://www.dahliawolf.com/shop/product.php?id_product=<?= $post['product_id'] ?>" target="_blank">Tweet</a></li>
                                            
                                                             <li class="pinterest"><a href="http://pinterest.com/pin/create/button/?url=http://www.dahliawolf.com&media=<?= $post['image_url'] ?>" class="pin-it-button" count-layout="horizontal" target="_blank">Pin It</a></li>
                                        </ul>         
                                    </div>
                                </div>
                
                                <img src="<?= $post['image_url'] ?>" class="zoom-in" onclick="product.show(<?= $post['product_id'] ?>)" />
                                <? if($post['status'] === 'Pre Order'): ?>
                                    <a href="<?= CR ?>/shop/product?id_product=<?= $post['product_id'] ?>">
                                    <div class="explore-prod-presale-box">
                                        <div>Pre-Sale</div>
                                        <div>50% OFF</div>
                                        <div>Exp. July 31st</div>
                                    </div>
                                    </a>
                                <? endif ?>
								<div class="explore-prod-options-box">
                                        <? if($post['status'] == 'Live' || $post['status'] == 'Pre Order'): ?>
                                            <a href="<?= CR ?>/shop/product?id_product=<?= $post['product_id'] ?>">
                                                <div class="exp-buy-butt">
                                                    <p><?= ($post['status'] == 'Pre Order' ? 'PRE-ORDER' : 'BUY') ?></p>
                                                </div>
                                            </a>
                                        <? endif ?>
                                         <? if($post['status'] == 'Coming Soon' || $post['status'] == 'Live' || $post['status'] == 'Pre Order'): ?>
                                            <a href="/action/shop/add_item_to_wishlist.php?id_product=<?= $post['product_id'] ?>">
                                                <div class="exp-wl-butt<?= ($post['status'] != "Live" ? ' center-butt' : '') ?>" style="<?= ($post['status'] == 'Pre Order' ? 'margin-left: -160px;' : '') ?>">
                                                    <p>WISHLIST</p>
                                                </div>
                                            </a>
                                         <? endif ?>
                               </div>
							</div>
							<div class="info">
								<p class="description"><?= $post['product_name'] ?></p>
								<div class="exp-price" <?= ($post['status'] == 'Pre Order' ? 'style="text-decoration: line-through;"' : '') ?> >$<?= ( $post['status'] == 'Pre Order' ? money_format('%i', $post['price']*2) : money_format('%i', $post['price']) ) ?></div>
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
			return CR . '/action/' . ($un ? 'un' : '') . 'vote?vote_period_id=' . $vote_period_id . '&amp;posting_id=' . $posting_id;
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
				// Append timestamp so that dynamic loading doesn't load offset duplicates
				$url .= (strpos($url, '?') !== false ? '&' : '?') . 'timestamp=' . date('Y-m-d H:i:s');
				?>
				<div class="<?= $class ?>"<?= !empty($url) ? ' data-url="' . $url . '"' : '' ?>>
				<?
			}
			$num_images = count($images);
			foreach ($images as $i => $image) {
			//var_dump($image);
            $mod = $i % self::$spine_limit;
				
				//if (in_array($mod, array_keys($this->spine_chunk_breaks))) {
				if (!empty($this->spine_chunk_breaks[$mod])) {
					$num_images_left = $num_images - $i;
					$max_images_in_chunk = $this->spine_chunk_breaks[$mod];
					
					// If not full chunk
					$chunk_height = NULL;
					if ($num_images_left < $max_images_in_chunk) {
						$column_heights = array(
							'even' => 0
							, 'odd' => 0
						);
						foreach (range(0, ($num_images_left - 1)) as $j) {
							if ($j % 2 == 0) {
								$column_heights['even'] += $this->get_total_height($mod);
							}
							else {
								$column_heights['odd'] += $this->get_total_height($mod);
							}
						}
						$chunk_height = max($column_heights['even'], $column_heights['odd']);
						
						//$chunk_height = $this->get_total_height();
					}
					
					if ($i > 0) {
						?></ul><?
					}
					?><ul class="images mod-<?= $mod ?>"<?= !empty($chunk_height) ? ' style="height: ' . $chunk_height . 'px;"' : '' ?>><?
				}
				
				$details_url = CR . '/post-details?posting_id=' . $image['posting_id'];
				$full_details_url = $details_url;
				$full_image_url = $image['url'];
				
				$like_href = !empty($_SESSION['user']) ? '/action/like?posting_id=' . $image['posting_id'] : '';
				$unlike_href = !empty($_SESSION['user']) ? '/action/unlike?posting_id=' . $image['posting_id'] : '';
				
				if (!IS_LOGGED_IN) {
					//$like_href = 'javascript:loginscreen(\'login\');';
					$like_href = 'javascript:new_loginscreen();';
					$unlike_href = $like_href;
				}
				//var_dump($image);
				$profile_url = $this->user_profile_href($image['username']);
				?><li id="post-<?= $image['posting_id'] ?>" class="posting-<?= $image['posting_id'] ?> image-<?= $mod ?><?= !empty($image['is_liked']) ? ' liked' : '' ?>" data-posting_id="<?= $image['posting_id'] ?>">
					<? if(!empty($_SESSION['user']) && $image['user_id'] == $_SESSION['user']['user_id']): ?><a href="#" data-id="<?= $image['posting_id'] ?>" rel="delete"><div class="del-post" >delete</div></a><? endif ?>
                    <div class="image">
						<a href="<?= $details_url ?>" class="image color-<?= $i % 5 ?>" rel="modal">
                            <?
                            list($target_width, $target_height) = $this->image_dimensions[$mod];

                            $target_ratio = $target_width / $target_height;
                            $ratio = $image['width'] / $image['height'];

                            if ($target_ratio >= $ratio) {
                                $width = $target_width;
                                $height = ceil($image['height'] * ($target_width / $image['width']));
                            } else {
                                $height = $target_height;
                                $width = ceil($image['width'] * ($target_height / $image['height']));
                            }
                            /*data-width="<?= $image['width'] ?>"*/

                            if ($this->options['bare']) {
                                ?>
                                <img src="<?= $image['url'] ?>" data-src="<?= $image['url'] ?>"
                                     alt="<?= $image['description'] ?>"/>
                            <?
							}
							else {
								?>
								<img class="lazy zoom-in" src="/images/loading3.gif" data-src="<?= $image['url'] ?>&amp;width=<?= $width ?>&amp;height=<?= $height ?>" width="<?= $width ?>" height="<?= $height ?>" alt="<?= $image['description'] ?>" style="margin-top: -<?= floor(($height - $target_height) / 2) ?>px; margin-left: -<?= floor(($width - $target_width) / 2) ?>px;" />
								<?
							}
							?>
						</a>
						
						<? if($image['is_winner']): ?>
                            <p class="winner-tag">WINNER</p>
                        <? endif ?>

                        <p class="wild-4">
							<? if (!IS_LOGGED_IN): ?>
                            	<a href="#" onclick="javascript:new_loginscreen();">LOVE</a>
                            <? else: ?>
                            	<a href="<?= $like_href ?>" rel="like" data-undo_href="<?= $unlike_href ?>">LOVE</a>
                            <? endif ?>
						</p>
                            <div class="spine-social-box">
                            	<div class="spine-alien" onmouseover="$('this').children('.share').show();">
                                	<ul class="share">
                                        <div class="divot"></div>
                                        <div class="bridge"></div>

                                        <li class="facebook"><a href="#" onclick="facebookFeed('<?= $full_image_url ?>', 'http://www.dahliawolf.com/post/<?= $image['posting_id'] ?>', 'OMGeeezy this is the bombsteezy');">Facebook</a></li>

                                        <li class="twitter"> <a href="https://twitter.com/intent/tweet?original_referer=http://www.dahliawolf.com&url=http://www.dahliawolf.com/post/<?= $image['posting_id'] ?>" target="_blank">Tweet</a></li>
                                        
                                                                                                                       <li class="pinterest"><a href="http://pinterest.com/pin/create/button/?url=http://www.dahliawolf.com&media=<?= $full_image_url ?>" class="pin-it-button" count-layout="horizontal" target="_blank">Pin It</a></li>
                                    </ul>         
                                </div>
                                <p class="spine-comment"><?= $image['comments'] ?></p>                  
                            </div>
					</div>

                <p class="username">
                    <a href="<?= $profile_url ?>" class="dahliaHead" data-id="<?= $image['user_id'] ?>" ><?= $image['username'] ?></a>
                </p>

					<p class="like" style="bottom: -26px;">
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
				<div id="modal" class="modal">
					<div id="modal-content">
						<img id="modal-image" />
					</div>
				</div>
				<?
			}
		}
	}
	
	private function get_total_width() {
		$args = func_get_args();
		if (is_array($args[0])) {
			$args = $args[0];
		}
		
		$width = 0;
		foreach ($args as $i) {
			$width += $this->image_dimensions[$i][0] + $this->h;
		}
		
		return $width;
	}
	private function get_total_height() {
		$args = func_get_args();
		if (is_array($args[0])) {
			$args = $args[0];
		}
		
		$height = 0;
		foreach ($args as $i) {
			$height += $this->image_dimensions[$i][1] + $this->v;
		}
		
		return $height;
	}
	
	public function output_css() {
		$image_dimensions = $this->image_dimensions;
		$h = $this->h;
		$v = $this->v;
		?>
		.spine ul.images.mod-0 {
			height: <?= $this->get_total_height(0, 2, 4, 6) ?>px;
		}
		.spine ul.images.mod-8 {
			height: <?= $this->get_total_height(8, 10, 12, 14) ?>px;
		}
		<?
		$position_map = array(
			0 => array(-1 * $this->get_total_width(0), 0)
			, 1 => array(0, 0)
			, 2 => array(-1 * $this->get_total_width(2), $this->get_total_height(0)) 
			, 3 => array(0, $this->get_total_height(1))
			, 4 => array(-1 * $this->get_total_width(4), $this->get_total_height(0, 2))
			, 5 => array(0, $this->get_total_height(1, 3))
			, 6 => array(-1 * $this->get_total_width(6), $this->get_total_height(0, 2, 4))
			, 7 => array(0, $this->get_total_height(1, 3, 5))
			
			, 8 => array(-1 * $this->get_total_width(8), 0)
			, 9 => array(0, 0)
			, 10 => array(-1 * $this->get_total_width(10), $this->get_total_height(8)) 
			, 11 => array(0, $this->get_total_height(9))
			, 12 => array(-1 * $this->get_total_width(12), $this->get_total_height(8, 10))
			, 13 => array(0, $this->get_total_height(9, 11))
			, 14 => array(-1 * $this->get_total_width(14), $this->get_total_height(8, 10, 12))
			, 15 => array(0, $this->get_total_height(9, 11, 13))
		);
		foreach ($image_dimensions as $i => $dimensions) {
			$mod = $i % self::$spine_limit;
			
			if (!empty($position_map[$mod])) {
				list($left, $top) = $position_map[$mod];
				?>
				.spine ul.images li.image-<?= $mod ?> {
					left: <?= $left ?>px;
					top: <?= $top ?>px;
				}
				<?
			}
			else {
				?>
				.spine ul.images li.image-<?= $mod ?> {
					display: none;
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
		//return CR . '/profile?username=' . $username;
		return CR . '/' . $username;
	}
}
?>