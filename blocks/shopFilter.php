<?php
    $url = 'http://dev.commerce.offlinela.com/1-0/category.json?function=get_categories&use_hmac_check=0';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $result = json_decode(curl_exec ($ch));
    curl_close ($ch);
?>

<div id="sort-bar">
    <div class="filter-wrap">
        Sort Products By:
        <?php foreach($result->data->get_categories as $category): ?>
            <span class="">
                <a class="sort-option" data-sort="<?= $category->category_id ?>" href="/"><?= $category->name ?></a>
            </span> /
        <? endforeach ?>

        <!--<span style="float: right;width: 150px;margin-right: -3px;">View: <span class=""><a id="selectSpine" class="sort-option" href="/vote">two</a></span> /
        <span class=""><a id="selectGrid" class="sort-option filter-select" href="/vote"> three</a></span>
        </span>-->
    </div>
</div>