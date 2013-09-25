<div id="sort-bar">
    <div class="filter-wrap">
        Sort Inspirations By:
        <span class="">
            <a class="sort-option <?= ($_GET['sort'] == 'new' || empty($_GET['sort']) ? 'filter-select' : '') ?>" href="/spine?sort=new">newest</a></span> /
        <span class=""><a id="filterTrending" class="sort-option <?= ($_GET['sort'] == 'hot' ? 'filter-select' : '') ?>" href="/spine?sort=hot"> trending</a></span> /
        <span class=""><a class="sort-option <?= ($_GET['sort'] == 'top' ? 'filter-select' : '') ?>" href="/spine?sort=top"> most popular</a></span>
        <? if (IS_LOGGED_IN): ?>
             /<span class=""><a class="sort-option <?= ($_GET['sort'] == 'following' ? 'filter-select' : '') ?>" href="/spine?sort=following"> following</a></span>
        <? endif ?>
        <span style="float: right;width: 150px;margin-right: -3px;">View: <span class=""><a id="selectSpine" class="sort-option" href="/spine">two</a></span> /
        <span class=""><a id="selectGrid" class="sort-option filter-select" href="/grid"> three</a></span>
        </span>
    </div>
</div>