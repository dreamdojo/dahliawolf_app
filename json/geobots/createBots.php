<?php

    //$names = Array('girlcrisps','girlbiscuit','girlwaterskier','fencegirl',	'girlstud','irlbrawny','girltins','minigirl','girlpeat','girlwaitdisc','girlpistachio','ductgirl','girlcarpetfitter','ambiguousgirl','girlhomerun','girlthunder','slimgirl','girlteeth','girlpulp','girlcrunchy','landgirl','girlblush','girlplonk','girllibrarian','pigeongirl','girlrust','leadgirl','girlfrightened','plumbinggirl','spectaclesgirl','irritablegirl','girlpilcrow','girlfielding','girlelectric','crowngirl','acousticgirl','girlflint','girlflowery','girltaverner','blondgirl','girlfizzy','girlpartridge'.'secretgirl','girldisillusioned','girlorangedye','poxgirl','girlturn','crunchinggirl','flickgirl','knucklegirl', 'fashionjudicious','fashiondudgeon','fashionslender','stafffashion','fashionbevy','fashionuppity','wrestlingfashion','potionfashion','fashioncaribou','fashioninexpensive','fashionassorted','limpingfashion','fashionitemframe','deepfashion','fashionexcited','fashionrna','goldblockfashion','fashionduty','fashionmacho','fashionprints','cranniesfashion','fashioncrumble','fashionblot','fashionhunky','multipackfashion','dragonfashion','intestinefashion','fashionswift','turdiformfashion','unnaturalfashion','meniscusfashion','fashionhighly','fashiondiffidence','fashionslalom','buffalofashion','plausiblefashion','fashionrambunctious','fashiongay','fashionplugged','clankingfashion','fashionmarch','fashionglean','triathlonfashion','fashionglamorous','fashionelated','blarefashion','fashionpelican','technicianfashion','morticianfashion','jumbofashion','hauteliberated','hautecaring','hauteskirting','hautejobless','hauteclaptrap','hautevaluable','hauteshowers','barshaute','hauteprune','hautedopey','hautetrench','mischiefhaute','hautewasp','adaptablehaute','aerobicshaute','hautesticker','bootshaute','hauteplausible','chickenshaute','chaffinchhaute','hauteslash','hautehog','hautegarrulous','hautebeads','hautemysterious','hautebag','highhaute','hautelearned','bankhaute','pelvishaute','spottyhaute','synonymoushaute','hautebumblebee','hautetears','thrusthaute','goaliehaute','yobhaute','hautewitches','hautemoist','abhorrenthaute','stuffinghaute','hautegreen','hardhaute','hautecap','broodhaute','domineeringhaute','hauterazzamatazz','waitdischaute','dunkinghaute','hautefabulous');
    $users = Array();
    foreach($names as $i=>$user) {
        $url = 'http://api.dahliawolf.com/api.php?api=user&function=register&use_hmac_check=0&email=geoBot'.$i.'@dahliawolf.com&username='.$user.'&password=password&api_website_id=2';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = json_decode(curl_exec ($ch));
        curl_close ($ch);

        $users[$i] = $result;
    }
    /*$url = 'http://api.dahliawolf.com/api.php?api=user&function=register&use_hmac_check=0&email=testerosa2@dahliawolf.com&username=sarahsumpin2&password=password&api_website_id=2';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $result = json_decode(curl_exec ($ch));
    curl_close ($ch);*/

    echo json_encode($users);
?>