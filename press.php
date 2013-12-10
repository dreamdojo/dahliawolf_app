<?php
    include $_SERVER['DOCUMENT_ROOT'] . "/head.php";
    include "header.php";

    $asa = Array();
    $asa[0] = Array('url', 'url', 'Mischa Barton', 'Former OC star, Mischa Barton wore the brightly colored, Tropicana Jacket from the DW Collectioi');
    $asa[1] = Array('url', 'url', 'Audrina Partridge', 'Hills star, Audrina Partridge wore the sleek, Modern Love Dress from the DW Collection.' );
    $asa[2] = Array('url', 'url', 'Mena Suvari', 'Mena Suvari looked stunning in the Sahara Dress' );
    $asa[3] = Array('url', 'url', 'Dani Thorne', 'Dani Thorne looked gorgeous showing her love in a Silver Brocade Dress' );
    $asa[4] = Array('url', 'url', 'Carly star, Jennette McCurdy ,wore the chic, Silver Ties Top from the DW Collection.' );

    $press = Array();
    $press[0] = Array('url', 'Life & Style', 'Chatting with co-owners Charles Park and Justin Mavandi at the Dahlia Wolf Launch party' );
    $press[1] = Array('url', 'OMG!', 'Mischa Barton, Audrina Partridge and more attend Dahlia Wolf launch party');
    $press[2] = Array('url', 'YAHOO!', 'The most stylish starts all came out for the launch of Dahlia Wolf. Which just goes to show fashion really does bring people together');
    $press[3] = Array('url', 'AOL', 'Mischa Barton, attends Dahlia Wolf launch party');
    $press[4] = Array('url', 'WONDERWALL', 'Mena Suvari attends a party to launch the fashion website, Dahlia Wolf, Fashion Made By You at Graffiti Cafe in Hollywood');
    $press[5] = Array('url', 'NICKUTOPIA', 'Gorgeous! Jennette McCurdy wore an adorable Dahlia Wolf outfit to the Dahlia Wolf clothing line launch on October 22, 2013. Jennette shared the photo and video here from her night!');

?>

<div class="transCol">
    <div class="goodieGrad"></div>
    <h1>AS SEEN ON</h1>
    <?php foreach($asa as $img): ?>
        <ul>
            <li><?= $img[0] ?></li>
            <li><?= $img[1] ?></li>
            <li><?= $img[2] ?></li>
            <li><?= $img[3] ?></li>
         </ul>
    <?php endforeach ?>
    <?php foreach($press as $img): ?>
        <ul>
            <li><?= $img[0] ?></li>
            <li><?= $img[1] ?></li>
            <li><?= $img[2] ?></li>
        </ul>
    <?php endforeach ?>
</div>