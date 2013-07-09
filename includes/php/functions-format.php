<?
function date_array_to_string($date) {
	$dob_parts = array(
		str_pad($date['year'], 4, '0', STR_PAD_LEFT)
		, str_pad($date['month'], 2, '0', STR_PAD_LEFT)
		, str_pad($date['day'], 2, '0', STR_PAD_LEFT)
	);
	$dob = implode('-', $dob_parts);

	return $dob;
}

function ago($time)
{
   $periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
   $lengths = array("60","60","24","7","4.35","12","10");

   $now = time();

       $difference     = $now - $time;
       $tense         = "ago";

   for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
       $difference /= $lengths[$j];
   }

   $difference = round($difference);

   if($difference != 1) {
       $periods[$j].= "s";
   }

   return "$difference $periods[$j]";
}

function clean_string($string, $delimiter = '-', $replace_one_to_one = false) {
	// Character encoding
	setlocale(LC_ALL, 'en_US.UTF8');
	if (function_exists('iconv')) {
		$string = iconv('UTF-8', 'ASCII//TRANSLIT', $string);
	}

	$string = strip_tags($string);
	// Reverse HTML special chars (charset provided for &trade;, &hellip;, etc...)
	$string = html_entity_decode($string, ENT_COMPAT, 'cp1251');

	// Keep case insensitive alphanumeric & special chars to be replaced with delimiter (rather than removing)
	$chars = '.\/_|+ -';
	$string = preg_replace("/[^a-z0-9" . $chars . "]/i", '', $string);

	// Convert to lowercase, replace (repeating) special chars and trim
	$string = strtolower($string);
	$regex = "[" . $chars . "]";
	if (!$replace_one_to_one) {
		$regex .= "+";
	}

	$string = preg_replace("/" . $regex . "/", $delimiter, $string);

	if (!$replace_one_to_one) {
		$string = trim($string, $delimiter);
	}

	return $string;
}
?>