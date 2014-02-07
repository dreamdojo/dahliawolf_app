<<<<<<< HEAD
<?
die();

set_time_limit(0);

require '../config/config.php';
require 'db.php';

$db = new db('mysql:host=127.0.0.1;dbname=dahliawolf_v1_2013', 'offlineadmin', 'thuy');

$query = '
	
';
$result = $db->run($query);

echo '<pre>';
if (!empty($result)) {
	$rows = $result->fetchAll();
	
	if (!empty($rows)) {
	}
}
echo '</pre>';
?>