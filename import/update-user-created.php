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
	
';
$result = $db->run($query);

echo '<pre>';
if (!empty($result)) {
	$rows = $result->fetchAll();
	
	if (!empty($rows)) {
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
	
';
$result = $db->run($query);

echo '<pre>';
if (!empty($result)) {
	$rows = $result->fetchAll();
	
	if (!empty($rows)) {
	}
}
echo '</pre>';
>>>>>>> 5edbe6c9174c69dcc5e6287ce151d3df30e4799d
?>