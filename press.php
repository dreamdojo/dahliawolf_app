<?php
    include $_SERVER['DOCUMENT_ROOT'] . "/head.php";
    include "header.php";

    $asa = Array();
    $asa[0] = Array('/images/press/01.jpg', '/images/press/A.jpg', 'Mischa Barton', 'Former OC star, Mischa Barton wore the brightly colored <a href="/shop/107">Tropicana Jacket</a> from the DW Collection');
    $asa[1] = Array('/images/press/02.jpg', '/images/press/B.jpg', 'Audrina Partridge', 'Hills star, Audrina Partridge wore the sleek,  <a href="/shop/239">Modern Love Dress</a> from the DW Collection.' );
    $asa[2] = Array('/images/press/03.jpg', '/images/press/C.jpg', 'Mena Suvari', 'Mena Suvari looked stunning in the  <a href="/shop/240">Sahara Dress</a>' );
    $asa[3] = Array('/images/press/04.jpg', '/images/press/D.jpg', 'Dani Thorne', 'Dani Thorne looked gorgeous showing her love in a  <a href="/shop">Silver Brocade Dress</a>' );
    $asa[4] = Array('/images/press/05.jpg', '/images/press/E.jpg', 'Jenette McCurdy', 'Carly star, Jennette McCurdy ,wore the chic,  <a href="/shop">Silver Ties Top</a> from the DW Collection.' );

    $press = Array();
    $press[0] = Array('/images/press/lifeandstyle.jpg', 'Life & Style', 'Chatting with co-owners Charles Park and Justin Mavandi at the Dahlia Wolf Launch party' );
    $press[1] = Array('/images/press/omg.jpg', 'OMG!', 'Mischa Barton, Audrina Partridge and more attend Dahlia Wolf launch party');
    $press[2] = Array('/images/press/yahoo.jpg', 'YAHOO!', 'The most stylish starts all came out for the launch of Dahlia Wolf. Which just goes to show fashion really does bring people together');
    $press[3] = Array('/images/press/aol.jpg', 'AOL', 'Mischa Barton, attends Dahlia Wolf launch party');
    $press[4] = Array('/images/press/wonderwall.jpg', 'WONDERWALL', 'Mena Suvari attends a party to launch the fashion website, Dahlia Wolf, Fashion Made By You at Graffiti Cafe in Hollywood');
    $press[5] = Array('/images/press/nick.jpg', 'NICKUTOPIA', 'Gorgeous! Jennette McCurdy wore an adorable Dahlia Wolf outfit to the Dahlia Wolf clothing line launch on October 22, 2013. Jennette shared the photo and video here from her night!');
    $press[6] = Array('/images/press/extra.jpg', 'EXTRA', 'Mischa Barton, Audrina Partridge and more attend Dahlia Wolf launch party.');
    $press[7] = Array('/images/press/hp.jpg', 'HUFFINGTON POST', 'Mischa Barton, Audrina Partridge and more attend Dahlia Wolf launch party');

?>
<style>
    .transCol ul{height: 272px;text-align: left;padding-bottom: 35px;}
    .transCol ul a{color: #f03d64;}
    .transCol img{width: 100%;}
    .transCol .theBottomLine{float: left; width: 250px;border-bottom: #c2c2c2 thin solid;height: 272px;}
    .transCol .theBottomLine li:last-child{color: #949494;font-size: 12px;}
    .transCol h3{margin-top: 0px; margin-bottom: 25px;}
</style>

<div class="transCol">
    <h1>AS SEEN ON</h1>
    <?php foreach($asa as $img): ?>
        <ul>
            <li style="float: left; width: 250px;"><img src="<?= $img[0] ?>"></li>
            <li style="float: left; margin-right: 15px; width: 250px;"><img src="<?= $img[1] ?>"></li>
            <div class="theBottomLine">
                <li><h3><?= $img[2] ?></h3></li>
                <li><?= $img[3] ?></li>
            </div>
         </ul>
    <?php endforeach ?>
    <h1 style="margin-top: 25px;">PRESS</h1>
    <?php foreach($press as $img): ?>
        <ul>
            <li style="width: 500px; float: left; margin-right: 15px;"><img src="<?= $img[0] ?>"></li>
            <div class="theBottomLine">
                <li><h3><?= $img[1] ?></h3></li>
                <li><?= $img[2] ?></li>
            </div>
        </ul>
    <?php endforeach ?>
</div>

<?php
    include "footer.php";
?>