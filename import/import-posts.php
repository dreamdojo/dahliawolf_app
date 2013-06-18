<?
die();
error_reporting(E_ALL);
ini_set('display_errors', '1');
set_time_limit(0);

require '../config/config.php';
require 'db.php';

$db = new db('mysql:host=127.0.0.1;dbname=dahliawolf_v1_2013', 'offlineadmin', 'thuy');

$query = '
	SELECT old_posts.*, user_username.user_id
	FROM old_posts
		INNER JOIN user_username ON old_posts.USERID = user_username.member_id
	WHERE user_username.verified = 1 AND (PID BETWEEN 143 AND 143)
	ORDER BY old_posts.PID ASC
';
$result = $db->run($query);

echo '<pre>';
if (!empty($result)) {
	$rows = $result->fetchAll();
	
	$upload_dir = '/import/pics/';
	$source = 'http://' . $_SERVER['HTTP_HOST'] . $upload_dir;
	if (!empty($rows)) {
		foreach ($rows as $i => $post) {
			$imagename = $post['pic'];
			$image_url = $_SERVER['DOCUMENT_ROOT'] . $upload_dir . $imagename;
	
			// Grab and save remote image
			//$image = @file_get_contents('http://www.dahliawolf.com/pics/' . $post['pic']);
			$image = @file_get_contents('http://dahliawolf.bestworldsweb.com/pics/' . $post['pic']);
			
			if ($image) {
				file_put_contents($image_url, $image);
				$dimensions = @getimagesize($image_url);
				
				$params = array(
					'imagename' => $imagename
					, 'source' => $source
					, 'user_id' => $post['user_id']
					, 'description' => $post['ptitle']
					, 'dimensionsX' => $dimensions[0]
					, 'dimensionsY' => $dimensions[1]
				);
				$data = api_call('posting', 'add_post_image', $params, true);
				
				if (empty($data['success'])) {
					echo "\nFailed to save " . $post['pic'] . ":\n";
					echo '<span style="color: #999;">';
					print_r($data['errors']);
					echo '</span>';
				}
				else {
					echo "\nSaved " . $post['pic'];
				}
			}
			else {
				echo "\n<span style=\"color: #999;\">Failed to save " . $post['pic'] . '</span>';
			}
		}
	}
}
echo '</pre>';
?>