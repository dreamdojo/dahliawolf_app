<?
die();
error_reporting(E_ALL);
ini_set('display_errors', '1');
set_time_limit(0);

require '../config/config.php';
require 'db.php';

$db = new db('mysql:host=127.0.0.1;dbname=admin_offline_v1_2013', 'offlineadmin', 'thuy');

$query = '
	SELECT user_username.user_id, old_members.*
	FROM old_members
		INNER JOIN dahliawolf_v1_2013.user_username ON old_members.USERID = user_username.member_id
	WHERE old_members.verified = 0
		AND old_members.profilepicture != ""
';
$result = $db->run($query);

echo '<pre>';
if (!empty($result)) {
	$rows = $result->fetchAll();
	if (!empty($rows)) {
		foreach ($rows as $i => $member) {
			$copy_result = copy(DR . '/import/mpics/o/' . $member['profilepicture'], DR . '/uploads/avatars/' . $member['user_id']);
			echo "\n" . (empty($copy_result) ? '<span style="color: #999;">Failed to copy' : 'Copied') . " /import/mpics/o/" . $member['profilepicture'] . ' to /uploads/avatars/' . $member['user_id'] . (empty($copy_result) ? '</span>' : '');
		}
	}
}
echo '</pre>';
?>