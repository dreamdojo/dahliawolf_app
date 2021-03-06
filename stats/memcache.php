<?php

/**
 * User: JDorado
 * Date: 7/30/13
 */

##########################################
if( isset($_GET['print']) ) getMemcacheKeys();
##########################################

function getMemcacheKeys() {
    $memcache = new Memcache;
    $memcache->connect('127.0.0.1', 11211)
       or die ("Could not connect to memcache server");

    $list = array();
    $allSlabs = $memcache->getExtendedStats('slabs');
    $items = $memcache->getExtendedStats('items');
    foreach($allSlabs as $server => $slabs) {
        foreach($slabs AS $slabId => $slabMeta) {
            $cdump = $memcache->getExtendedStats('cachedump',(int)$slabId);
            foreach($cdump AS $keys => $arrVal) {
                if (!is_array($arrVal)) continue;
                foreach($arrVal AS $k => $v) {
                    $val = $memcache->get($k);
                    echo "$k => \n" . var_export($val, true) .'<br>';
                }
            }
        }
    }
}

?>