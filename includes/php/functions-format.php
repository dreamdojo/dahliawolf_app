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
?>