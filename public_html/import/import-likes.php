<<<<<<< HEAD
<?
die();
error_reporting(E_ALL);
ini_set('display_errors', '1');
set_time_limit(0);

require '../config/config.php';
require 'db.php';

$db = new db('mysql:host=127.0.0.1;dbname=dahliawolf_v1_2013', 'offlineadmin', 'thuy');

$query = '
	SELECT old_posts_fav.FID, posting.posting_id, user_username.user_id, image.pid
	FROM old_posts_fav
		INNER JOIN image ON old_posts_fav.PID = image.pid
		INNER JOIN posting ON image.id = posting.image_id
		INNER JOIN user_username ON old_posts_fav.USERID = user_username.member_id
	WHERE FID BETWEEN 11501 AND 11800
	ORDER BY FID ASC
';
$result = $db->run($query);

echo '<pre>';
if (!empty($result)) {
	$rows = $result->fetchAll();
	
	if (!empty($rows)) {
		foreach ($rows as $i => $like) {
			$params = array(
				'posting_id' => $like['posting_id']
				, 'user_id' => $like['user_id']
				, 'like_type_id' => 1
			);
			$data = api_call('posting', 'add_post_like', $params, true);
			
			if (empty($data['success'])) {
				echo "\nFailed to add post like for FID: " . $like['FID'] . ":\n";
				echo '<span style="color: #999;">';
				print_r($data['errors']);
				echo '</span>';
			}
			else {
				echo "\nSaved FID: " . $like['FID'];
			}
		}
	}
}
echo '</pre>';
=======
<?
die();
error_reporting(E_ALL);
ini_set('display_errors', '1');
set_time_limit(0);

require '../config/config.php';
require 'db.php';

$db = new db('mysql:host=127.0.0.1;dbname=dahliawolf_v1_2013', 'offlineadmin', 'thuy');

$query = '
	SELECT old_posts_fav.FID, posting.posting_id, user_username.user_id, image.pid
	FROM old_posts_fav
		INNER JOIN image ON old_posts_fav.PID = image.pid
		INNER JOIN posting ON image.id = posting.image_id
		INNER JOIN user_username ON old_posts_fav.USERID = user_username.member_id
	WHERE FID BETWEEN 11501 AND 11800
	ORDER BY FID ASC
';
$result = $db->run($query);

echo '<pre>';
if (!empty($result)) {
	$rows = $result->fetchAll();
	
	if (!empty($rows)) {
		foreach ($rows as $i => $like) {
			$params = array(
				'posting_id' => $like['posting_id']
				, 'user_id' => $like['user_id']
				, 'like_type_id' => 1
			);
			$data = api_call('posting', 'add_post_like', $params, true);
			
			if (empty($data['success'])) {
				echo "\nFailed to add post like for FID: " . $like['FID'] . ":\n";
				echo '<span style="color: #999;">';
				print_r($data['errors']);
				echo '</span>';
			}
			else {
				echo "\nSaved FID: " . $like['FID'];
			}
		}
	}
}
echo '</pre>';
>>>>>>> 5edbe6c9174c69dcc5e6287ce151d3df30e4799d
?>